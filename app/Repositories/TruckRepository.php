<?php

namespace App\Repositories;

use App\Models\Truck;
use Illuminate\Support\Facades\DB;
use App\Models\TruckType;
use \Carbon\Carbon;

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
     * Return truck types.
     */
    public function getTruckTypes()
    {
        $truckTypes = [];
        
        $truckTypes = TruckType::where('status', 1)->orderBy('name')->get();

        return $truckTypes;
    }

    /**
     * Return truck types.
     */
    public function getTrucks()
    {
        $trucks = [];
        
        $trucks = Truck::where('status', 1)->paginate(15);

        return $trucks;
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
        $insuranceUpto      = Carbon::createFromFormat('d-m-Y', $request->get("insurance_date"))->format('Y-m-d');
        $taxUpto            = Carbon::createFromFormat('d-m-Y', $request->get("tax_date"))->format('Y-m-d');
        $permitUpto         = Carbon::createFromFormat('d-m-Y', $request->get("permit_date"))->format('Y-m-d');
        $pollutionUpto      = Carbon::createFromFormat('d-m-Y', $request->get("pollution_date"))->format('Y-m-d');

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
            return [
                'flag'  => true,
                'id'    => $truck->id
            ];
        }
        
        return [
            'flag'      => false,
            'errorCode' => "01/01"
        ];
    }
}
