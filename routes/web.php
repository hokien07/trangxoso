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

Route::get('/', 'GetdataController@index');
Route::get('{id}/{vung}/ket-qua', ['as'=>'ket-qua', 'uses'=>'SingleController@get_ket_qua_tung_tinh']);
Route::get('{id}/xem-tin', ['as'=>'xem-tin', 'uses'=>'TintucController@xem_tin']);
Route::get('/tin-tuc', 'TintucController@get_all_tin_tuc');
Route::post('{id}/xoa-tin', 'TintucController@xoa_tin')->name('xoa-tin');
Route::get('{id}/sua-tin', 'TintucController@sua_tin')->name('sua-tin');
/*--------------------------------------------------------*/
/*---------------Crawller data-----------------------------*/
/*--------------------------------------------------------*/


Route::get('/lay-tin', 'TintucController@get_tin_tuc');
Route::get('/tin-tuc', 'TintucController@get_all_tin_tuc');



/*---------------------------------------------------------*/
/*-----------------------Lay ket qua mien bac------------*/
/*---------------------------------------------------------*/
Route::get('lay-ket-qua-mien-bac', 'KetquamienbacController@Lay_ket_qua');
Route::get('lay-ket-qua-tinh', 'KetquatinhController@Lay_ket_qua');
Route::get('lay-ket-qua-dien-toan', 'KetquadientoanController@dien_toan');
Route::get('lay-tinh-mo-thuong', 'TinhmothuongController@get_tinh_mo_thuong');





/*---------------------------------------------------------*/
/*-----------------------Admin Controller------------*/
/*---------------------------------------------------------*/

Route::get('/login', 'AdminController@login')->name('login');
Route::get('/dang-ky', 'AdminController@get_dang_ky')->name('dang-ky');

Route::post('dang-nhap', 'AdminController@post_dang_nhap')->name('dang-nhap');
Route::post('/dang-ky','AdminController@post_dang_ky')->name('dang-ky');



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


<<<<<<< HEAD

=======
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
>>>>>>> 60bda67c18c68374bc14b11678fca287cac797f9
