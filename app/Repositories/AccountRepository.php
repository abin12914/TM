<?php

namespace App\Repositories;

use App\Models\Account;

class TruckRepository
{

    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Action for saving accounts.
     */
    public function saveTruck($request)
    {
        
    }
}
