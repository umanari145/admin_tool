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
//Route::middleware(['jwt.auth'])->group(function () {
    Route::group(['prefix' => '/scan_terminal'], function () {
        Route::get('/', "Api\ScanTerminalController@index")->name('indexScanTerminal');
        Route::post('/', "Api\ScanTerminalController@create")->name('createScanTerminal');
        Route::put('/{scan_terminal_id}', "Api\ScanTerminalController@update")->name('updateScanTerminal');
        Route::delete('/', "Api\ScanTerminalController@delete")->name('deleteScanTerminal');
    });
    Route::group(['prefix' => '/company'], function () {
        Route::get('/', "Api\CompanyController@index")->name('indexCompany');
    });
    // logout
    Route::post('logout', 'Api\JwtController@logout')->name('logout');
//});

// login
Route::post('login', 'Api\JwtController@login')->name('login');
