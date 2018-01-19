<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $dates = ['transaction_date'];

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
