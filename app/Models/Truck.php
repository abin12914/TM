<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    /**
     * Get the truck type details of the vehicle
     */
    public function truckType()
    {
        return $this->belongsTo('App\Models\TruckType');
    }
}
