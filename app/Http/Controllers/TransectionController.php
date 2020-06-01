<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MoneyTransfer;
use App\Models\TransferComplete;
use App\Models\BakaalFail;
use App\Models\Recipient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use DB;

class TransectionController extends Controller {

    public function __construct() {
         $this->middleware(['auth', 'lock']);
    }

    public function initial() {
        //MoneyTransfer::where('id', $request->input('id'))->update(['status'=>9]);
        //return MoneyTransfer::get();
        $main = Recipient::leftJoin('money_transfer as m', 'm.recipient_id', '=', 'recipient.id')
                ->leftJoin('user_info as u', 'recipient.user_id', '=', 'u.id')
                ->select('m.id', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_name"), 'u.personnumber', 'm.source_total as depositaedAmount', 'm.source_amount','m.fees',
                         'recipient.first_name as recipient_name','m.date_create', 'm.status')
                ->orderBy('m.id', 'DESC')
                ->where('m.status', 0)     
                ->get();
        return view('transection.initial')
                    ->with('main', $main)
                         ->with('title', "Initial transection");
    }

    public function singleForm() {
        return view('transection.details')
                        ->with('title', "Customer Money Transection Detail");
    }

    public function completed(){
        $main = TransferComplete::leftJoin('recipient as r', 'transfer_complete.recipient_id', '=', 'r.id')
                                  ->leftJoin('admin as a', 'transfer_complete.admin_id', '=', 'a.id')
                                  ->leftJoin('user_info as u', 'r.user_id', '=', 'u.id')
                                  ->select('transfer_complete.transfer_id as id',
                                           'r.first_name as recipient_name',
                                           DB::raw("CONCAT(a.first_name, ' ', a.last_name) as user_name"),
                                           DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_name"),
                                           'u.personnumber','u.id as customer_id',
                                           'a.id as user_id', 'transfer_complete.source_amount','transfer_complete.fees',
                                           'transfer_complete.source_amount as depositaedAmount',
                                           'transfer_complete.date_execution',
                                           'transfer_complete.date_create as create')
                                  ->get();
        return view('transection.completed')
                    ->with('main', $main)
                    ->with('title', "Transection Completed");
    }
    
    public function completedById($id){
        $main = TransferComplete::leftJoin('recipient as r', 'transfer_complete.recipient_id', '=', 'r.id')
                                  ->leftJoin('admin as a', 'transfer_complete.admin_id', '=', 'a.id')
                                  ->leftJoin('user_info as u', 'r.user_id', '=', 'u.id')
                                  ->select('transfer_complete.transfer_id as id',
                                           DB::raw("CONCAT(r.first_name, ' ', r.last_name) as recipient_name"),
                                           DB::raw("CONCAT(a.first_name, ' ', a.last_name) as user_name"),
                                           DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_name"),
                                           'u.personnumber','u.id as customer_id',
                                           'a.id as user_id', 
                                           'transfer_complete.source_total as depositaedAmount',
                                           'transfer_complete.date_execution',
                                           'transfer_complete.date_create as create')
                                  ->where('admin_id', $id)
                                  ->get();
        return view('transection.completed')
                    ->with('main', $main)
                    ->with('title', "Transection Completed");
    }
    
    public function waiting() {
        $main = Recipient::leftJoin('money_transfer as m', 'm.recipient_id', '=', 'recipient.id')
                ->leftJoin('user_info as u', 'recipient.user_id', '=', 'u.id')
                ->select('m.id', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_name"), 
                        'u.personnumber', 'm.source_total as depositaedAmount', 'm.source_amount','m.fees',
                        'recipient.first_name  as recipient_name', 'm.date_create', 'm.status')
                ->where('m.status', 1)
                //->limit(5000)
                ->get();
        return view('transection.waiting')
                ->with('main', $main)
                ->with('title', "Transection Waiting");
    }
    public function daily() {
        $main = Recipient::leftJoin('money_transfer as m', 'm.recipient_id', '=', 'recipient.id')
                ->leftJoin('user_info as u', 'recipient.user_id', '=', 'u.id')
                ->leftJoin('transfer_status as s', 'm.status', '=', 's.value')
                ->select('m.id', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_name"), 
                        'u.personnumber', 'm.source_total as depositaedAmount', 'm.source_amount','m.fees',
                        'recipient.first_name  as recipient_name', 'm.date_create', 'm.status', 's.name as status_name')
                ->whereRaw('m.date_create >= NOW() - INTERVAL 1 DAY')
                ->get();
        return view('transection.daily')
                ->with('main', $main)
                ->with('title', "Daily Transection");
    }

    public function statusUpdate(Request $request) {
        
        $rules = array(
            'id' => 'required|numeric',
            'status' => 'required|numeric',
            'apiType' => 'required|numeric'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ), 400); // 400 being the HTTP code for an invalid request.
        }
        $update_status = MoneyTransfer::where('id', $request->input('id'))
                                                ->update(['status'   => $request->input('status'),
                                                          'api_type' => $request->input('apiType'),
                                                          'admin_id' => Auth::user()->id]);
 
        if($update_status && $request->input('status') == 2){
            $data = [];
            $data = MoneyTransfer::where('id', $request->input('id'))->first();
            $input = [];
            $input['transfer_id']               = $data['id'];
            $input['api_type']                  = $data['api_type'];
            $input['recipient_id']              = $data['recipient_id'];
            $input['source_amount']             = $data['source_amount'];
            $input['fees']                      = $data['fees'];
            $input['source_total']              = $data['source_total'];
            $input['destination_country']       = $data['destination_country'];
            $input['conversion_rate']           = $data['convertion_rate'];
            $input['destination_amount']        = $data['destination_amount'];
            $input['admin_id']                  = Auth::user()->id; 
            $input['note']                      = $data['note'];
            $input['date_execution']            = $data['date_execution'];
            
            TransferComplete::create($input);
        }
        return Response::json(array('success' => true), 200);
    }
    
    public function transactionUpdate(Request $request) {
            //return $request->all();            
            $input = [];
            $input['receive_type']        = $request->input('service_type');
            $input['fees_usd']            = $request->input('fees_usd');
            $input['status']              = 1;
            $input['admin_id']            = Auth::user()->id; 
            MoneyTransfer::where('id', $request->input('id'))->update($input);
            
            Recipient::where('id', $request->input('recipientId'))->update([
                                                                            'mobile'=>$request->input('mobile'),
                                                                           
                                                                            ]);
            return back()->withInput();
    }
    
    public function transactionDelete(Request $request) {
        $input = [];
        $input['status']              = 9;
        $input['admin_id']            = Auth::user()->id; 
        MoneyTransfer::where('id', $request->input('id'))->update($input);
        return Response::json(array('success' => true), 200);
    }    
    
    public function details($id) {
        $main = Recipient::leftJoin('money_transfer as m', 'm.recipient_id', '=', 'recipient.id')
            ->leftJoin('user_info as u', 'recipient.user_id', '=', 'u.id')
            ->leftJoin('admin as a', 'm.admin_id', '=', 'a.id')
            ->leftJoin('transfer_status as s', 'm.status', '=', 's.value')
            ->leftJoin('country as c', 'm.destination_country', '=', 'c.id')
            ->select('m.id', DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_name"), 'u.personnumber', 
                      'm.source_amount as depositaedAmount', 'm.fees', 'm.source_total','recipient.mobile','recipient.id as recipientId',
                      'm.source_amount_usd as depositaedAmount_usd', 'm.fees_usd','m.receive_type','c.name as destination_country',
                      DB::raw("CONCAT(recipient.first_name, ' ', recipient.last_name) as recipient_name"), 'm.date_create', 'm.status', 'm.date_execution',
                      DB::raw("CONCAT(a.first_name, ' ', a.last_name) as admin_name"), 's.name as status' ,'s.id as status_id' 
                    )
            ->orderBy('m.id', 'DESC')
            ->where('m.id', $id)
            ->first();
        return view('transection.details')
                ->with('main', $main)
                    ->with('title', "Customer Money Transection Detail");
    }
    
    public function failedTransection() {
         $faildId = BakaalFail::leftJoin('money_transfer as m', 'm.id', '=', 'bakaal_fail.transfer_id')
                            ->select(DB::raw('max(bakaal_fail.id) as id'))
                            ->groupBy('transfer_id')
                            ->havingRaw('max(bakaal_fail.id)')
                            ->where('m.status',3)
                            ->get();
        
        $faildIdArray = [];
        $i = 0;
        foreach ($faildId as $row) {
            $faildIdArray[$i++] = $row->id;
        }
        
        $main = BakaalFail::leftJoin('money_transfer as m', 'm.id', '=', 'bakaal_fail.transfer_id')
                                  ->leftJoin('recipient as r', 'm.recipient_id', '=', 'r.id')
                                  ->leftJoin('admin as a', 'm.admin_id', '=', 'a.id')
                                  ->leftJoin('user_info as u', 'r.user_id', '=', 'u.id')
                                  ->select('bakaal_fail.id as bakal_fail_id','m.id as transfer_id', 'r.first_name as recipient_name',
                                           DB::raw("CONCAT(a.first_name, ' ', a.last_name) as user_name"),
                                           DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_name"),
                                           'u.personnumber','u.id as customer_id',
                                           'a.id as user_id', 'm.source_amount','m.fees',
                                           'm.source_amount as depositaedAmount',
                                           'm.date_execution',
                                           'm.date_create as create',  'bakaal_fail.code', 'bakaal_fail.transfer_id',
                                           'bakaal_fail.description as bakalDescription', 'bakaal_fail.note')
                                   ->whereIn('bakaal_fail.id', $faildIdArray)
                                  // ->orderBy('m.id', 'desc')
                                   ->get();
                        

        return view('transection.failed')
                    ->with('main', $main)
                    ->with('title', "Transection Failed");
    }

}
