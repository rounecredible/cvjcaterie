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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});



//Admin Routes
Route::get('/admin', 'AdminController@index');
Route::get('/ViewEvents', 'AdminController@viewEvents');
Route::get('/AddEventView', 'AdminController@addEventView');
Route::post('/AddEvent', 'AdminController@addEvent');
Route::get('/ViewClients', 'AdminController@viewClients');
Route::get('/AddClientView', 'AdminController@addClientView');
Route::post('/AddClient', 'AdminController@addClient');
Route::get('/BEO', 'AdminController@viewBEO');
Route::get('/Resources', 'AdminController@viewResources');
Route::get('/Reports', 'AdminController@viewReports');
Route::get('/Files', 'AdminController@viewFiles');
Route::get('/AdminSettings', 'AdminController@viewSettings');
Route::get('/Notifications', 'AdminController@viewNotifications');
Route::get('/Quotations', 'AdminController@viewQuotations');
Route::get('/chooseEvent', 'AdminController@chooseEvent');

Route::get('/addGrandWeddingView', 'AdminController@addGrandWeddingView');
Route::post('/AddGrandWedding', 'AdminController@addGrandWedding');

Route::get('/quotation/{id}', ['uses' => 'AdminController@updateQuotation', 'as' => 'quotation']);
Route::get('/confirmEvent/{id}', ['uses' => 'AdminController@confirmEvent', 'as' => 'confirmevent']);
Route::get('/confirm/{id}', ['uses' => 'AdminController@confirm', 'as' => 'confirm']);

Route::get('/AddEventDetailsView', 'AdminController@addEventDetailsView');
Route::post('/AddEventDetails', 'AdminController@addEventDetails');

Route::resource('clients', 'ClientsController');
Route::resource('events', 'EventsController');





//AE Routes
Route::get('/ae', 'AEController@index');
Route::get('/aeViewEvents', 'AEController@viewEvents');
Route::get('/aeAddEvent', 'AEController@addEvent');
Route::get('/aeViewClients', 'AEController@viewClients');
Route::get('/aeAddClient', 'AEController@addClient');
Route::get('/aeBEO', 'AEController@viewBEO');
Route::get('/aeBES', 'AEController@viewBES');


//Stockman Routes
Route::get('/stockman', 'StockmanController@viewResources');

//Finance Unit Routes
Route::get('/finance', 'FinanceController@index');

//Head Accountant Routes
Route::get('/accountant', 'AccountantController@index');

//Banquet Supervisor Routes
Route::get('/bs', 'BSController@index');

//Commissary Unit Routes
Route::get('/commissary', 'CommissaryController@index');

//Florist Routes
Route::get('/florist', 'FloristController@index');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
