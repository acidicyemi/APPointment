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
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/', function () {
        return view('appiontment.layout');
    });
    
    Route::get('/list-appointments', 'AppointmentController@index')->name('index.appointments');
    Route::post('/list-appointments', 'AppointmentController@store')->name('store.appointments');
    Route::put('/update-appointments/{appointment}', 'AppointmentController@update')->name('update.appointments');
    Route::get('{any}', function () {
        return view('appiontment.layout');
    })->where('any', '.*');
});


