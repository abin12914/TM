<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
     use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['transaction_date', 'deleted_at'];

    /**
     * Get the debit account details associated with a transaction
     */
    public function debitAccount()
    {
        return $this->belongsTo('App\Models\Account','debit_account_id');
    }

    /**
     * Get the credit account details associated with a transaction
     */
    public function creditAccount()
    {
        return $this->belongsTo('App\Models\Account','credit_account_id');
    }
}
