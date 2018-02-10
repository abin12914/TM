<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use \Carbon\Carbon;

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
        $rememberUser   = !empty($request->get('rememberUser')) ? true : false;

        $validator  = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);
         if($validator->fails()) {
            //validation failed
            return redirect(route('login.view'))->withErrors($validator)->withInput();
         }

         if(Auth::attempt(['user_name' => $userName, 'password' => $password, 'status' => '1'], $rememberUser)) {
            // Authentication passed...
            $user = Auth::user();
            if(!empty($user->valid_till)) {
                $today          = Carbon::now();
                $userValidDate  = Carbon::createFromFormat('Y-m-d H:i:s', $user->valid_till);
                //user validity checking
                if($today->diffInDays($userValidDate, false) <= 7) {
                    //user expired or expiring soon
                    if($today->diffInDays($userValidDate, false) < 0) {
                        //user expired
                        return redirect(route('user.expired'))->with("expired-user", $user->user_name);
                    }
                    //user expiring soon
                    return redirect(route('user.dashboard'))->with("message",("Welcome " . $user->name . ". Your trial pack ends on " . $userValidDate . ". Please contact developer team for more info."))->with("alert-class","alert-warning");
                }
            }
            return redirect(route('user.dashboard'))->with("loggedUser", $user->name);
        }
        // Authentication fails...
        $validator->errors()->add("username_password", "Invalid User name Or Password");
        return redirect(route('login-view'))->withErrors($validator)->withInput();
    }

    /**
     * Logsout users
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('login.view'));
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
        if(Auth::check()) {
            $user = Auth::user();
            Auth::logout();
            return view('public.user-expired');
        } else {
            return redirect(route('login.view'));
        }
    }
}
