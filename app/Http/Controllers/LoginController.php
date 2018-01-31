<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use \Carbon\Carbon;
use App\Repositories\TruckRepository;
use App\Repositories\AccountRepository;
use App\Repositories\TransportationRepository;

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
            return redirect(route('user.dashboard'))->with("message","Welcome " . $user->name . ". You are successfully logged in to the Trucking Manager.")->with("alert-class","alert-success");
        }
        // Authentication fails...
        $validator->errors()->add("username_password", "Invalid Username Or Password");
        return redirect(route('login-view'))->withErrors($validator)->withInput();
    }

    /**
     * Redirect successfully logged users
     */
    public function dashboard(TruckRepository $truckRepo, AccountRepository $accountRepo, TransportationRepository $transportationRepo)
    {
        $expiredCertificateCount    = 0;
        $truckCount                 = 0;
        $warnCertificateCount       = 0;
        $transportationCount        = 0;

        $certificateFlags = [
                1   => 'insuranceFlag',
                2   => 'taxFlag',
                3   => 'fitnessFlag',
                4   => 'permitFlag',
            ];

        $transportations    = $transportationRepo->getTransportations();
        $trucks             = $truckRepo->getTrucks();

        //transportation count
        $transportationCount = count($transportations);
        //truck count
        $truckCount = count($trucks);
        //expired and soon expiring certificate count
        foreach ($trucks as $key => $truck) {
            
            $result = $truckRepo->checkCertificateValidity($truck);

            if($result['flag']) {

                foreach ($certificateFlags as $key => $flag) {
                    
                    if($result[$flag] == 3) {
                        $expiredCertificateCount = $expiredCertificateCount + 1;
                    }
                    if($result[$flag] == 2) {
                        $warnCertificateCount = $warnCertificateCount + 1;
                    }
                }
            }
        }

        if($transportationCount < 10) {
            $transportationCount = "0". $transportationCount;
        }
        if($truckCount < 10) {
            $truckCount = "0". $truckCount;
        }
        if($warnCertificateCount < 10) {
            $warnCertificateCount = "0". $warnCertificateCount;
        }
        if($expiredCertificateCount < 10) {
            $expiredCertificateCount = "0". $expiredCertificateCount;
        }

        return view('user.dashboard', [
                'transportationCount'       => $transportationCount,
                'truckCount'                => $truckCount,
                'warnCertificateCount'      => $warnCertificateCount,
                'expiredCertificateCount'   => $expiredCertificateCount,
            ]);
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
