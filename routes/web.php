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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('download', 'WalkingListController@download')->name('downloadWalklist');

Route::get('crossovers', function() {
    return new \App\Exports\CrossoversExport();
});


Route::get('first-time-voters', function() {
    return new \App\Exports\FirstTimeVotersExport();
});

Route::get('first-time-republican-voters', function() {
    return new \App\Exports\FirstTimeRepublicanVotersExport();
});

Route::get('first-time-democrat-voters', function() {
    return new \App\Exports\FirstTimeDemocratVotersExport();
});
