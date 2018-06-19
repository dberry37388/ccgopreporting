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

Route::get('chart', 'WalkingListController@chart');

Route::group(['prefix' => 'precincts'], function() {
    Route::get('{precinct}', 'PrecinctController@show')->name('showPrecinct');
});

Route::group(['prefix' => 'lists', 'middleware' => 'auth'], function() {
    
    Route::get('walklist', function() {
        return new \App\Exports\MasterWalkList();
    })->name('walklist');
    
    Route::get('crossovers', function() {
        return new \App\Exports\CrossoversExport();
    })->name('crossovers');
    
    Route::get('first-time-voters', function() {
        return new \App\Exports\FirstTimeVotersExport();
    })->name('firstTimeVoters');
    
    Route::get('first-time-republican-voters', function() {
        return new \App\Exports\FirstTimeRepublicanVotersExport();
    })->name('firstTimeVoterRepublican');
    
    Route::get('first-time-democrat-voters', function() {
        return new \App\Exports\FirstTimeDemocratVotersExport();
    })->name('firstTimeVoterDemocrat');
});
