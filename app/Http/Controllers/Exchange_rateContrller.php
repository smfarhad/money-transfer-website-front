<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;
use App\Models\ExchangeRate_history;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use Redirect;
class Exchange_rateContrller extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'lock']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $main = ExchangeRate::get();
        return view('exchange_rate.index')
                        ->with('main', $main)
                        ->with('i', 1)
                        ->with('title', "Exchange Rate");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
       
        return view('exchange_rate.form')
                        ->with('i', 1)
                        ->with('title', "Exchange Rate");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
     
        $regex = "/^[0-9]+(\.[0-9]{1,3})?$/";
        $inputs = array(
            'minRange' => $request->minRange,
            'maxRange' => $request->maxRange,
            'rate' => $request->rate,
            'fee' => $request->fee
        );
        $rules = array('minRange' => '',
                       'maxRange' => 'required',
                       'rate' => "required|regex:$regex",
                       'fee' => "required|regex:$regex");
        
        
        
        
        $validator = Validator::make($inputs, $rules);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $input = [];
            $input['min_range'] = $request->input('minRange');
            $input['max_range'] = $request->input('maxRange');
            $input['rate'] = $request->input('rate');
            $input['fee'] = $request->input('fee');
            ExchangeRate::insert($input);
            $request->session()->flash('alert-success', 'Exchange Rate inserted Successfully');
            return redirect()->route('exchange-rate');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $main = ExchangeRate::where('id', $id)->first();
        return view('exchange_rate.update')
                        ->with('show', $main)
                        ->with('i', 1)
                        ->with('title', "Exchange Rate");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $regex = "/^[0-9]+(\.[0-9]{1,3})?$/";
        
        $inputs = array(
            'minRange' => $request->minRange,
            'maxRange' => $request->maxRange,
            'rate' => $request->rate,
            'fee' => $request->fee
        );
        
        $rules = array('minRange' => '',
                       'maxRange' => 'required',
                       'rate' => "required|regex:$regex",
                       'fee' => "required|regex:$regex");
        
        $validator = Validator::make($inputs, $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $input = [];
            $input['min_range']     = $request->minRange;
            $input['max_range']     = $request->maxRange;
            $input['rate']          = $request->rate;
            $input['fee']           = $request->fee;
            $input['date_update'] =  date('Y-m-d H:i:s');
            ExchangeRate::where('id', $request->input('id'))->update($input);
            $request->session()->flash('alert-success', 'Exchange Rate Updated Successfully');
            return redirect()->route('exchange-rate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) { 
        $data = ExchangeRate::where('id', $id)->delete();  
        return back();
    }

}
