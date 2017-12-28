<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;

class LoginController extends Controller
{
    /**
     * Return view for public home page
     */
    public function publicHome()
    {
        return view('public.home');
    }

    /**
     * Return view for login
     */
    public function login()
    {
        return view('public.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function loginAction(Request $request)
    {
        $userName       = $request->get('username');
        $password       = $request->get('password');
        $rememberUser   = !empty($request->get('rememberUser')) ? $request->get('rememberUser') : false;

        $validator  = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);
         if($validator->fails()) {
            return redirect(route('login-view'))->withErrors($validator)->withInput();
         }
         if(Auth::attempt(['user_name' => $userName, 'password' => $password, 'status' => '1'], $rememberUser)) {
            dd(1);
            // Authentication passed...
            return redirect(route('user-dashboard'))->with("message","Welcome " . Auth::user()->name . ". You are successfully logged in to the Trucking Manager.")->with("alert-class","alert-success");
        }
        // Authentication fails...
        $validator->errors()->add("username_password", "Invalid Username Or Password");
        return redirect(route('login-view'))->withErrors($validator)->withInput();
    }

    /**
     * Redirect successfully logged users
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }

    /**
     * Logsout users
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('login-view'));
    }

    /**
     * Return view for software licence
     */
    public function licence()
    {
        return view('public.license');
    }

    /**
     * Return view for uncompleted pages
     */
    public function underConstruction()
    {
        return view('public.under-construction');
    }

    /**
     * Return view for expired users
     */
    public function userExpired()
    {
        return view('public.expired');
    }
}
