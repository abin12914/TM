<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\TruckRepository;

class TruckPartialComposer
{
    protected $trucks;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(TruckRepository $truckRepo)
    {
        $this->trucks = $truckRepo->getTrucks();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['trucks' => $this->trucks]);
    }
}