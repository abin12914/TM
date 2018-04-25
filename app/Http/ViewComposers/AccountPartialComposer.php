<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\AccountRepository;

class AccountPartialComposer
{
    protected $accounts;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(AccountRepository $accountRepo)
    {
        $this->accounts = $accountRepo->getAccounts();
        $cashAccount    = $accountRepo->getAccounts(['account_name' => 'Cash'], 1, false);//retrieving cash account

        if(!empty($cashAccount) && !empty($cashAccount->id)) {
            if(empty($this->accounts) && count($this->accounts) <= 0) {
                $this->accounts = collect([$cashAccount]);
            } else {
                $this->accounts->push($cashAccount);//pushing cash account to account list
            }
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['accounts' => $this->accounts]);
    }
}