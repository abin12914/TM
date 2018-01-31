<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transportation extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trips';

    public $timestamps = false;

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

    /**
     * Get the purchase record associated with the transportation if it is a supply.
     */
    public function purchase()
    {
        return $this->hasOne('App\Models\Purchase', 'trip_id');
    }

    /**
     * Get the sale record associated with the transportation if it is a supply.
     */
    public function sale()
    {
        return $this->hasOne('App\Models\Sale', 'trip_id');
    }

    /**
     * Get the purchase record associated with the transportation if it is a supply.
     */
    public function employeeWage()
    {
        return $this->hasOne('App\Models\EmployeeWage', 'trip_id');
    }
}
