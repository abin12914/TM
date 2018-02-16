<?php

namespace App\Repositories;

use App\Models\Truck;
use Illuminate\Support\Facades\DB;
use App\Models\TruckType;
use \Carbon\Carbon;

class TruckRepository
{
    public $bodyTypes = [
        1   => "Level",
        2   => "Extendend Body",
        3   => "Extra Extendend Body",
    ];

    public  $certificateWarn = 15, $certificatedanger = 1;

    /**
     * Return statecodes.
     */
    public function getStateCodes()
    {
        $stateCodes = DB::table('vehicle_registration_state_codes')->orderBy('code')->get();

        if(empty($stateCodes) || $stateCodes->count() < 1) {
            $stateCodes = [];
        }

        return $stateCodes;
    }

    /**
     * Return truck types.
     */
    public function getTruckTypes()
    {
        $truckTypes = TruckType::where('status', 1)->orderBy('name')->get();

        if(empty($truckTypes) || $truckTypes->count() < 1) {
            $truckTypes = [];
        }

        return $truckTypes;
    }

    /**
     * Return trucks.
     */
    public function getTrucks($params=[], $noOfRecords=null)
    {
        $trucks = Truck::with('truckType')->where('status', 1);

        foreach ($params as $key => $value) {
            if(!empty($value)) {
                $trucks = $trucks->where($key, $value);
            }
        }
        if(!empty($noOfRecords)) {
            if($noOfRecords == 1) {
                $trucks = $trucks->first();
            } else {
                $trucks = $trucks->paginate($noOfRecords);
            }
        } else {
            $trucks= $trucks->get();
        }

        if(empty($trucks) || $trucks->count() < 1) {
            $trucks = [];
        }

        return $trucks;
    }

    /**
     * save truck action.
     */
    public function saveTruck($request)
    {
        $registrationNumber = $request->get('reg_number');
        $description        = $request->get('description');
        $truckType          = $request->get('truck_type');
        $volume             = $request->get('volume');
        $bodyType           = $request->get('body_type');
        $insuranceUpto      = Carbon::createFromFormat('d-m-Y', $request->get("insurance_date"))->format('Y-m-d');
        $taxUpto            = Carbon::createFromFormat('d-m-Y', $request->get("tax_date"))->format('Y-m-d');
        $permitUpto         = Carbon::createFromFormat('d-m-Y', $request->get("permit_date"))->format('Y-m-d');
        //$pollutionUpto      = Carbon::createFromFormat('d-m-Y', $request->get("pollution_date"))->format('Y-m-d');
        $fitnessUpto        = Carbon::createFromFormat('d-m-Y', $request->get("fitness_date"))->format('Y-m-d');

        $truck = new Truck;
        $truck->reg_number      = $registrationNumber;
        $truck->description     = $description;
        $truck->truck_type_id   = $truckType;
        $truck->volume          = $volume;
        $truck->body_type       = $bodyType;
        $truck->insurance_upto  = $insuranceUpto;
        $truck->tax_upto        = $taxUpto;
        $truck->permit_upto     = $permitUpto;
        //$truck->polution_upto   = $pollutionUpto;
        $truck->fitness_upto    = $fitnessUpto;
        $truck->status          = 1;
        if($truck->save()) {
            return [
                'flag'  => true,
                'id'    => $truck->id
            ];
        }
        
        return [
            'flag'      => false,
            'errorCode' => "01"
        ];
    }

    /**
     * return truck.
     */
    public function getTruck($id)
    {
        $truck = Truck::with('truckType')->where('status', 1)->where('id', $id)->first();

        if(empty($truck) || empty($truck->id)) {
            $truck = [];
        }

        return $truck;
    }

    public function deleteTruck($id, $forceFlag=false)
    {
        $truck = Truck::where('status', 1)->where('id', $id)->first();

        if(!empty($truck) && !empty($truck->id)) {
            if($forceFlag) {
                if($truck->forceDelete()) {
                    return [
                        'flag'  => true,
                        'force' => true,
                    ];
                } else {
                    $errorCode = '02';
                }
            } else {
                if($truck->delete()) {
                    return [
                        'flag'  => true,
                        'force' => false,
                    ];
                } else {
                    $errorCode = '03';
                }
            }
        } else {
            $errorCode = '03';
        }
        return [
            'flag'      => false,
            'errorCode' => $errorCode,
        ];
    }

    public function checkCertificateValidity(Truck $truck)
    {
        //flags [1 => valid, 2 => valid but warning, 3 => invalid]
        $today = Carbon::now();
        $insuranceFlag  = 1;
        $taxFlag        = 1;
        $fitnessFlag    = 1;
        $permitFlag     = 1;

        if(!empty($truck) && !empty($truck->id)) {
            $insuranceUpto  = Carbon::createFromFormat('Y-m-d', $truck->insurance_upto);
            $taxUpto        = Carbon::createFromFormat('Y-m-d', $truck->tax_upto);
            $fitnessUpto    = Carbon::createFromFormat('Y-m-d', $truck->fitness_upto);
            $permitUpto     = Carbon::createFromFormat('Y-m-d', $truck->permit_upto);

            if($today->diffInDays($insuranceUpto, false) <= $this->certificateWarn) {
                $insuranceFlag  = 2;
                if($today->diffInDays($insuranceUpto, false) <= $this->certificatedanger) {
                    $insuranceFlag = 3;
                }
            }

            if($today->diffInDays($taxUpto, false) <= $this->certificateWarn) {
                $taxFlag  = 2;
                if($today->diffInDays($taxUpto, false) <= $this->certificatedanger) {
                    $taxFlag = 3;
                }
            }

            if($today->diffInDays($fitnessUpto, false) <= $this->certificateWarn) {
                $fitnessFlag  = 2;
                if($today->diffInDays($fitnessUpto, false) <= $this->certificatedanger) {
                    $fitnessFlag = 3;
                }
            }

            if($today->diffInDays($permitUpto, false) <= $this->certificateWarn) {
                $permitFlag  = 2;
                if($today->diffInDays($permitUpto, false) <= $this->certificatedanger) {
                    $permitFlag = 3;
                }
            }

            return [
                    'flag'          => true,
                    'insuranceFlag' => $insuranceFlag,
                    'taxFlag'       => $taxFlag,
                    'fitnessFlag'   => $fitnessFlag,
                    'permitFlag'    => $permitFlag,
                ];
        } else {
            return [
                    'flag'  => false,
                ];
        }
    }
}
