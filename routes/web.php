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
Route::get('/under/construction', 'LoginController@underConstruction')->name('under-construction');

Route::group(['middleware' => 'is.guest'], function() {
    Route::get('/', 'LoginController@publicHome')->name('public-home');

    Route::get('/login', 'LoginController@login')->name('login-view');
    Route::post('/login/action', 'LoginController@loginAction')->name('login-action');
});

Route::group(['middleware' => 'auth.check'], function () {
    //user validity expired
    Route::get('/user/expired', 'LoginController@userExpired')->name('user-expired');
    
    //common routes
    Route::get('/dashboard', 'LoginController@dashboard')->name('user-dashboard');
    Route::get('/my/profile', 'UserController@profileView')->name('user-profile-view');
    Route::get('/my/profile/edit', 'UserController@editProfile')->name('edit-profile');
    Route::post('/my/profile/update/action', 'UserController@updateProfile')->name('profile-update-action');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    //superadmin routes
    Route::group(['middleware' => ['user.role:superadmin,']], function () {
        Route::get('/user/register', 'UserController@register')->name('user-register-view');
        Route::post('/user/register/action', 'UserController@registerAction')->name('user-register-action');
        Route::get('/user/list', 'UserController@userList')->name('user-list');

        Route::get('/owner/register', 'UserController@ownerRegister')->name('owner-register-view');
        Route::post('/owner/register/action', 'UserController@ownerRegisterAction')->name('owner-register-action');
        Route::get('/owner/list', 'UserController@ownerList')->name('owner-list');

        //product
        Route::get('/product/register', 'ProductController@register')->name('product-register-view');
        Route::post('/product/register/action', 'ProductController@registerAction')->name('product-register-action');
        Route::get('/product/list/superadmin', 'ProductController@productList')->name('product-list-superadmin');
    });

    //admin routes
    Route::group(['middleware' => ['user.role:admin,']], function () {
        //vehicle type
        Route::get('/truck-type/register', 'TruckTypeController@register')->name('truck-type-register-view');
        Route::post('/truck-type/register/action', 'TruckTypeController@registerAction')->name('truck-type-register-action');

        //edit
        //account
        Route::get('/account/edit', 'AccountController@edit')->name('account-edit-view');
        Route::post('/account/updation/action', 'AccountController@updationAction')->name('account-updation-action');
        //employee
        Route::get('/hr/employee/edit', 'EmployeeController@edit')->name('employee-edit-view');
        Route::post('/hr/employee/updation/action', 'EmployeeController@updationAction')->name('employee-updation-action');
        //excavator
        Route::get('/machine/excavator/edit', 'ExcavatorController@edit')->name('excavator-edit-view');
        Route::post('/machine/excavator/updation/action', 'ExcavatorController@updationAction')->name('excavator-updation-action');
    });

    //user routes
    Route::group(['middleware' => ['user.role:1,2']], function () {
        //account
        Route::resource('accounts', 'AccountController');
        /*Route::get('/account/register', 'AccountController@register')->name('account-register-view');
        Route::post('/account/register/action', 'AccountController@registerAction')->name('account-register-action');
        Route::get('/account/list', 'AccountController@accountList')->name('account-list');*/

        //staff
        Route::resource('employees', 'EmployeeController');
        /*Route::get('/hr/employee/register', 'EmployeeController@register')->name('employee-register-view');
        Route::post('/hr/employee/register/action', 'EmployeeController@registerAction')->name('employee-register-action');
        Route::get('/hr/employee/list', 'EmployeeController@employeeList')->name('employee-list');
        Route::get('/employee/get/account/{id}', 'EmployeeController@getEmployeeByaccountId')->name('employee-get-by-account-id');
        Route::get('/employee/get/employee/{id}', 'EmployeeController@getEmployeeByEmployeeId')->name('employee-get-by-employee-id');*/

        
        //trucks
        Route::resource('trucks', 'TruckController');
        /*Route::get('/truck/register', 'TruckController@register')->name('truck-register-view');
        Route::post('/truck/register/action', 'TruckController@registerAction')->name('truck-register-action');
        Route::get('/truck/list', 'TruckController@truckList')->name('truck-list');*/

        //truck type
        Route::get('/truck-type/list', 'TruckTypeController@truckTypeList')->name('truck-type-list');
        Route::get('/truck-type/chart', 'TruckTypeController@chart')->name('truck-type-chart');

        //sites
        Route::resource('sites', 'SiteController');

        //transportation
        Route::resource('transportations', 'TransportationController');

        //supply
        Route::resource('supply', 'SupplyController');

        //sales
        Route::get('/sales/register', 'SalesController@register')->name('sales-register-view');
        Route::post('/sales/credit/register/action', 'SalesController@creditSaleRegisterAction')->name('credit-sales-register-action')->middleware('date.restrict');
        Route::post('/sales/cash/register/action', 'SalesController@cashSaleRegisterAction')->name('cash-sales-register-action')->middleware('date.restrict');
        Route::get('/sales/multiple/register', 'SalesController@multipleSaleRegister')->name('multiple-sales-register-view');
        Route::post('/sales/multiple/credit/register/action', 'SalesController@multipleCreditSaleRegisterAction')->name('multiple-credit-sales-register-action')->middleware('date.restrict');
        Route::get('/sales/bill/print/{id}', 'SalesController@saleBillPrint')->name('sales-bill-print');

        Route::get('/sales/list', 'SalesController@salesList')->name('sales-list-search');
        Route::get('/sales/get/last/truck/{id}', 'SalesController@getLastSaleByTruckId')->name('sale-get-last-by-truck-id');

        //sales /weighment updation
        Route::get('/sales/weighment/pending/list', 'SalesController@weighmentPending')->name('sales-weighment-pending-view');
        Route::get('/sales/weighment/register', 'SalesController@weighmentRegister')->name('sales-weighment-register-view');
        Route::post('/sales/weighment/register/action', 'SalesController@weighmentRegisterAction')->name('sales-weighment-register-action')->middleware('date.restrict');

        //purchases
        Route::get('/purchases/register', 'PurchasesController@register')->name('purchases-register-view');
        Route::post('/purchases/register/action', 'PurchasesController@registerAction')->name('purchases-register-action')->middleware('date.restrict');
        Route::get('/purchases/list', 'PurchasesController@purchaseList')->name('purchases-list-search');

        //product
        Route::get('/product/list', 'ProductController@productList')->name('product-list');

        //daily statement
        Route::get('/daily-statement/register', 'DailyStatementController@register')->name('daily-statement-register-view');
        Route::post('/daily-statement/employee/attendance/action', 'DailyStatementController@employeeAttendanceAction')->name('daily-statement-employee-attendance-action')->middleware('date.restrict');
        Route::post('/daily-statement/excavator/readings/action', 'DailyStatementController@excavatorReadingsAction')->name('daily-statement-excavator-readings-action')->middleware('date.restrict');
        Route::post('/daily-statement/jackhammer/readings/action', 'DailyStatementController@jackhammerReadingsAction')->name('daily-statement-jackhammer-readings-action')->middleware('date.restrict');
        //daily statement list
        Route::get('/daily-statement/list/employee', 'DailyStatementController@employeeAttendanceList')->name('daily-statement-list-employee');
        Route::get('/daily-statement/list/excavator', 'DailyStatementController@excavatorReadingList')->name('daily-statement-list-excavator');
        Route::get('/daily-statement/list/jackhammer', 'DailyStatementController@jackhammerReadingList')->name('daily-statement-list-jackhammer');

        //monthly statement
        Route::get('/monthly-statement/register', 'MonthlyStatementController@register')->name('monthly-statement-register-view');
        Route::post('/monthly-statement/employee/salary/action', 'MonthlyStatementController@employeeSalaryAction')->name('monthly-statement-employee-salary-action')->middleware('date.restrict');
        Route::post('/monthly-statement/excavator/rent/action', 'MonthlyStatementController@excavatorRentAction')->name('monthly-statement-excavator-rent-action')->middleware('date.restrict');
        Route::get('/monthly-statement/list/employee', 'MonthlyStatementController@employeeSalaryList')->name('monthly-statement-list-employee');
        Route::get('/monthly-statement/list/excavator', 'MonthlyStatementController@excavatorRentList')->name('monthly-statement-list-excavator');

        //vouchers
        Route::get('/voucher/register', 'VoucherController@register')->name('voucher-register-view');
        Route::post('/cash/voucher/register/action', 'VoucherController@cashVoucherRegistrationAction')->name('cash-voucher-register-action')->middleware('date.restrict');
        Route::post('/credit/voucher/register/action', 'VoucherController@creditVoucherRegistrationAction')->name('credit-voucher-register-action')->middleware('date.restrict');
        Route::get('/get/details/by/account/{id}', 'VoucherController@getAccountDetailsByaccountId')->name('get-details-by-account-id');
        Route::get('/voucher/list/cash', 'VoucherController@cashVoucherList')->name('cash-voucher-list');
        Route::get('/voucher/list/credit', 'VoucherController@creditVoucherList')->name('credit-voucher-list');
        Route::get('/voucher/list/machine/through', 'VoucherController@machineThroughVoucherList')->name('machine-through-voucher-list');

        //final statement
        Route::get('/statement/credit-list', 'AccountController@creditList')->name('credit-list');
        Route::get('/statement/account-statement', 'AccountController@accountSatementSearch')->name('account-statement-list-search');
        Route::get('/statement/daily-statement', 'DailyStatementController@dailySatementSearch')->name('daily-statement-list-search');
        Route::get('/statement/sale', 'SalesController@statement')->name('sale-statement-list-search');

        //profit loss share distribution
        Route::get('/statement/profit-loss', 'AccountController@profitLoss')->name('profit-loss-statement-list');
        Route::post('/statement/profit-loss/action', 'AccountController@profitLossAction')->name('profit-loss-statement-action');
    });
});