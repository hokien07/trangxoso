<?php

namespace App\Http\Controllers;

use App\Classes\Crawller;
use Illuminate\Http\Request;

class GetdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    /*
   * Select tinh theo vung mien
   * 0 == mien bac
   * 1 == mien trung
   * 2 == mien nam
   * 3 == xo so toan quoc -- xo si dien toan.
   * /
   *
   */

    public function get_ten_tinh()
    {
        $crawller = new Crawller();

        $ten_tinh = $crawller->get_ten_tinh();
        $all_tin = $crawller->lay_tat_ca_tin();
        $thong_ke = $crawller->lay_thong_ke();
        $quang_caos = $crawller->lay_thong_tin_qung_cao();
        $ngay_thang = $crawller->lay_ngay_thang();

        $date = $crawller->get_date();
        $ket_qua_mien_bac = $crawller->lay_ket_qua_theo_ngay_theo_vung('2018-03-04', 0);
        $ket_qua_mien_nam = $crawller->lay_ket_qua_mien_nam_mo_thuong();


        $mien_bac = [];
        $mien_nam = [];
        $mien_trung = [];
        $dien_toan = [];

        foreach ($ten_tinh as $key => $tinh_theo_vung) {
            if ($tinh_theo_vung->tinh_vung == 0) {
                array_push($mien_bac, $tinh_theo_vung->ten_tinh);
            } elseif ($tinh_theo_vung->tinh_vung == 2) {
                array_push($mien_trung, $tinh_theo_vung->ten_tinh);
            } elseif ($tinh_theo_vung->tinh_vung == 1) {
                array_push($mien_nam, $tinh_theo_vung->ten_tinh);
            } else {
                array_push($dien_toan, $tinh_theo_vung->ten_tinh);
            }
        }

        return view('home', compact('ten_tinh', 'mien_bac', 'mien_trung', 'mien_nam', 'dien_toan', 'all_tin', 'thong_ke', 'quang_caos', 'ngay_thang', 'ket_qua_mien_bac', 'ket_qua_mien_nam'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
