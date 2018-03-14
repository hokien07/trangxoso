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

    
            // lay ket qua mien nam moi nhat.
        $mien_nam_first = DB::table('ket_qua_mien_nam')
            ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
            ->where('ket_qua_mien_nam.id_tinh', '=', 10)
            ->orderBy('id_ket_qua_xo_so', 'ASC')
            ->select('ket_qua_mien_nam.*', 'ten_tinh.ten_tinh')
            ->first();


            // lay ket qua mien nam moi nhat.
            $mien_nam_second = DB::table('ket_qua_mien_nam')
            ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
            ->where('ket_qua_mien_nam.id_tinh', '=', 12)
            ->orderBy('id_ket_qua_xo_so', 'ASC')
            ->select('ket_qua_mien_nam.*', 'ten_tinh.ten_tinh')
            ->first();

            // lay ket qua mien nam moi nhat.
            $mien_nam_there = DB::table('ket_qua_mien_nam')
            ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
            ->where('ket_qua_mien_nam.id_tinh', '=', 8)
            ->orderBy('id_ket_qua_xo_so', 'ASC')
            ->select('ket_qua_mien_nam.*', 'ten_tinh.ten_tinh')
            ->first();



             // lay ket qua mien nam moi nhat.
             $mien_nam_there = DB::table('ket_qua_mien_nam')
             ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
             ->where('ket_qua_mien_nam.id_tinh', '=', 8)
             ->orderBy('id_ket_qua_xo_so', 'ASC')
             ->select('ket_qua_mien_nam.*', 'ten_tinh.ten_tinh')
             ->first();

              // lay ket qua mien trung moi nhat.
            $mien_trung_first = DB::table('ket_qua_mien_nam')
            ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
            ->where('ket_qua_mien_nam.id_tinh', '=', 29)
            ->orderBy('id_ket_qua_xo_so', 'ASC')
            ->select('ket_qua_mien_nam.*', 'ten_tinh.ten_tinh')
            ->first();

              // lay ket qua mien trung moi nhat.
              $mien_trung_second = DB::table('ket_qua_mien_nam')
              ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
              ->where('ket_qua_mien_nam.id_tinh', '=', 28)
              ->orderBy('id_ket_qua_xo_so', 'ASC')
              ->select('ket_qua_mien_nam.*', 'ten_tinh.ten_tinh')
              ->first();

                // lay ket qua mien trung moi nhat.
            $mien_trung_there = DB::table('ket_qua_mien_nam')
            ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
            ->where('ket_qua_mien_nam.id_tinh', '=', 31)
            ->orderBy('id_ket_qua_xo_so', 'ASC')
            ->select('ket_qua_mien_nam.*', 'ten_tinh.ten_tinh')
            ->first();


            $tin_moi  = $this->get_news();


        return view('home', compact('ten_tinhs', 'ngay', 'kq', 'mien_nam_first', 'mien_nam_second', 'mien_nam_there', 'mien_trung_first', 'mien_trung_second', 'mien_trung_there', 'tin_moi'));
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

    public function get_news () {
        //lay tin tuc.
        $tin_moi = DB::table('tin_tuc')
        ->select('*')
        ->orderBy('id_tin', 'ASC')
        ->take(5)
        ->get();

        return $tin_moi;
    }
}
