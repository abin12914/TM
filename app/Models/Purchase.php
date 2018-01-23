<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps = false;

    protected $dates = ['date'];
    
    /**
     * Get the transaction details associated with the purchase
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transaction_id');
    }

    /**
     * Get the transportation details associated with the purchase
     */
    public function transportation()
    {
        return $this->belongsTo('App\Models\Transportation','trip_id');
    }
}
