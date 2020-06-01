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


//use Orchestra\Parser\Xml\Facade as XmlParser;

class DataFieldController extends Controller {

    private $curl;
    private $login;

    //private $response; 
    public function __construct() {
        $this->curl = curl_init();
        //$this->login = $this->login();
    }

    public function getBranchList() {
        $curl = $this->curl;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://himiloexpress.com/DfcsRemittance.asmx?wsdl=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:dfc=\"http://dfcsservice.net/DFCSWebService\">\n   <soapenv:Header/>\n   <soapenv:Body>\n      <dfc:GetBranchListXML>\n         <!--Optional:-->\n         <dfc:xmlRequest>l6lwNO/iYSy10/VMaBjJE9b7dO1/c5y3QVeug2lgUfjBycffoSLzJVhpe65s3rO32DAWQ2FaGUgiPSg4SQImITvlRP6MIFkIL0OcW6OyKOOTv8yCZg4t5xTifsNf9SkwhymhCVnI+tGQxISFg4pv0CPPdEQ1ZkPoj40Rp3nYUCeAMvkFE2J2uMFQeRG33LIGajqZXpIp7UwJfPMHK62thSKAl1LA1aPsQyUl6vrY0pzPV+bfTspcqCWuRcZKQdulzes5ShchpeAD/KV2IB+NKrRn0wmOiGppd+wMzdVXZ5djyOx71SliAfy2Xtrb4sRs/uS+Foy2JZsEJUVwpyXDcTpUg6gg7wjiDiOmyC7/Vz7qSb/9swNgalRyb5ccpkExZ1A9o1pAjQobdcULro4e3EzshBbDG5qqEw4pTr8Mt87pvb8VL79ehTsUTqYElu6IsKtcHyiFZrDfjFJDoAzEL19wgNMyzChjX5tkF/sA7SXORViDVF4KoIvODkveWUMEt52iEzVthWizNeHslthWV2ybrSGNYUM4SkAxWnI4yqtJTREXZUvxaQdnfwn+grlmvdG+j0VdSRzjqmBNBQSGcFah3+zfId0sOTnZPLgnBCNs0RX8kfcmW1Gi+FrJoQxlR0NxTSTphjXPIAl+0zS7lytra4JOgbteqgoJliXz4cNMtLFemf/Y0eNmfYTyk1pEEwH6WFrxjMQ+udgrkQiEl98C/wEhk/lBP2SV1yEFqXMZgI7QEQ/kZS8T+Mc1S6bUYNYqAjcfmzq5UXRyAnZJTEb5XqqEmkm03zUVyimzLZc=</dfc:xmlRequest>\n      </dfc:GetBranchListXML>\n   </soapenv:Body>\n</soapenv:Envelope>",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: text/xml",
                "postman-token: d5eeb854-53ac-aefa-e38c-d25a8d280f2a"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $mydata_1 = html_entity_decode($response);
            $mydata = $this->xml_formatting($mydata_1, "<RemittanceResponse>", "</RemittanceResponse>");
            // echo $mydata.'<br>';
            $xml = simplexml_load_string($mydata) or die("Error: Cannot create object");

            print_r($xml);
            die();




            // $response;


            /*
              //$pieces = explode(' ', $response);
              //$array = array_slice($pieces, 8);
              //$array[0] = '';
              //$headerStriung = '<?xml version="1.0" encoding="UTF-8"?><RemittanceResponse>';
              //$implode = implode(" ",$array);
              $finalXml= $headerStriung.$implode;
             */


            // $xml = simplexml_load_string($response);
            //return $xml;
            //echo $json = json_encode($xml);
            //print_r($xml);
        }
    }

    public function getCountryList() {

        $curl = $this->curl;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://himiloexpress.com/DfcsRemittance.asmx?wsdl=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dfc="http://dfcsservice.net/DFCSWebService">
                    <soapenv:Header/>
                    <soapenv:Body>
                       <dfc:GetCountryListXML>
                          <!--Optional:-->
                          <dfc:xmlRequest>F9+KRfC0XkL4h0/CY6djlz6LbD4GPaq29c7zyIqC1PrEtBBEajAF5J8UVvVwcYytxpRd3OMffRAFtQrGcGUSePJEVJTPSDED5VS9NptFwYWcyymQ6eny0b1URTR4x+WFkIJ2381ANSHpjTPYx8utCe1jlKw6vkeh29OIm9cgwLuPPX0sa2+y11faz1VyNr0DSrLnHrHddKfz/y/Rug6n25fxUUef9e++8gyyR2AUvzqjXwk6/2xQIK9M4asKtPWZmxf1NEHOWHA+2fdVwZj03VbfJ8bJYwzxX+a4U67awgpSX+J5pAXP3PG/CnZGrxMlhmYFzWrSx9o34pigguinpCYXc6hGKP5Vd8LFsODTCJCXKruyfMD5Hwz+TJsQeW5sLrAlS+/gTjdJtty36RgtSFdN2p0bvnB2QM7G4Tv41aa+3o4tPwQbNBMYNYrF2hTcBeS3PxXNNoPBpDEcQyJhCTyuLf8V8BjCTrBznUsKqWB2lJBSOTMU+FiQnSl5Q8gQ+LKIp68a8aKtVRLe9rnPOcXlrv0H58T3zUdPH6X4SAwBarhZhBduHvXrF2nEMRNe/msMdDvHPyR3JUf0fWnuiA==</dfc:xmlRequest>
                       </dfc:GetCountryListXML>
                    </soapenv:Body>
                 </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: text/xml",
                "postman-token: d5eeb854-53ac-aefa-e38c-d25a8d280f2a"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $mydata_1 = html_entity_decode($response);

            $mydata = $this->xml_formatting($mydata_1, "<RemittanceResponse>", "</RemittanceResponse>");
            // echo $mydata.'<br>';
            // f_write($response);

            $xml = simplexml_load_string($mydata) or die("Error: Cannot create object");
            echo '<pre>';
            foreach ($xml->Country as $row) {
                echo 'C Code:' . $row->CountryCode . ' ' . 'CName:' . $row->CountryName;
                echo '<br>';
            }
            die();
        }
    }

    public function remittanceRequestFinal() {
        $remittances = MoneyTransfer::leftJoin('recipient as r', 'money_transfer.recipient_id', '=', 'r.id')
               ->leftJoin('user_info as u', 'u.id', '=', 'r.user_id')
               ->leftJoin('country as c', 'money_transfer.destination_country', '=', 'c.id')
               ->select('money_transfer.id as transfer_id', 'money_transfer.date_create', 'money_transfer.note','money_transfer.sending_reason','money_transfer.status','money_transfer.api_type',
                'money_transfer.source_amount','money_transfer.source_amount_usd', 'money_transfer.receive_type', 'money_transfer.fees','money_transfer.fees_usd', 'money_transfer.admin_id', 'c.country_code','c.name as country_name',
                'r.id as recipient_id', 'r.id as destination_country','money_transfer.convertion_rate','money_transfer.destination_amount',
                'r.first_name as recipient_name', 
                'r.address_1 as recipient_address', 'r.suburb', 'r.postcode', 'r.city', 'r.mobile as recipent_mobile', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as sender_name"), 
                'u.address_1 as s_address', 'u.postcode as s_postcode', 'u.city as s_city', 'u.mobile as sender_mobile', 'u.personnumber')
        ->where('money_transfer.status',1)
        //->where('money_transfer.receive_type',1)
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
                            'IdExpiryDate' => '20-JAN-2018',
                            'ModifiedBy' => 'IHIMILO',
                            'SourceTransNo' => $remittance->transfer_id  // must be uniq
                        );
            
        
        $text = "<?xml version='1.0' encoding='utf-8'?>  
                    <RemittanceRequest> 
                      <RequestType>NewRemittance</RequestType> 
                      <fragent>HSO</fragent> 
                      <userid>HMLWSUSER</userid> 
                      <password>123456</password> 
                      <toagent>MQD</toagent> 
                      <sender> $remittance->sender_name </sender> 
                      <sendertel>$remittance->sender_mobile </sendertel> 
                      <senderaddress>$remittance->s_address. ', ' . $remittance->s_postcode.', '.$remittance->s_city.', Sweden'</senderaddress> 
                      <sendercity>$remittance->s_city</sendercity> 
                      <sendernationality>SE</sendernationality> 
                      <doctype>PASPort</doctype> 
                      <docno>RD555555</docno> 
                      <issuedate>2018/6/04</issuedate> 
                      <expdate>2020/6/04</expdate> 
                      <beneficiary>$remittance->recipient_name</beneficiary> 
                      <benefcity>LARACHE</benefcity> 
                      <beneftel>$remittance->recipent_mobile</beneftel> 
                      <benefaddress>$remittance->recipient_address</benefaddress> 
                      <amount>$remittance->source_amount_usd</amount> 
                      <comm>0.00</comm> 
                      <remarks>00$remittance->transfer_id</remarks> 
                      <purpose>$remittance->sending_reason</purpose> 
                      <atransid>00$remittance->transfer_id</atransid> 
                </RemittanceRequest>";
        
        $encrypted_txt = $this->encryption($text);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://himiloexpress.com/DfcsRemittance.asmx?wsdl=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:dfc="http://dfcsservice.net/DFCSWebService">
       <soap:Header/>
       <soap:Body>
          <dfc:RemittanceRequestXML>
             <!--Optional:-->
             <dfc:xmlRequest>' . $encrypted_txt . '</dfc:xmlRequest>
          </dfc:RemittanceRequestXML>
       </soap:Body>
    </soap:Envelope>',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: text/xml",
                "postman-token: d5eeb854-53ac-aefa-e38c-d25a8d280f2a"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $response_process = '';
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $mydata_1 = html_entity_decode($response);
                $mydata = $this->xml_formatting($mydata_1, "<RemittanceResponse>", "</RemittanceResponse>");
                $response_arry[$i] = simplexml_load_string($mydata) or die("Error: Cannot create object");
                $response_process = $response_arry[$i];
            }
        if($response_process->Status == 'Success'){
           
            
            $response_process['OurStatus'] = 2;
            MoneyTransfer::where('id', $remittance->transfer_id)->update(['status'=> 2]);
            $input = [];
            $input['transfer_id']               = $remittance->transfer_id; 
            $input['bakaal_TransNo']            = $response_process->TransNo; 
            $input['recipient_id']              = $remittance->recipient_id;
            $input['source_amount']             = $remittance->source_amount;
            $input['source_amount_usd']         = $remittance->source_amount_usd;
            $input['fees']                      = 0;//$remittance->fees;
            $input['fees_usd']                  = 0;//$remittance->fees_usd;
            $input['receive_type']              = $remittance->receive_type;
            $input['source_total']              = ($remittance->source_amount+$remittance->fees);
            $input['destination_country']       = $remittance->destination_country;
            $input['conversion_rate']           = $remittance->convertion_rate;
            $input['destination_amount']        = $remittance->destination_amount;
            $input['admin_id']                  = $remittance->admin_id;
            $input['note']                      = $remittance->note;
            $input['api_type']                  = $remittance->api_type;
            $input['status']                    = 2;
            $input['date_create']               = $remittance->date_create;
            $input['date_execution']            = date('Y-m-d H:i:s');
            
            TransferComplete::create($input);
            } else {
                $response_process['OurStatus'] = 3;
                MoneyTransfer::where('id',$remittance->transfer_id)->update(['status'=>3]);
                $bakaalFial = [
                    'transfer_id' =>    $remittance->transfer_id, 
                    'api_type'    =>    $remittance->api_type, 
                    'code'        =>    $response_process->Message->Code,
                    'description' =>    $response_process->Message->Message,
                    'trans_no'    =>    $response_process->Message->TransNo,
                    'date_create' =>    date('Y-m-d H:i:s')
                ];   
                BakaalFail::create($bakaalFial);
            }
            $i++;
        }
     
        curl_close($curl);
    }

    public function getRemittanceListFinal() {
        $text = "<?xml version='1.0' encoding='utf-8'?> 
                <RemittanceRequest> 
                    <RequestType>GetRemittanceList</RequestType> 
                    <fragent>HSO</fragent> 
                    <userid>HMLWSUSER</userid> 
                    <password>123456</password> 
                    <toagent></toagent> 
                    <sender></sender> 
                    <sendertel></sendertel> 
                    <sendercity></sendercity> 
                    <beneficiary></beneficiary> 
                    <beneftel></beneftel> 
                    <benefcity></benefcity> 
                    <status>Ready</status> 
                    <frdate>04-30-2018</frdate> 
                    <todate>07-31-2018</todate> 
                    <atransid></atransid> 
                </RemittanceRequest>";

        $encrypted_txt = $this->encryption($text);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://himiloexpress.com/DfcsRemittance.asmx?wsdl=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:dfc="http://dfcsservice.net/DFCSWebService">
                <soap:Header/>
                <soap:Body>
                   <dfc:GetRemittanceListXML>
                      <!--Optional:-->
                      <dfc:xmlRequest>' . $encrypted_txt . '</dfc:xmlRequest>
                   </dfc:GetRemittanceListXML>
                </soap:Body>
             </soap:Envelope>',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: text/xml",
                "postman-token: d5eeb854-53ac-aefa-e38c-d25a8d280f2a"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $mydata_1 = html_entity_decode($response);
            $mydata = $this->xml_formatting($mydata_1, "<RemittanceResponse>", "</RemittanceResponse>");
            $xml = simplexml_load_string($mydata) or die("Error: Cannot create object");
            echo '<pre>';
            print_r($xml);
        }
    }

    public function xml_formatting($str, $condition_1, $condition_2) {
        $parse_data = explode($condition_1, $str);
        $parse_data_2 = explode($condition_2, $parse_data[1]);
        $final_str = $parse_data_2[0];

        return $condition_1 . $final_str . $condition_2;
    }

    public function encryption($str) {
        //$text=json_encode($text);
        $key = "XMlkfg2845acGTbvdr270FGHBfghjkdc";
        $iv = "HQreTFgdtm1485rtyFG8ertyjfsERgh4";
        //$plaintext = "This string was AES-256 / CBC / ZeroBytePadding encrypted.";

        $plaintext = trim($str);

        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plaintext, MCRYPT_MODE_CBC, $iv);

        # prepend the IV for it to be available for decryption
        $ciphertext = $ciphertext;

        # encode the resulting cipher text so it can be represented by a string
        $ciphertext_base64 = base64_encode($ciphertext);

        // echo ''.$ciphertext_base64 . "<br>";
        return $ciphertext_base64;
    }
    
    private function personNumberToDOB($personNumber) {
        $year = substr($personNumber, 0, -8);
        $month = substr($personNumber, 4, -6);
        $day = substr($personNumber, 6, -4);
        //return $year.'-'.$month.'-'.$day;
        $DOB = strtoupper(date('d-M-Y', strtotime($year . '-' . $month . '-' . $day)));
        return $DOB;
    }
    
    public function f_write($str) {
        $file = 'ullah.txt';
        // Open the file to get existing content
        $current = file_get_contents($file);
        // Append a new person to the file
        $current = $str . " \n";
        // Write the contents back to the file
        file_put_contents($file, $current);
    }


}
