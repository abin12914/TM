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