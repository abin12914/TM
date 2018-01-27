<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'deleted_at'];

    public $timestamps = false;

    /**
     * Get the transaction details associated with the expense
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transaction_id');
    }

    /**
     * Get the vehicle details associated with the expense
     */
    public function truck()
    {
        return $this->belongsTo('App\Models\Truck','truck_id');
    }

    /**
     * Get the service details associated with the expense
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id');
    }
}
