<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Auth;
use App\Models\Settings;
use App\Repositories\SettingsRepository;

class AllViewComposer
{
    protected $currentUser, $settings;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(SettingsRepository $settingsRepo)
    {
        $this->currentUser  = Auth::user();
        $this->settings     = $settingsRepo->getSettings();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['currentUser' => $this->currentUser, 'settings' => $this->settings]);
    }
}