<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class LockAccount {

    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    public function handle($request, Closure $next, $guard = null) {

        if ($request->session()->has('locked')) {

            return redirect('/lockscreen');
        }
        return $next($request);
    }

}
