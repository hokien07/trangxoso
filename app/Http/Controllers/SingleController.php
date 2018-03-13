<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\GetdataController as getdata;
use App\Classes\Crawller;

class SingleController extends Controller
{
    public function get_ket_qua_tung_tinh($id, $vung) {
        $ket_qua = DB::table('ket_qua_mien_nam')
            ->select('*')
            ->where('id_tinh','=', $id)
            ->where('tinh_vung', '=', $vung)
            ->get();

        $get_data = new getdata();
        $crawler = new Crawller();
        $ten_tinhs = $get_data->get_ten_tinh();
        $ngay = $crawler->lay_ngay_thang();

        return view('single', compact('ten_tinhs', 'ngay', 'ket_qua'));
    }
}
