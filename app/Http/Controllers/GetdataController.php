<?php

namespace App\Http\Controllers;

use App\Classes\Crawller;
use Illuminate\Http\Request;
use DB;
use App\Tinh_Theo_Vung;

class GetdataController extends Controller
{
    public function index()
    {
        $ten_tinhs = $this->get_ten_tinh();
        $crawl = new Crawller();
        $ngay = $crawl->lay_ngay_thang();
        $to_day = $crawl->get_date();

        //lay ket qua mien bac moi nhat.

        $kq = DB::table('ket_qua_mien_nam')
            ->select('*')
            ->where('tinh_vung', '=', 0)
            ->orderBy('id_ket_qua_xo_so', 'ASC')
            ->first();


        return view('home', compact('ten_tinhs', 'ngay', 'kq'));
    }


    public function get_ten_tinh()
    {

        /*Tinh vung luu y:
      * Tinh vung = 0: mien bac
       * Tinh vung = 1 : xo so dien toan
       * Tinh vung = 2 : Mien trung
       * Tinh vung = 3 : Mien nam*/


        $tinh_theo_vung = [];
        $mien_bac = [];
        $mien_trung = [];
        $mien_nam = [];
        $xoso_dien_toan = [];

        $tentinhs = DB::table('ten_tinh')->select('id_tinh', 'ten_tinh', 'tinh_vung')->get();

        foreach ($tentinhs as $key => $tentinh) {
            switch ($tentinh->tinh_vung) {
                case 0:
                    $tinh = new Tinh_Theo_Vung();
                    $tinh->ten_tinh = $tentinh->ten_tinh;
                    $tinh->id_tinh = $tentinh->id_tinh;
                    $tinh->tinh_vung = $tentinh->tinh_vung;
                    array_push($mien_bac, $tinh);
                    break;

                case 1:
                    $tinh = new Tinh_Theo_Vung();
                    $tinh->ten_tinh = $tentinh->ten_tinh;
                    $tinh->id_tinh = $tentinh->id_tinh;
                    $tinh->tinh_vung = $tentinh->tinh_vung;
                    array_push($xoso_dien_toan, $tinh);
                    break;
                case 2:
                    $tinh = new Tinh_Theo_Vung();
                    $tinh->ten_tinh = $tentinh->ten_tinh;
                    $tinh->id_tinh = $tentinh->id_tinh;
                    $tinh->tinh_vung = $tentinh->tinh_vung;
                    array_push($mien_trung, $tinh);
                    break;
                case 3:
                    $tinh = new Tinh_Theo_Vung();
                    $tinh->ten_tinh = $tentinh->ten_tinh;
                    $tinh->id_tinh = $tentinh->id_tinh;
                    $tinh->tinh_vung = $tentinh->tinh_vung;
                    array_push($mien_nam, $tinh);
                    break;
            }
        }

        array_push($tinh_theo_vung, $mien_bac, $xoso_dien_toan, $mien_trung, $mien_nam);


        return $tinh_theo_vung;
    }
}
