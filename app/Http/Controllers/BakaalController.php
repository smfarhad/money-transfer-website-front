<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoneyTransfer;
use App\Models\TransferComplete;
use App\Models\BakaalFail;
use App\Models\AgentList;
use App\Models\Country;
use App\Models\Conversion;
use App\Models\Conversion_history;
use DB;
use Illuminate\Routing\UrlGenerator;

class BakaalController extends Controller {

    private $curl;
    private $login;

    public function __construct() {
        $this->curl = curl_init();
        $this->login = $this->login();
    }

    public function addRemittance() {
        
        $bakalUrl = $this->isProduction()."AddRemittance";
        $token = $this->login;
        $curl = $this->curl;
        $remittances = MoneyTransfer::leftJoin('recipient as r', 'money_transfer.recipient_id', '=', 'r.id')
                       ->leftJoin('user_info as u', 'u.id', '=', 'r.user_id')
                       ->leftJoin('country as c', 'money_transfer.destination_country', '=', 'c.id')
                       ->select('money_transfer.id as transfer_id', 'money_transfer.date_create', 'money_transfer.note','money_transfer.status',
                        'money_transfer.source_amount','money_transfer.source_amount_usd', 'money_transfer.receive_type', 'money_transfer.fees','money_transfer.fees_usd', 'money_transfer.admin_id', 'c.country_code','c.name as country_name',
                        'r.id as recipient_id', 'r.id as destination_country','money_transfer.convertion_rate','money_transfer.destination_amount',
                        'r.first_name as recipient_name', 
                        'r.address_1 as recipient_address', 'r.suburb', 'r.postcode', 'r.city', 'r.mobile as recipent_mobile', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as sender_name"), 
                        'u.address_1 as s_address', 'u.postcode as s_postcode', 'u.city as s_city', 'u.mobile as sender_mobile', 'u.personnumber')
                ->where('money_transfer.status',1)
                ->where('money_transfer.receive_type',1)
                ->get();
        if($remittances->count() > 0){
            
        } else {
            return ;
        }
        $i = 0;
        $response_arry = [];
        foreach ($remittances as $remittance) {
            $remittance->DOB = $this->personNumberToDOB($remittance->personnumber);

            $data = array(
                'OriginCountry' => 'SE',
                'DestinationCountry' => $remittance->country_code,
                'ConfirmDate' => strtoupper(date('d-M-Y', strtotime($remittance->date_create))),
                'DAmt' => $remittance->source_amount_usd,
                'DCommAmt' => $remittance->fees_usd,
                'RName' => $remittance->recipient_name,
                'RAddress' => $remittance->recipient_address.', '.$remittance->country_name,
                'RMobile1' => $remittance->recipent_mobile,
                'SName' => $remittance->sender_name,
                'SAddress' => $remittance->s_address. ', ' . $remittance->s_postcode.', '.$remittance->s_city.', Sweden',
                'SMobile1' => $remittance->sender_mobile,
                'DOB' => $remittance->DOB,
                'IdentityType' => 'ID',
                'IdentityDesc' => $remittance->personnumber,
                'IdExpiryDate' => '30-JAN-2019',
                'ModifiedBy' => 'IHIMILO',
                'SourceTransNo' => $remittance->transfer_id  // must be uniq
            );
            $json = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => $bakalUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Authorization:" . $token,
                    "cache-control: no-cache",
                    // "Token: ".$token."", // need to send new token
                    "content-type: application/json"
                ),
                CURLOPT_POSTFIELDS => $json
            ));

            $response = curl_exec($curl);
            $response_process = json_decode($response, true);
            $response_process['transferId'] = $remittance->transfer_id;
            if(!empty($response_process['TransNo'])){
               $response_process['OurStatus'] = 2;
            MoneyTransfer::where('id', $remittance->transfer_id)
                           ->update(['status'=> 2]);
            $input = [];
            $input['transfer_id']               = $remittance->transfer_id; 
            $input['bakaal_TransNo']            = $response_process['TransNo']; 
            $input['recipient_id']              = $remittance->recipient_id;
            $input['source_amount']             = $remittance->source_amount;
            $input['source_amount_usd']         = $remittance->source_amount_usd;
            $input['fees']                      = $remittance->fees;
            $input['fees_usd']                  = $remittance->fees_usd;
            $input['receive_type']              = $remittance->receive_type;
            $input['source_total']              = ($remittance->source_amount+$remittance->fees);
            $input['destination_country']       = $remittance->destination_country;
            $input['conversion_rate']           = $remittance->convertion_rate;
            $input['destination_amount']        = $remittance->destination_amount;
            $input['admin_id']                  = $remittance->admin_id;
            $input['note']                      = $remittance->note;
            $input['status']                    = 2;
            $input['date_create']               = $remittance->date_create;
            $input['date_execution']            = date('Y-m-d H:i:s');
            TransferComplete::create($input);
            } else {
                $response_process['OurStatus'] = 3;
                MoneyTransfer::where('id',$remittance->transfer_id)->update(['status'=>3]);
                $bakaalFial = [
                    'transfer_id' =>    $remittance->transfer_id, 
                    'code'        =>    $response_process['code'],
                    'description' =>    $response_process['description'],
                    'date_create' =>    date('Y-m-d H:i:s')
                ];
                BakaalFail::create($bakaalFial);
            }
            $err = curl_error($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response_arry[$i] = $response_process;
            }
            $i++;
        }
        curl_close($curl);
        return $response_arry;
    }

    public function addMMTRemittance() {
        $bakalUrl = $this->isProduction()."AddMMTRemittance";
        $token = $this->login;
        $curl = $this->curl;
        $remittances = MoneyTransfer::leftJoin('recipient as r', 'money_transfer.recipient_id', '=', 'r.id')
                       ->leftJoin('user_info as u', 'u.id', '=', 'r.user_id')
                       ->leftJoin('country as c', 'money_transfer.destination_country', '=', 'c.id')
                       ->select('money_transfer.id as transfer_id', 'money_transfer.date_create', 'money_transfer.note','money_transfer.status',
                        'money_transfer.source_amount','money_transfer.source_amount_usd', 'money_transfer.receive_type', 'money_transfer.fees','money_transfer.fees_usd', 'money_transfer.admin_id', 'c.country_code','c.name as country_name',
                        'r.id as recipient_id', 'r.id as destination_country','money_transfer.convertion_rate','money_transfer.destination_amount',
                        'r.first_name as recipient_name', 
                        'r.address_1 as recipient_address', 'r.suburb', 'r.postcode', 'r.city', 'r.mobile as recipent_mobile', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as sender_name"), 
                        'u.address_1 as s_address', 'u.postcode as s_postcode', 'u.city as s_city', 'u.mobile as sender_mobile', 'u.personnumber')
                ->where('money_transfer.status',1)
                ->where('money_transfer.receive_type',2)
                ->where('c.id',196) // only Somalia
                ->get();
        if($remittances->count() > 0){
            
        } else {
            return ;
        }
        $i = 0;
        $response_arry = [];
        foreach ($remittances as $remittance) {
            $remittance->DOB = $this->personNumberToDOB($remittance->personnumber);

            $data = array(
                'OriginCountry' => 'SE',
                'DestinationCountry' => $remittance->country_code,
                'ConfirmDate' => strtoupper(date('d-M-Y', strtotime($remittance->date_create))),
                'DAmt' => $remittance->source_amount_usd,
                'DCommAmt' => $remittance->fees_usd,
                'RName' => $remittance->recipient_name,
                'RAddress' => $remittance->recipient_address.', '.$remittance->country_name,
                'RMobile1' => $remittance->recipent_mobile,
                'SName' => $remittance->sender_name,
                'SAddress' => $remittance->s_address. ', ' . $remittance->s_postcode.', '.$remittance->s_city.', Sweden',
                'SMobile1' => $remittance->sender_mobile,
                'DOB' => $remittance->DOB,
                'IdentityType' => 'ID',
                'IdentityDesc' => $remittance->personnumber,
                'IdExpiryDate' => '30-JAN-2019',
                'ModifiedBy' => 'IHIMILO',
                'SourceTransNo' => $remittance->transfer_id  // must be uniq
            );
            $json = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => $bakalUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Authorization:" . $token,
                    "cache-control: no-cache",
                    // "Token: ".$token."", // need to send new token
                    "content-type: application/json"
                ),
                CURLOPT_POSTFIELDS => $json
            ));

            $response = curl_exec($curl);
            $response_process = json_decode($response, true);
            $response_process['transferId'] = $remittance->transfer_id;
            if(!empty($response_process['TransNo'])){
               $response_process['OurStatus'] = 2;
            MoneyTransfer::where('id', $remittance->transfer_id)
                           ->update(['status'=> 2]);
            $input = [];
            $input['transfer_id']               = $remittance->transfer_id; 
            $input['bakaal_TransNo']            = $response_process['TransNo']; 
            $input['recipient_id']              = $remittance->recipient_id;
            $input['source_amount']             = $remittance->source_amount;
            $input['source_amount_usd']         = $remittance->source_amount_usd;
            $input['fees']                      = $remittance->fees;
            $input['fees_usd']                  = $remittance->fees_usd;
            $input['receive_type']              = $remittance->receive_type;
            $input['source_total']              = ($remittance->source_amount+$remittance->fees);
            $input['destination_country']       = $remittance->destination_country;
            $input['conversion_rate']           = $remittance->convertion_rate;
            $input['destination_amount']        = $remittance->destination_amount;
            $input['admin_id']                  = $remittance->admin_id;
            $input['note']                      = $remittance->note;
            $input['status']                    = 2;
            $input['date_create']               = $remittance->date_create;
            $input['date_execution']            = date('Y-m-d H:i:s');
            TransferComplete::create($input);
          
            } else {
                $response_process['OurStatus'] = 3;
                MoneyTransfer::where('id',$remittance->transfer_id)->update(['status'=>3]);
                $bakaalFial = [
                    'transfer_id' =>    $remittance->transfer_id, 
                    'code'        =>    $response_process['code'],
                    'description' =>    $response_process['description'],
                    'date_create' =>    date('Y-m-d H:i:s')
                ];
                BakaalFail::create($bakaalFial);
            }
            $err = curl_error($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response_arry[$i] = $response_process;
            }
            $i++;
        }
        curl_close($curl);
        return $response_arry;
    }     

    public function addMpesaRemittance() {
        $bakalUrl = $this->isProduction()."AddMPESARemittance";
        $token = $this->login;
        $curl = $this->curl;
        $remittances = MoneyTransfer::leftJoin('recipient as r', 'money_transfer.recipient_id', '=', 'r.id')
                       ->leftJoin('user_info as u', 'u.id', '=', 'r.user_id')
                       ->leftJoin('country as c', 'money_transfer.destination_country', '=', 'c.id')
                       ->select('money_transfer.id as transfer_id', 'money_transfer.date_create', 'money_transfer.note','money_transfer.status',
                        'money_transfer.source_amount','money_transfer.source_amount_usd', 'money_transfer.receive_type', 'money_transfer.fees','money_transfer.fees_usd', 'money_transfer.admin_id', 'c.country_code','c.name as country_name',
                        'r.id as recipient_id', 'r.id as destination_country','money_transfer.convertion_rate','money_transfer.destination_amount',
                        'r.first_name as recipient_name', 
                        'r.address_1 as recipient_address', 'r.suburb', 'r.postcode', 'r.city', 'r.mobile as recipent_mobile', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as sender_name"), 
                        'u.address_1 as s_address', 'u.postcode as s_postcode', 'u.city as s_city', 'u.mobile as sender_mobile', 'u.personnumber')
                ->where('money_transfer.status',1)
                ->where('money_transfer.receive_type',2)
                ->where('c.id',114) // only for kenya
                ->get();
        if($remittances->count() > 0){
            
        } else {
            return ;
        }
        $i = 0;
        $response_arry = [];
        foreach ($remittances as $remittance) {
            $remittance->DOB = $this->personNumberToDOB($remittance->personnumber);

            $data = array(
                'OriginCountry' => 'SE',
                'DestinationCountry' => $remittance->country_code,
                'ConfirmDate' => strtoupper(date('d-M-Y', strtotime($remittance->date_create))),
                'DAmt' => $remittance->source_amount_usd,
                'DCommAmt' => $remittance->fees_usd,
                'RName' => $remittance->recipient_name,
                'RAddress' => $remittance->recipient_address.', '.$remittance->country_name,
                'RMobile1' => $remittance->recipent_mobile,
                'SName' => $remittance->sender_name,
                'SAddress' => $remittance->s_address. ', ' . $remittance->s_postcode.', '.$remittance->s_city.', Sweden',
                'SMobile1' => $remittance->sender_mobile,
                'DOB' => $remittance->DOB,
                'IdentityType' => 'ID',
                'IdentityDesc' => $remittance->personnumber,
                'IdExpiryDate' => '30-JAN-2019',
                'ModifiedBy' => 'IHIMILO',
                'SourceTransNo' => $remittance->transfer_id  // must be uniq
            );
            $json = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => $bakalUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Authorization:" . $token,
                    "cache-control: no-cache",
                    // "Token: ".$token."", // need to send new token
                    "content-type: application/json"
                ),
                CURLOPT_POSTFIELDS => $json
            ));

            $response = curl_exec($curl);
            $response_process = json_decode($response, true);
            $response_process['transferId'] = $remittance->transfer_id;
            if(!empty($response_process['TransNo'])){
               $response_process['OurStatus'] = 2;
            MoneyTransfer::where('id', $remittance->transfer_id)
                           ->update(['status'=> 2]);
            $input = [];
            $input['transfer_id']               = $remittance->transfer_id; 
            $input['bakaal_TransNo']            = $response_process['TransNo']; 
            $input['recipient_id']              = $remittance->recipient_id;
            $input['source_amount']             = $remittance->source_amount;
            $input['source_amount_usd']         = $remittance->source_amount_usd;
            $input['fees']                      = $remittance->fees;
            $input['fees_usd']                  = $remittance->fees_usd;
            $input['receive_type']              = $remittance->receive_type;
            $input['source_total']              = ($remittance->source_amount+$remittance->fees);
            $input['destination_country']       = $remittance->destination_country;
            $input['conversion_rate']           = $remittance->convertion_rate;
            $input['destination_amount']        = $remittance->destination_amount;
            $input['admin_id']                  = $remittance->admin_id;
            $input['note']                      = $remittance->note;
            $input['status']                    = 2;
            $input['date_create']               = $remittance->date_create;
            $input['date_execution']            = date('Y-m-d H:i:s');
            TransferComplete::create($input);
          
            } else {
                $response_process['OurStatus'] = 3;
                MoneyTransfer::where('id',$remittance->transfer_id)->update(['status'=>3]);
                $bakaalFial = [
                    'transfer_id' =>    $remittance->transfer_id, 
                    'code'        =>    $response_process['code'],
                    'description' =>    $response_process['description'],
                    'date_create' =>    date('Y-m-d H:i:s')
                ];
                BakaalFail::create($bakaalFial);
            }
            $err = curl_error($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response_arry[$i] = $response_process;
            }
            $i++;
        }
        curl_close($curl);
        return $response_arry;
    }   
    
    public function addMMTAfricaRemittance(){
        
        $bakalUrl = $this->isProduction()."MMTAfricaAddRemittance";
        $token = $this->login;
        $curl = $this->curl;
        $remittances = MoneyTransfer::leftJoin('recipient as r', 'money_transfer.recipient_id', '=', 'r.id')
                       ->leftJoin('user_info as u', 'u.id', '=', 'r.user_id')
                       ->leftJoin('country as c', 'money_transfer.destination_country', '=', 'c.id')
                       ->select('money_transfer.id as transfer_id', 'money_transfer.date_create', 'money_transfer.note','money_transfer.status',
                        'money_transfer.source_amount','money_transfer.source_amount_usd', 'money_transfer.receive_type', 'money_transfer.fees','money_transfer.fees_usd', 'money_transfer.admin_id', 'c.country_code','c.name as country_name',
                        'r.id as recipient_id', 'r.id as destination_country','money_transfer.convertion_rate','money_transfer.destination_amount',
                        'r.first_name as recipient_name', 
                        'r.address_1 as recipient_address', 'r.suburb', 'r.postcode', 'r.city', 'r.mobile as recipent_mobile', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as sender_name"), 
                        'u.address_1 as s_address', 'u.postcode as s_postcode', 'u.city as s_city', 'u.mobile as sender_mobile', 'u.personnumber')
                ->where('money_transfer.status',1)
                ->where('money_transfer.receive_type',2)
                ->whereIn('c.id', [22,66,81,130,182,229]) //some countries
               // ->whereIn('c.id', [22,66,81,130,182,229]) //some countries
               //->whereIn('c.id', [66, 229,129,37,130,158,81,182]) //some countries
                                   
                ->get();
        
        if($remittances->count() > 0){
            
        } else {
            return ;
        }
        
        $i = 0;
        $response_arry = [];
        foreach ($remittances as $remittance) {
            $remittance->DOB = $this->personNumberToDOB($remittance->personnumber);

            $data = array(
                'OriginCountry' => 'SE',
                'DestinationCountry' => $remittance->country_code,
                'ConfirmDate' => strtoupper(date('d-M-Y', strtotime($remittance->date_create))),
                'DAmt' => $remittance->source_amount_usd,
                'DCommAmt' => $remittance->fees_usd,
                'RName' => $remittance->recipient_name,
                'RAddress' => $remittance->recipient_address.', '.$remittance->country_name,
                'RMobile1' => $remittance->recipent_mobile,
                'SName' => $remittance->sender_name,
                'SAddress' => $remittance->s_address. ', ' . $remittance->s_postcode.', '.$remittance->s_city.', Sweden',
                'SMobile1' => $remittance->sender_mobile,
                'DOB' => $remittance->DOB,
                'IdentityType' => 'ID',
                'IdentityDesc' => $remittance->personnumber,
                'IdExpiryDate' => '30-JAN-2019',
                'ModifiedBy' => 'IHIMILO',
                'SourceTransNo' => $remittance->transfer_id  // must be uniq
            );
            
            $json = json_encode($data);
            
            

            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $bakalUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Authorization:" . $token,
                    "cache-control: no-cache",
                    // "Token: ".$token."", // need to send new token
                    "content-type: application/json"
                ),
                CURLOPT_POSTFIELDS => $json
            ));

            $response = curl_exec($curl);
            $response_process = json_decode($response, true);
            $response_process['transferId'] = $remittance->transfer_id;
            if(!empty($response_process['TransNo'])){
               $response_process['OurStatus'] = 2;
            MoneyTransfer::where('id', $remittance->transfer_id)
                           ->update(['status'=> 2]);
            $input = [];
            $input['transfer_id']               = $remittance->transfer_id; 
            $input['bakaal_TransNo']            = $response_process['TransNo']; 
            $input['recipient_id']              = $remittance->recipient_id;
            $input['source_amount']             = $remittance->source_amount;
            $input['source_amount_usd']         = $remittance->source_amount_usd;
            $input['fees']                      = $remittance->fees;
            $input['fees_usd']                  = $remittance->fees_usd;
            $input['receive_type']              = $remittance->receive_type;
            $input['source_total']              = ($remittance->source_amount+$remittance->fees);
            $input['destination_country']       = $remittance->destination_country;
            $input['conversion_rate']           = $remittance->convertion_rate;
            $input['destination_amount']        = $remittance->destination_amount;
            $input['admin_id']                  = $remittance->admin_id;
            $input['note']                      = $remittance->note;
            $input['status']                    = 2;
            $input['date_create']               = $remittance->date_create;
            $input['date_execution']            = date('Y-m-d H:i:s');
            TransferComplete::create($input);
          
            } else {
                $response_process['OurStatus'] = 3;
                MoneyTransfer::where('id',$remittance->transfer_id)->update(['status'=>3]);
                $bakaalFial = [
                    'transfer_id' =>    $remittance->transfer_id, 
                    'code'        =>    $response_process['code'],
                    'description' =>    $response_process['description'],
                    'date_create' =>    date('Y-m-d H:i:s')
                ];
                BakaalFail::create($bakaalFial);
            }
            $err = curl_error($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response_arry[$i] = $response_process;
            }
            $i++;
        }
        curl_close($curl);
        return $response_arry;
    }
    
    public function smsAfterMoneyDelivery(){
        $bakalUrl = $this->isProduction()."GetRemittanceStatus";
        $token = $this->login;
        $curl = $this->curl;
        
        /*** get the customer transaction list which is complete successfully ***/
        
        $remittances = TransferComplete::leftJoin('recipient as r', 'transfer_complete.recipient_id', '=', 'r.id')
            ->leftJoin('user_info as u', 'u.id', '=', 'r.user_id')
            ->select('transfer_complete.id','transfer_id', 'bakaal_TransNo', 'transfer_complete.source_amount as amount', 'u.mobile as mobile', 'r.first_name as recipient_name')
            ->where(['status'=>2])
            ->where(['sms_send'=>0])
//             ->whereRaw('Date(date_execution) = CURDATE()')
            ->get();
        
//         echo count($remittances);
//         var_dump($remittances);
//         print_r($remittances);
//         exit();

        if($remittances->count() > 0){
            
        } else {
            echo 'no result';
            return ;
        }
        
        $i = 0;
        $response_arry = [];
        foreach ($remittances as $remittance) {
            
            $data = array(
                'TransNo' => $remittance->bakaal_TransNo,
                'ModifiedBy' => 'IHIMILO'
            );
            
            $json = json_encode($data);
            
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $bakalUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Authorization:" . $token,
                    "cache-control: no-cache",
                    // "Token: ".$token."", // need to send new token
                    "content-type: application/json"
                ),
                CURLOPT_POSTFIELDS => $json
            ));
            
            $response = curl_exec($curl);
            $response_process = json_decode($response, true);
            $response_process['transferId'] = $remittance->transfer_id;
            
//             echo $remittance->mobile;
//             print_r($response_process);
//             exit();
            
            if(!empty($response_process['TransNo']) && $response_process['Status'] == 'DE'){
                /*** SEND SMS ***/
                $curl = curl_init();
                $from = "Himilo AB";
                $to = $remittance->mobile; //'46730449308'; // customer number should be here                               
//                 Lacagtii (amount)  aad u dirtay "Reciever's name" waa la bixiyay . The remittance was paid to "reciever's name". Mahadsanid
                $text = 'Lacagtii ('.$remittance->amount.')  aad u dirtay '.$remittance->recipient_name.' waa la bixiyay. The remittance was paid to '.$remittance->recipient_name. 'Mahadsanid';
               
//                 $text = 'Hi,'. "\n". 'Your transaction ID : '.$remittance->transfer_id." has been delivered successfully";
               
//                 echo $text;
                
//                 exit();
                // The data to send to the API
                $data = "from=".$from."&to=".$to."&text=".$text;
                    
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.zignsec.com/v2/mmessaging", // test.zignsec.com
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_HTTPHEADER => array(
                            "authorization: 448c77b9-4d2a-4201-84ac-9a3d844f7146", // test e28abe50-a2b1-4a4d-90c0-d95b3146dcbd
                            "cache-control: no-cache",
                            "Token: 448c77b9-4d2a-4201-84ac-9a3d844f7146", // need to send new token
                            "content-type: application/x-www-form-urlencoded",
                        ),
                        CURLOPT_POSTFIELDS => $data
                    ));
                    
                    $response_sms = curl_exec($curl);
                    $err = curl_error($curl);
                    
//                     echo $response_sms;
                    
                    if ($err) {
                        //   echo "cURL Error #:" . $err;
                        TransferComplete::where('id', $remittance->id)
                        ->update(['sms_send'=> 2]);
                    } else {
                        //  echo $response;
                        /*** UPDATE THE TRANSFER_COMPLETE.SMS_SEND = 1 ***/
                        
                        TransferComplete::where('id', $remittance->id)
                        ->update(['sms_send'=> 1]);
                    }     
                    
                /*** end SMS send ***/
            } else {
                /*** UPDATE THE TRANSFER_COMPLETE.SMS_SEND = 2 ***/             
                
//                 TransferComplete::where('id', $remittance->id)
//                 ->update(['sms_send'=> 2]);
              
            }
            $err = curl_error($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response_arry[$i] = $response_process;
            }
            $i++;
        }
        curl_close($curl);
        return $response_arry;
    }
    
    public function getRemittanceStatus() {
        $bakalUrl = $this->isProduction()."GetRemittanceStatus";
        $token = $this->login;
        $curl = $this->curl;
        $remittances = TransferComplete::select('transfer_id', 'bakaal_TransNo')
                       ->where(['status'=>4])
                       ->where(['status'=>5])
                       ->where(['status'=>101])
                       ->get();
        $i = 0;
        $response_arry = [];
        foreach ($remittances as $remittance) {
            $data = array(
                'TransNo' => $remittance->bakaal_TransNo,
                'ModifiedBy' => 'IHIMILO'
            );
            $json = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => $bakalUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Authorization:" . $token,
                    "cache-control: no-cache",
                    // "Token: ".$token."", // need to send new token
                    "content-type: application/json"
                ),
                CURLOPT_POSTFIELDS => $json
            ));

            $response = curl_exec($curl);
            $response_process = json_decode($response, true);
            $response_process['transferId'] = $remittance->transfer_id;
            if(isset($response_process['TransNo']) && isset($response_process['Status'])){
                if($response_process['Status'] == "AP"){
                  TransferComplete::where('transfer_id', $remittance->transfer_id)
                               ->update(['status'=> 4]);
                }elseif ($response_process['Status'] == "CC") {
                   TransferComplete::where('transfer_id', $remittance->transfer_id)
                               ->update(['status'=> 5]); 
                } else{
                    TransferComplete::where('transfer_id', $remittance->transfer_id)
                               ->update(['status'=> 101]); 
                }
            } else {
                MoneyTransfer::where('id',$remittance->transfer_id)->update(['status'=>3]);
                $bakaalFial = [
                    'transfer_id' =>    $remittance->transfer_id, 
                    'code'        =>    $response_process['code'],
                    'description' =>    $response_process['description'],
                    'date_create' =>    date('Y-m-d H:i:s')
                ];
                BakaalFail::create($bakaalFial);
            }
            $err = curl_error($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response_arry[$i] = $response_process;
            }
            $i++;
        }
        curl_close($curl);
        return $response_arry;
    }

    public function getExchangeRate() {
       $bakalUrl = $this->isProduction()."GetExchangeRate";
        $token = $this->login;
        $curl = $this->curl;
        $countryList = Country::leftJoin('conversion as c', 'c.country_id', '=', 'country.id')
                ->select('country.id','country.name','country.country_code',
                        'c.id as conversion_id','c.country_id', 'c.rate')
                ->where('isAvailable',1)->get();
        $i = 0;
        $response_arry = [];
        foreach ($countryList as $value) {
            $data = array(
                'DestinationCountry' => $value->country_code,
                'ModifiedBy' => 'IHIMILO'
            );
            $json = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => $bakalUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Authorization:" . $token,
                    "cache-control: no-cache",
                    // "Token: ".$token."", // need to send new token
                    "content-type: application/json"
                ),
                CURLOPT_POSTFIELDS => $json
            ));

            $response = curl_exec($curl);
            $response_process = json_decode($response, true);
            $response_process['Country'] = $value->name;
            $response_process['CountryCode'] = $value->country_code;
            if(isset($response_process['ConvRate'])){
                Conversion::where('country_id',$value->id)
                        ->update(
                                [
                                    'rate'=>$response_process['ConvRate']]
                                );
                Conversion_history::create(
                [
                    'conversion_id'=>$value->conversion_id, 
                    'rate_new'=>$response_process['ConvRate'],
                    'rate_old'=>$value->rate,
                ]); 
                
            } else {
//                MoneyTransfer::where('id',$remittance->transfer_id)->update(['status'=>3]);
//                $bakaalFial = [
//                    'transfer_id' =>    $remittance->transfer_id, 
//                    'code'        =>    $response_process['code'],
//                    'description' =>    $response_process['description'],
//                    'date_create' =>    date('Y-m-d H:i:s')
//                ];
//                BakaalFail::create($bakaalFial);
            }
            $err = curl_error($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response_arry[$i] = $response_process;
            }
            $i++;
        }
        curl_close($curl);
        return $response_arry;
    }

    public function getAgentsList() {
        $bakalUrl = $this->isProduction()."GetAgentsList";
        $token = $this->login;
        $curl = $this->curl;

        $data = array(
            'ModifiedBy' => 'IHIMILO'
        );

        $json = json_encode($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $bakalUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . $token,
                "cache-control: no-cache",
                // "Token: ".$token."", // need to send new token
                "content-type: application/json"
            ),
            CURLOPT_POSTFIELDS => $json
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // echo 'Test';

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
    
    public function MMTAfricaGetAllowedCountries() {
        $bakalUrl = $this->isProduction()."MMTAfricaGetAllowedCountries";
        $token = $this->login;
        $curl = $this->curl;

        $data = array('ModifiedBy' => 'IHIMILO');
   
        $json = json_encode($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $bakalUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . $token,
                "cache-control: no-cache",
                // "Token: ".$token."", // need to send new token
                "content-type: application/json"
            ),
            CURLOPT_POSTFIELDS => $json
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // echo 'Test';

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }        
    }

    private function login(){
        $bakalUrl = $this->isProduction()."login";
        $curl = $this->curl;
        
        $data_1 = $this->isProductionArray();
        
        $json = json_encode($data_1);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $bakalUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                // "authorization: e28abe50-a2b1-4a4d-90c0-d95b3146dcbd",
                "cache-control: no-cache",
                "Token: 5f9b35a9-3ab5-5c67-2592-7999a59e9743", // need to send new token
                "content-type: application/json"
            ),
            CURLOPT_POSTFIELDS => $json
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            // echo json_decode($response);
            // echo "<br>".$response->token;
            // Convert JSON string to Array
            $someArray = json_decode($response, true);
            // print_r($someArray); // Dump all data of the Array
            // echo $someArray["token"]; // Access Array data
            // Convert JSON string to Object
            // $someObject = json_decode($response);
            // print_r($someObject); // Dump all data of the Object
            // echo $someObject->token; // Access Object data
        }

        return $someArray ["token"];
    }

    private function personNumberToDOB($personNumber) {
        $year = substr($personNumber, 0, -8);
        $month = substr($personNumber, 4, -6);
        $day = substr($personNumber, 6, -4);
        //return $year.'-'.$month.'-'.$day;
        $DOB = strtoupper(date('d-M-Y', strtotime($year . '-' . $month . '-' . $day)));
        return $DOB;
    }
    //$isProduction
    
    private function isProduction() {
        $presentUrl = parse_url(url('/'));
        if($presentUrl['host'] != "admin.himilo.se"){
            return "http://test.bakaal.net/request/operation/";
        } else {
            return "http://bakaal.net/request/operation/";
        }
    }
    
    private function isProductionArray() {
        $presentUrl = parse_url(url('/'));
        if($presentUrl['host'] != "admin.himilo.se"){
            return $data_1 = array(
                'UserId' => 'IHIMILO',
                'Password' => 'Himilo@2020',
                'PartnerID' => 'HIMILO_INTEGRATION',
                'IPAddress' => '188.114.255.217'
            );
        } else {
            return $data_1 = array(
                    'UserId' => 'IHIMILO',
                    'Password' => 'H!m|l0@Y8!',
                    'PartnerID' => 'HIMILO_INTEGRATION',
                    'IPAddress' => '31.216.37.37'
                );

        }
     
        
        
        
        
        
        
    }
                    

}
