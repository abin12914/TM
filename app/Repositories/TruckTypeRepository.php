<?php

namespace App\Repositories;

use App\Models\TruckType;

class TruckTypeRepository
{

    protected $truckType;

    public function __construct(TruckType $truckType)
    {
        $this->truckType = $truckType;
    }

    /**
     * Return truck types.
     */
    public function getTruckTypes()
    {
        $truckTypes = [];
        
        $truckTypes = $this->truckType->where('status', 1)->orderBy('name')->get();

        return $truckTypes;
    }
}
