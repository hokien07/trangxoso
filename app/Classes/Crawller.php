<?php

namespace App\Classes;

use DB;


class Crawller
{
    /*
     * Code Crawller from xoso.me
     * All function create use from CrawllerController
     *
     * */

    /*----------------------------------------------------------------------------------------*/

    /*
     * Get link from xoso.me
     * Link from page --> not to home page
     * */

    public function check_connect() {
        return 'connect to Crawller class';
    }


    public function select_all() {
        $r = DB::table('ten_tinh')->select('*')->get();

        return $r;
    }


    public function select_by_id($select = '*',$sosanh, $value, $id) {
        $r = DB::table('ten_tinh')->select($select)->where($value, $sosanh, $id)->get();

        return $r;
    }

    /*
     * Select tinh theo vung mien
     * 0 == mien bac
     * 1 == mien trung
     * 2 == mien nam
     * 3 == xo so toan quoc -- xo si dien toan.
     * /
     *
     */

    public function select_tinh_by_vung($ma_vung) {
        $r = DB::table('ten_tinh')->select('*')->where('tinh_vung','=', $ma_vung)->get();

        return $r;
    }



}