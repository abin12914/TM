<?php

namespace App\Repositories;

use App\Models\Truck;
use Illuminate\Support\Facades\DB;
use App\Models\TruckType;

class TruckRepository
{

    protected $truck;

    public function __construct(Truck $truck)
    {
        $this->truck = $truck;
    }

    /**
     * Return statecodes.
     */
    public function getStateCodes()
    {
        $stateCodes = [];

        $stateCodes = DB::table('vehicle_registration_state_codes')->orderBy('code')->get();

        return $stateCodes;
    }

    /**
     * Return statecodes.
     */
    public function saveTruck($request)
    {
        $registrationNumber = $request->get('reg_number');
        $description        = $request->get('description');
        $truckType          = $request->get('truck_type');
        $volume             = $request->get('volume');
        $bodyType           = $request->get('body_type');
        $insuranceUpto      = $request->get('insurance_date');
        $taxUpto            = $request->get('tax_date');
        $permitUpto         = $request->get('permit_date');
        $pollutionUpto      = $request->get('pollution_date');

        $truck = new Truck;
        $truck->reg_number      = $registrationNumber;
        $truck->description     = $description;
        $truck->truck_type_id   = $truckType;
        $truck->volume          = $volume;
        $truck->body_type       = $bodyType;
        $truck->insurance_upto  = $insuranceUpto;
        $truck->tax_upto        = $taxUpto;
        $truck->permit_upto     = $permitUpto;
        $truck->polution_upto   = $pollutionUpto;
        $truck->status          = 1;
        if($truck->save()) {
            return true;
        }
        
        return false;
    }
}
