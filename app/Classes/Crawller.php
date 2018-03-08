<?php

namespace App\Classes;

use DB;
use Curl\Curl;
use DiDom\Document;
use DiDom\Query;
use DiDom\Element;


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


    public function get_ten_tinh()
    {
        $r = DB::table('ten_tinh')->select('*')->get();

        return $r;
    }


    public function select_by_id($select = '*', $sosanh, $value, $id)
    {
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

    public function select_tinh_by_vung($ma_vung)
    {
        $r = DB::table('ten_tinh')->select('*')->where('tinh_vung', '=', $ma_vung)->get();

        return $r;
    }


    /*
     * Lay tat ca tin tuc moi tu database
     *
     * */
    public function lay_tat_ca_tin()
    {
        $r = DB::table('tin_tuc')->select('*')->get();

        return $r;
    }


    /*
     * lay thong tin thong ke
     * */

    public function lay_thong_ke()
    {
        $r = DB::table('thong_ke_ket_qua')->select('*')->get();

        return $r;
    }


    /*
     * lay thong tin quang cao.
     * */

    public function lay_thong_tin_qung_cao()
    {
        $r = DB::table('quang_cao')->select('*')->get();

        return $r;
    }


    /*
     * lay thong tin ngay thang
     * */

    public function lay_ngay_thang()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $weekday = date("l");
        $weekday = strtolower($weekday);
        switch ($weekday) {
            case 'monday':
                $weekday = 'Thứ hai';
                break;
            case 'tuesday':
                $weekday = 'Thứ ba';
                break;
            case 'wednesday':
                $weekday = 'Thứ tư';
                break;
            case 'thursday':
                $weekday = 'Thứ năm';
                break;
            case 'friday':
                $weekday = 'Thứ sáu';
                break;
            case 'saturday':
                $weekday = 'Thứ bảy';
                break;
            default:
                $weekday = 'Chủ nhật';
                break;
        }
        return $weekday . ' - ' . date('d/m/Y');
    }

    /*
     * lay ngay hom hay
     *
     * */
    public function get_date()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d');
        return $date;
    }


    /*
     * lay ket qua xo so theo ngay va theo vung
     *
     * */

    public function lay_ket_qua_theo_ngay_theo_vung($date, $ma_vung)
    {
        $r = DB::table('ket_qua_mien_bac')
            ->select('*')
            ->where('ngay_mo_thuong', '=', $date)
            ->where('tinh_vung', '=', $ma_vung)
            ->orderBy('id_ket_qua_mien_bac', 'desc')
            ->first();

        return $r;
    }

    /*
     * lay ket qua mien nam mo thuong
     *
     * */

    public function lay_ket_qua_mien_nam_mo_thuong()
    {

        $r = DB::table('ket_qua_mien_nam')
            ->select('*')
            ->join('ten_tinh', 'ten_tinh.id_tinh', '=', 'ket_qua_mien_nam.id_tinh')
            ->where('ten_tinh.mo_thuong', '=', 1)
            ->limit(4)
            ->get();

        return $r;
    }


    /*
     * danh sach tinh mo thuong hom nay
     * */

    public function get_tinh_mo_thuong_hom_nay()
    {
        $r = DB::table('ten_tinh')
            ->select('*')
            ->where('mo_thuong', '=', 1)
            ->get();

        return $r;
    }

    /*
     * crawller du lieu.
     *
     * */

//    public function get_tinh($content)
//    {
//        if ($this->get_data($content, $html)) {
//            /*get ten tih: */
//            preg_match_all('#a title="Kết quả xổ số (.+?)" href="#', $html, $match);
//
//            return $match;
//
//        } else {
//            echo "khong the connect to page" . PHP_EOL;
//        }
//    }

    /*lay tin moi nhat*/

    public function get_tin($content) {
        if($this->get_data($content, $data))
        $document = new Document();

        $document->loadHtmlFile($data);

        var_dump($document);
    }

    public function lay_ket_qua_mien_bac($content) {
        if($this->get_data($content, $data)) {
            preg_match_all('#title="Xổ số miền Bắc ngày (.+?)">Xổ số miền Bắc ngày#', $data, $ngay);

            echo "<pre>";
            var_dump($ngay[1]);
            echo "</pre>";

            echo "---------------------db---------------------------------------";
            preg_match_all('#<td class="txt-giai">Đặc biệt</td><td colspan="12" class="number"><b>(.+?)</b></td>#', $data, $db);

            echo "<pre>";
            var_dump($db[1]);
            echo "</pre>";



            echo "----------------------gn--------------------------------------";
            preg_match_all('#<td class="txt-giai">Giải nhất</td><td colspan="12" class="number"><b>(.+?)</b></td>#', $data, $gn);
            echo "<pre>";
            var_dump($gn[1]);
            echo "</pre>";


            echo "----------------------GN--------------------------------------";
            preg_match_all('#<td class="txt-giai">Giải nhì</td><td colspan="12" class="number"><b>(.+?)</b></td>#', $data, $giai_nhi_tt);
            echo "<pre>";
            var_dump($giai_nhi_tt);
            echo "</pre>";


        }
        else {
            echo "khong the ket noi toi url: " . $content;
        }
    }

    function get_data($link, &$data = '')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36');
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);


        $data = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if (empty($error)) {
            return true;
        }
        return false;
    }


}