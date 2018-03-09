<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\SiteRepository;

class SitePartialComposer
{
    protected $sites;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(SiteRepository $siteRepo)
    {
        $this->sites = $siteRepo->getSites();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['sites' => $this->sites]);
    }
}