<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//under construction
Route::get('/under/construction', 'LoginController@underConstruction')->name('under.construction');

Route::group(['middleware' => 'is.guest'], function() {
    Route::get('/', 'LoginController@publicHome')->name('public.home');

    Route::get('/login', 'LoginController@login')->name('login.view');
    Route::post('/login/action', 'LoginController@loginAction')->name('login.action');
});

Route::group(['middleware' => 'auth.check'], function () {
    //user validity expired
    Route::get('/user/expired', 'LoginController@userExpired')->name('user.expired');
    
    //common routes
    Route::get('/dashboard', 'DashboardController@dashboard')->name('user.dashboard');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::get('/user/profile', 'UserController@profileView')->name('user.profile');
    Route::post('/user/profile', 'UserController@profileUpdate')->name('user.profile.action');

    //user routes
    Route::group(['middleware' => ['user.role:1,2']], function () {
        //account
        Route::resource('accounts', 'AccountController');

        //staff
        Route::resource('employees', 'EmployeeController');

        //trucks
        Route::get('/trucks/{id}/edit-cert', 'TruckController@editCert')->name('truck.cert.edit');
        Route::post('/trucks/{id}/update-cert', 'TruckController@updateCert')->name('truck.cert.update');
        Route::resource('trucks', 'TruckController');

        //sites
        Route::resource('sites', 'SiteController');

        //transportation
        Route::resource('transportations', 'TransportationController');

        //supply
        Route::resource('supply', 'SupplyController');

        //expenses
        Route::resource('expenses', 'ExpenseController');

        //vouchers
        Route::resource('vouchers', 'VoucherController');

        //settings
        Route::resource('settings', 'SettingsController');

        //reports
        Route::get('reports/account-statement', 'ReportController@accountStatement')->name('report.account-statement');

        //ajax urls
        Route::group(['middleware' => 'is.ajax'], function () {
            //transportation form
            Route::get('/transportation/driver', 'TransportationController@driverByTruck')->name('transportation.driver.truck');
            Route::get('/transportation/contractor', 'TransportationController@contractorBySite')->name('transportation.contractor.site');
            Route::get('/transportation/rentDetail', 'TransportationController@rentDetailByCombo')->name('transportation.rentDetail.combo');
            //purchase form
            Route::get('/purchase/details', 'PurchaseController@purchaseDetailsByCombo')->name('purchase.detail.combo');
            //sale form
            Route::get('/sale/details', 'SaleController@saleDetailsByCombo')->name('sale.detail.combo');
        });
    });
});