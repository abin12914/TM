<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\Transportation;
use App\Models\Sale;
use \Carbon\Carbon;

class SupplyRepository
{
    public $measureTypes = [
            1   => 'Weighment [Ton]',
            2   => 'Volume [Feet]',
            3   => 'Fixed For TruckType',
        ];

    /**
     * Return transportations.
     */
    public function getSupplys()
    {
        $supplys = [];

        return $supplys;
    }


    /**
     * Return statecodes.
     */
    public function saveSupply($request)
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
}
