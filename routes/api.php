<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['jwt.auth'])->group(function () {
    Route::group(['prefix' => '/scan_terminal'], function () {
        Route::get('/', "Api\ScanTerminalController@index")->name('indexScanTerminal');
        Route::post('/', "Api\ScanTerminalController@store")->name('createScanTerminal');
        Route::put('/{scan_terminal_id}', "Api\ScanTerminalController@update")->name('updateScanTerminal');
        Route::delete('/', "Api\ScanTerminalController@delete")->name('deleteScanTerminal');
    });

    Route::group(['prefix' => '/company'], function () {
        Route::get('/', "Api\CompanyController@index")->name('indexCompany');
    });

    Route::group(['prefix' => '/csv_category'], function () {
        Route::get('/{csv_category}', "Api\CsvController@show")->name('getCsvField');
        Route::post('/{csv_category}', "Api\CsvController@store")->name('registCsvField');
    });

    Route::group(['prefix' => '/csv_field'], function () {
        Route::put('/{csv_id}', "Api\CsvController@update")->name('updateCsvField');
        Route::delete('', "Api\CsvController@delete")->name('deleteCsvField');
    });

    // logout
    Route::get('check', 'Api\JwtController@check')->name('check');
    Route::post('logout', 'Api\JwtController@logout')->name('logout');
});

// login
Route::post('login', 'Api\JwtController@login')->name('login');
