<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'report'], function() {
    Route::post('process-data', 'ReportController@processReportData')->name('report.process-data');
    Route::get('download', 'ReportController@downloadReport')->name('report.download');
});
