<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\KetquatinhController as Ketquatinh;

class TinhmothuongController extends Controller
{
    public function get_tinh_mo_thuong() {
        $ketquatinh = new Ketquatinh();

        $url = 'http://xoso.me/';
        if($ketquatinh->get_data($url, $data)) {

            preg_match_all('/<div class="box mo-thuong-ngay"><h2 class="title-bor"><strong>Các tỉnh mở thưởng hôm nay<\/strong><\/h2><table class="colgiai" cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr><td>(.+?)<\/td><td>(.+?)<\/td><td>(.+?)<\/td><\/tr><tr><td>(.+?)<\/td><td>(.+?)<\/td><td>(.+?)<\/td><\/tr><tr><td>(.+?)<\/td><td><\/td><td>(.+?)<\/td><\/tr><tr><td><\/td><td><\/td><td>(.+?)<\/td><\/tr><\/tbody><\/table><\/div>/', $data, $match);
           
            foreach($match as $key=>$tinh) {
                if($key > 0 ) {
                    preg_match_all('//', $data, $match);
                    echo "<pre>";
                    var_dump($tinh['']);
                    echo "</pre>";
                }
            }

        }

    }
}
