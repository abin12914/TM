<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $timestamps = false;

    protected $dates = ['date'];

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
