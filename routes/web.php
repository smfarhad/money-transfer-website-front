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

Route::get('/', 'DashboardController@index')->name('/');

Auth::routes();
Route::get('logout','LoginController@logout')->name('logout');

//register
Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register','Auth\RegisterController@register')->name('register');

//profile
Route::get('/profile', 'AdminController@index')->name('profile');
Route::post('/profile', 'AdminController@profilePost')->name('profile');
Route::post('/addprofilepic', 'AdminController@addprofilepic')->name('addprofilepic');
Route::post('/change-password', 'AdminController@changePassword')->name('change-password');
Route::get('/new-user', 'AdminController@newUser')->name('new-user');
Route::post('/new-user', 'AdminController@storeNewUser')->name('new-user');
Route::get('/users', 'AdminController@userList')->name('users');
Route::post('/users-status', 'AdminController@userStatus')->name('users-status');

//Lock Screen
Route::get('/lockscreen', 'LockAccountController@lockscreen')->name('lockscreen');
Route::post('/lockscreen', 'LockAccountController@unlock')->name('lockscreen');

//registration auth varification
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
        
//transection 
Route::get('/single-transection', 'TransectionController@singleForm')->name('single-transection');
Route::post('/single-transection', 'TransectionController@singleCreate')->name('single-transection');
Route::get('/transection-completed', 'TransectionController@completed')->name('transection-completed');
Route::get('/transection-completed/{id}', 'TransectionController@completedById')->name('transection-completed');
Route::get('/transection-waiting', 'TransectionController@waiting')->name('transection-waiting');
Route::get('/transection-initial', 'TransectionController@initial')->name('transection-initial');
Route::get('/transection-daily', 'TransectionController@daily')->name('transection-daily');
Route::get('/transection-details/{id}', 'TransectionController@details')->name('transection-details');
Route::post('/transection-status', 'TransectionController@statusUpdate')->name('transection-status');
Route::get('/transection-failed', 'TransectionController@failedTransection')->name('transection-failed');
Route::post('/transaction-update', 'TransectionController@transactionUpdate')->name('transaction-update');
Route::post('/transaction-delete', 'TransectionController@transactionDelete')->name('transaction-delete');
//customer
Route::get('/customer-list', 'CustomerController@index')->name('customer-list');
Route::get('/customer-profile/{id}', 'CustomerController@profile')->name('customer-profile');
Route::post('/customer-profile/{id}', 'CustomerController@profilePost')->name('customer-profile');

//exchange Rate 
Route::get('/exchange-rate', 'Exchange_rateContrller@index')->name('exchange-rate');
Route::get('/exchange-rate/create', 'Exchange_rateContrller@create');
Route::post('/exchange-rate', 'Exchange_rateContrller@store')->name('exchange-rate');
Route::get('/exchange-rate/{id}/edit', 'Exchange_rateContrller@edit');
Route::post('/exchange-rate/update', 'Exchange_rateContrller@update');
Route::get('/exchange-rate/delete/{id}', 'Exchange_rateContrller@destroy');
// bakal intigration 
Route::get('/bakaal-add-remittance', 'BakaalController@addRemittance')->name('bakaal-add-remittance');
Route::get('/bakaal-add-mmt-remittance', 'BakaalController@addMMTRemittance')->name('bakaal-add-mmt-remittance');
Route::get('/bakaal-add-mpesa-remittance', 'BakaalController@addMpesaRemittance')->name('bakaal-add-mpesa-remittance');
Route::get('/bakaal-add-africa-remittance', 'BakaalController@addMMTAfricaRemittance')->name('bakaal-add-africa-remittance');

Route::get('/sms-After-Money-Delivery', 'BakaalController@smsAfterMoneyDelivery')->name('sms-After-Money-Delivery'); // sms send when pickup money

Route::get('/bakaal-get-remittance-status', 'BakaalController@getRemittanceStatus')->name('bakaal-get-remittance-status');
Route::get('/bakaal-get-exchange-rate', 'BakaalController@getExchangeRate')->name('bakaal-get-exchange-rate');
Route::get('/bakaal-get-agents-list', 'BakaalController@getAgentsList')->name('bakaal-get-agents-list');
Route::get('/bakaal-get-mmt-african-agents-list', 'BakaalController@MMTAfricaGetAllowedCountries')->name('bakaal-get-mmt-african-agents-list');

// dataField
Route::get('/datafield-get-branchlist', 'DataFieldController@getBranchList')->name('datafield-get-branchlist');
Route::get('/datafield-get-countrylist', 'DataFieldController@getCountryList')->name('datafield-get-countrylist');
Route::get('/datafield-remittance-request-final', 'DataFieldController@remittanceRequestFinal')->name('datafield-remittance-request-final');
Route::get('/datafield-get-remittancelist-final', 'DataFieldController@getRemittanceListFinal')->name('datafield-get-remittancelist-final');
Route::post('/change-api', 'DataFieldController@changeApi')->name('change-api');

//Route::match(['get', 'post'], 'register', function(){
//    return redirect('/');
//});

