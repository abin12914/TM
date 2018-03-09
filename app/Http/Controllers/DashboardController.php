<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Repositories\TruckRepository;
use App\Repositories\AccountRepository;
use App\Repositories\TransportationRepository;

class DashboardController extends Controller
{
    /**
     * Redirect successfully logged users
     */
    public function dashboard(TruckRepository $truckRepo, TransportationRepository $transportationRepo)
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
                    $truck->$flag = $result[$flag];
                    
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
                'trucks'                    => $trucks,
            ]);
    }
}
