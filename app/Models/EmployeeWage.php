<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeWage extends Model
{
    public $timestamps = false;

    protected $dates = ['date'];

    /**
     * Get the transaction details associated with the wage
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transaction_id');
    }

    /**
     * Get the transportation details associated with the wage
     */
    public function transportation()
    {
        return $this->belongsTo('App\Models\Transporation','trip_id');
    }
}
