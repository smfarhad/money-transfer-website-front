<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Recipient;
use App\Models\UserFile;
use Illuminate\Support\Facades\Session;
use DB;

class CustomerController extends Controller {
    
    public function __construct() {
         $this->middleware(['auth', 'lock']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $main = Customers::get();
        return view('customer.list')
               ->with('main', $main)
               ->with('title', "Customer List");
    }
    
    public function profile($id){      
        $recipient = Recipient::leftJoin('money_transfer as m', 'm.recipient_id', '=', 'recipient.id')
                              ->leftJoin('user_info as u', 'recipient.user_id', '=', 'u.id')
                              ->leftJoin('transfer_status as s', 'm.status', '=', 's.value')
                              ->select('m.id', 'recipient.first_name as recipient_name',
                                       'm.source_amount as amount','u.personnumber', 'm.date_create',
                                       's.name as status'
                                      )
                              ->where('recipient.user_id', $id)
                              ->get();
        $number_of_transection    = count($recipient);
        $transaction_amount = [];
        $i=0;
        foreach($recipient as $row){
           $transaction_amount[$i++] = $row->amount;
        }
        $customer_details = Customers::leftJoin('country as c', 'user_info.country', '=', 'c.id')
                                                        ->select('user_info.*','c.name as country_name')
                                                            ->where('user_info.id', $id)->first();
        //return $id;
        $customer_files = UserFile::where('user_id', $id)->get();
        //UserFile::where('user_id', $id)->delete();
        //return;
        
       
       return view('customer.profile')
               ->with('main', $recipient)
               ->with('profile', $customer_details)
               ->with('customer_files', $customer_files)
               ->with('number_of_transection', $number_of_transection)
               ->with('total_transaction_amount', array_sum($transaction_amount))
               ->with('title', "Customer Profile");
    }
    
    public function profilePost(Request $request){
       $id = request()->segment(2);
       $input = [];
       $input['first_name']     = $request->input('firstName');
       $input['last_name']      = $request->input('lastName');
       $input['mobile']         = $request->input('mobileNumber');
       $input['address_1']      = $request->input('addressOne');
       $input['address_2']      = $request->input('addressTwo');
       $input['suburb']         = $request->input('suburb');
       $input['postcode']       = $request->input('postcode');
       $input['city']           = $request->input('city');
       $input['email']          = $request->input('email');
       $data = Customers::findOrFail($id);
       $data->update($input);
        
        Session::flash('success', "<span class=text-green> &nbsp; &nbsp; Data Updated Successfully</span>");
        return back()->withInput($request->input());

    }    

}
