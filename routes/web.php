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


Route::get('/', 'GetdataController@get_ten_tinh_theo_vung');
Route::get('/crawler', 'CrawlerController@connect_to_class');

/*---------------------------------------------------------*/
/*-----------------------Check connect database------------*/
/*---------------------------------------------------------*/


Route::get('connect', function () {
    if (DB::connection()->getDatabaseName()) {
        echo "conncted sucessfully to database " . DB::connection()->getDatabaseName();

        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            foreach ($table as $key => $value)
                echo $value;
        }
    }
});

