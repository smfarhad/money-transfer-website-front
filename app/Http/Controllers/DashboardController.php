<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\MoneyTransfer;
use App\Models\TransferComplete;
use DB;

class DashboardController extends Controller {

    public function __construct() {
       $this->middleware(['auth', 'lock']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $number_of_customer                = Customers::count();
        $number_of_transection             = TransferComplete::count();
        $total_transection                 = TransferComplete::select(DB::raw('SUM(source_amount)as amount'))->first();
        $total_transection_monthly         = TransferComplete::select(DB::raw('SUM(source_amount)as amount'))
                                                    ->whereMonth('date_update', date('m'))->first();
       
        
        //$num_of_transection = DB:table()
        return view('dashboard')
               ->with('number_of_cutomer', $number_of_customer)
               ->with('number_of_transection', $number_of_transection)
               ->with('total_transection', $total_transection)
               ->with('total_transection_monthly', $total_transection_monthly)
               ->with('title', "Dashboard");
    }

}
