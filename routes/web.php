<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'api'], function () {
    Route::get('csv_category/{csv_category}', "Api\CsvController@getCsvField")->name('getCsvField');
    Route::post('csv_category/{csv_category}', "Api\CsvController@registCsvField")->name('registCsvField');
    Route::put('csv_field/{csv_id}', "Api\CsvController@updateCsvField")->name('updateCsvField');
    Route::delete('csv_field', "Api\CsvController@deleteCsvField")->name('deleteCsvField');
});


// vue対策でどんなURLできてもwelcomeに行くように
Route::get('/{any}', function () {
    return view('welcome');
})->where('any','.*');