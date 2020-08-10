<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Validator;
use Auth;

class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function doLogin(Request $request)
    {
        $rules = array(
            'g-recaptcha-response' => 'required|recaptcha'
        );

        $validator = Validator::make($request->all(), $rules);

            $userdata = array(
                'username' => $request->username,
                'password' => $request->password,
            );
            if (Auth::attempt($userdata)) {
                if (Auth::user()->is_active==true){
                    // return redirect()->route('admin.home');
                    return view('auth.maintenance');
                }else{
                    $request->session()->flash('message', 'Your account is not active');
                    return redirect('/'.config('gconfig.admin'));
                }
            } else {
                $request->session()->flash('message', 'Username or Password is Wrong');
                return redirect('/'.config('gconfig.admin'));
            }
        // if ($validator->fails()) {
        //     $request->session()->flash('message', 'Captcha Error');
        //     return redirect('/'.config('gconfig.admin'));
        // } else {
        //     $userdata = array(
        //         'username' => $request->username,
        //         'password' => $request->password,
        //     );
        //     if (Auth::attempt($userdata)) {
        //         if (Auth::user()->is_active==true){
        //             return redirect()->route('admin.home');
        //         }else{
        //             $request->session()->flash('message', 'Your account is not active');
        //             return redirect('/'.config('gconfig.admin'));
        //         }
        //     } else {
        //         $request->session()->flash('message', 'Username or Password is Wrong');
        //         return redirect('/'.config('gconfig.admin'));
        //     }

        // }
    }

    public function doLogout()
    {
        Auth::logout();
        return redirect('/'.config('gconfig.admin'));
    }
}
