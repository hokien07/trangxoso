<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SingleController extends Controller
{
    public function get_ket_qua_tung_tinh($id, $vung) {
        $ket_qua = DB::table('ket_qua_mien_nam')
            ->select('*')
            ->where('id_tinh','=', $id)
            ->where('tinh_vung', '=', $vung)
            ->get();

        echo "<pre>";
       var_dump($ket_qua);

       echo "</pre>";
    }
}
