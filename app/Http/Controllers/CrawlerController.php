<?php

namespace App\Http\Controllers;

use App\Classes\Crawller;
use Illuminate\Http\Request;
use DB;
use App\Model\ten_tinh AS Ten_Tinh;


class CrawlerController extends Controller
{
//    public function get_content() {
//        $curl = new Crawller();
//
//        $url = 'http://xoso.me/';
//
//
//        /*lay ten tinh - chi lam 1 lan*/
//
////        $ten_tinh = $curl->get_tinh($url);
//
////        foreach ($ten_tinh[1] as $value) {
////
////            DB::table('ten_tinh')->insert(
////                ['ten_tinh' => $value, 'mo_thuong' => 0, 'tinh_vung'=>0]
////            );
////
////            echo "chen xong tinh: " . $value . "<hr/>";
////        }
//    }

    public function get_tin_moi_nhat() {
        $crawller = new Crawller();
        $url= 'http://xoso.me/';
        $crawller->get_tin($url);
    }

    public function Lay_ket_qua_mien_bac() {
        $crawller = new Crawller();
        $url = 'http://xoso.me/kqxsmb-xstd-ket-qua-xo-so-mien-bac.html';

        $content = $crawller->lay_ket_qua_mien_bac($url);

        echo $content;

    }
}
