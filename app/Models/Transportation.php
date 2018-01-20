<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trips';

    public $timestamps = false;

    protected $dates = ['date'];

    /**
     * Get the transaction details associated with the transportation
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transaction_id');
    }

    /**
     * Get the vehicle details associated with the transportation
     */
    public function truck()
    {
        return $this->belongsTo('App\Models\Truck','truck_id');
    }

    /**
     * Get the source site details associated with the transportation
     */
    public function source()
    {
        return $this->belongsTo('App\Models\Site','source_id');
    }

    /**
     * Get the destination site details associated with the transportation
     */
    public function destination()
    {
        return $this->belongsTo('App\Models\Site','destination_id');
    }

    /**
     * Get the material details associated with the transportation
     */
    public function material()
    {
        return $this->belongsTo('App\Models\Material','material_id');
    }

    /**
     * Get the employee details associated with the transportation
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','driver_id');
    }
}
