<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ket_qua_xo_so_dien_toan_123;
use App\Model\ten_tinh;

class KetquadientoanController extends Controller
{
    public function dien_toan() {
        $dientoan123 = $this->dien_toan_123();
        $dientoan636 = $this->dien_toan_636();
        $dientoanthantai = $this->dien_toan_than_tai();
    }






    public function dien_toan_123 () {
        $url = 'http://xoso.me/kq-xsdt-123-ket-qua-xo-so-dien-toan-123-truc-tiep-hom-nay.html';

        /*Tinh vung luu y:
       * Tinh vung = 0: mien bac
        * Tinh vung = 1 : xo so dien toan
        * Tinh vung = 2 : Mien trung
        * Tinh vung = 3 : Mien nam*/

        $tinh_vung = 1;
        $id_tinh =  37;
        $ma_tinh = '';

        preg_match('/kq-xsdt-123-ket-qua-(.+?)-truc-tiep/', $url, $match);
        $ten_khong_dau = $match[1];

        $ten_co_dau = '';
        if ($this->get_data($url, $data)) {
            preg_match('/Kết quả (.+?) ngày/', $data, $match);
            $ten_co_dau = $match[1];
        }

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        $mngay = [];
        if ($this->get_data($url, $data)) {
            preg_match_all('/<strong>Kết quả xổ số điện toán 123 ngày (.+?)<\/strong>/', $data, $ngay);
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }
        }


        $mgiai = [];
        if ($this->get_data($url, $data)) {
            preg_match_all('/<div><span>(\d+)<\/span><span>(\d+)<\/span><span>(\d+)<\/span><\/div>/', $data, $match);

            if($match && $match[1] && $match[2] && $match[3]) {
                for ($loop = 0; $loop < sizeof($match[1]); $loop++) {
                    if (array_key_exists($loop, $match[1]) && array_key_exists($loop, $match[2]) && array_key_exists($loop, $match[3])) {
                        $tung_giai = $match[1][$loop] . ',' . $match[2][$loop] . ',' . $match[3][$loop];
                        array_push($mgiai, $tung_giai);
                    }
                }

            }
        }

        $mtung_ngay = [];
        $mtung_ngay_group = [];
        for ($i = 0; $i < sizeof($mgiai); $i++) {
            if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiai)) {
                array_push($mtung_ngay, $mngay[$i], $mgiai[$i]);
                array_push($mtung_ngay_group, $mtung_ngay);
                $mtung_ngay = [];
            }
        }

        foreach ($mtung_ngay_group as $key => $tung_ngay) {
            $ket_qua = ket_qua_xo_so_dien_toan_123::updateOrCreate(
                ['ngay_xo_dien_toan_123' => $tung_ngay[0], 'id_tinh' => $id_tinh],
                ['giai_dien_toan_123' => $tung_ngay[1]]
            );
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
