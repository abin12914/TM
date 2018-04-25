<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //current user and settings to all views
        View::composer('*', "App\Http\ViewComposers\AllViewComposer");
        //accounts to views
        View::composer(['expenses.register', 'expenses.list', 'supply.list', 'supply.register', 'transportations.register', 'transportations.list', 'vouchers.register', 'vouchers.list', 'reports.account-statement'], "App\Http\ViewComposers\AccountPartialComposer");
        //trucks to views
        View::composer(['expenses.register', 'expenses.list', 'supply.list', 'supply.register', 'transportations.register', 'transportations.list'], "App\Http\ViewComposers\TruckPartialComposer");
        //sites to views
        View::composer(['supply.list', 'supply.register', 'transportations.register', 'transportations.list'], "App\Http\ViewComposers\SitePartialComposer");
        //employee to views
        View::composer(['supply.list', 'supply.register', 'transportations.register', 'transportations.list'], "App\Http\ViewComposers\EmployeePartialComposer");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
