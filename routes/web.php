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


/*--------------------------------------------------------*/
/*---------------get Content-----------------------------*/
/*--------------------------------------------------------*/

Route::get('/', 'GetdataController@get_ten_tinh');

/*--------------------------------------------------------*/
/*---------------Crawller data-----------------------------*/
/*--------------------------------------------------------*/


Route::get('/crawler', 'CrawlerController@get_content');
Route::get('/lay-tin-moi-nhat', 'CrawlerController@get_tin_moi_nhat');



/*---------------------------------------------------------*/
/*-----------------------Lay ket qua mien bac------------*/
/*---------------------------------------------------------*/
Route::get('lay-ket-qua-mien-bac', 'CrawlerController@Lay_ket_qua_mien_bac');

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

