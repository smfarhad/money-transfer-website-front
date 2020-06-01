<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LockAccountController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
           $this->middleware('auth');
    }
    
    public function lockscreen() {
        session(['locked' => 'true']);
        return view('auth.lockscreen')
               ->with('title', "Lock Screen");
    }

    public function unlock(Request $request) {
        $password = $request->password;
        $this->validate($request, [
            'password' => 'required|string',
        ]);

        if(\Hash::check($password, \Auth::user()->password)){
            $request->session()->forget('locked');
            return redirect('/');
        }

        return back()->withErrors('Password does not match. Please try again.');
    }

}
