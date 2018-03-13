<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ten_tinh;
use App\Model\ket_qua_mien_nam;

class KetquatinhController extends Controller
{
    public function Lay_ket_qua()
    {
//        $mo_thuong = $this->tinh_mo_thuong();

        $dalat = $this->da_lat();
        $camau = $this->ca_mau();
        $dongthap = $this->dong_thap();
        $kiengiang = $this->kien_giang();
        $tiengiang = $this->tien_giang();
        $baclieu = $this->bac_lieu();
        $bentre = $this->ben_tre();
        $vungtau = $this->vung_tau();
        $cantho = $this->can_tho();
        $dongnai = $this->dong_nai();
        $soctrang = $this->soc_trang();
        $angiang = $this->an_giang();
        $binhthuan = $this->binh_thuan();
        $tayninh = $this->tay_ninh();
        $binhduong = $this->binh_duong();
        $travinh = $this->tra_vinh();
        $vinhlong =$this->vinh_long();
        $binhphuoc = $this->binh_phuoc();
        $haugiang = $this->hau_giang();
        $longan = $this->long_an();
        $hcm = $this->ho_chi_minh();
        $kontum = $this->kon_tum();
        $khanhhoa = $this->khanh_hoa();
        $phuyen = $this->phu_yen();
        $hue = $this->hue();
        $daklak = $this->daklak();
        $quangnam = $this->quang_nam();
        $binhdinh = $this->binh_dinh();
        $quangbinh = $this->quang_binh();
        $quangtri = $this->quang_tri();
        $gialai = $this->gia_lai();
        $ninhthuan = $this->ninh_thuan();
        $daknong = $this->dak_nong();
        $danang = $this->da_nang();
        $quangngai = $this->quang_ngai();
        $mienbac = $this->mien_bac();
        $dien_toan_123 = $this->dien_toan_123();
        $dien_toan_636 = $this->dien_toan_636();
        $dien_toan_than_tai = $this->dien_toan_than_tai();
    }

//    public function tinh_mo_thuong(){
//        $url = 'http://xoso.me/';
//
//        if($this->get_data($url, $data)) {
//            preg_match_all('/<div class="box mo-thuong-ngay"><h2 class="title-bor"><strong>Các tỉnh mở thưởng hôm nay<\/strong><\/h2><table class="colgiai" cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr><td>(.+?)<\/td><td>(.+?)<\/td><td>(.+?)<\/td><\/tr><tr><td>(.+?)<\/td><td>(.+>)<\/td><td>(.+?)<\/td><\/tr><tr><td>(.+?)<\/td><td><\/td><td>(.+?)<\/td><\/tr><tr><td><\/td><td><\/td><td>(.+?)<\/td><\/tr><\/tbody><\/table><\/div>/', $data, $match);
//            var_dump($match);
//        }
//    }

    public function dien_toan_than_tai () {
        $url = 'http://xoso.me/xo-so-dien-toan-than-tai-hom-nay.html';

        /*Tinh vung luu y:
       * Tinh vung = 0: mien bac
        * Tinh vung = 1 : xo so dien toan
        * Tinh vung = 2 : Mien trung
        * Tinh vung = 3 : Mien nam*/

        $tinh_vung = 1;
        $id_tinh =  39;
        $ma_tinh = 'thantai';

        preg_match('/xoso.me\/(.+?)-hom-nay.html/', $url, $match);
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
            preg_match_all('/<strong>Kết quả xổ số điện toán thần tài ngày (.+?)<\/strong>/', $data, $ngay);
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }
        }


        $mgiai = [];
        if ($this->get_data($url, $data)) {
            preg_match_all('/<div><span>(\d+)<\/span><\/div>/', $data, $match);

            if($match && $match[1]) {
                foreach ($match[1] as $giai) {
                    array_push($mgiai, $giai);
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
            $ket_qua= ket_qua_mien_nam::updateOrCreate(
                ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                ['dac_biet' => $tung_ngay[1], 'giai_nhat' => '', 'giai_nhi' => '', 'giai_ba' => '', 'giai_bon' => '', 'giai_nam' => '', 'giai_sau' => '', 'giai_bay' => '', 'giai_tam' => '', 'tinh_vung' => $tinh_vung]
            );
        }
    }

    public function dien_toan_636() {
        $url = 'http://xoso.me/kq-xsdt-6-36-ket-qua-xo-so-dien-toan-6-36-truc-tiep-hom-nay.html';

        /*Tinh vung luu y:
       * Tinh vung = 0: mien bac
        * Tinh vung = 1 : xo so dien toan
        * Tinh vung = 2 : Mien trung
        * Tinh vung = 3 : Mien nam*/

        $tinh_vung = 1;
        $id_tinh =  38;
        $ma_tinh = '6x36';

        preg_match('/kq-xsdt-6-36-ket-qua-(.+?)-truc-tiep-hom-nay.html/', $url, $match);
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
            preg_match_all('/<strong>Kết quả xổ số điện toán 6x36 ngày (.+?)<\/strong>/', $data, $ngay);
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }
        }


        $mgiai = [];
        if ($this->get_data($url, $data)) {
            preg_match_all('/iv><span>(\d+)<\/span><span>(\d+)<\/span><span>(\d+)<\/span>/', $data, $match);

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
            $ket_qua= ket_qua_mien_nam::updateOrCreate(
                ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                ['dac_biet' => $tung_ngay[1], 'giai_nhat' => '', 'giai_nhi' => '', 'giai_ba' => '', 'giai_bon' => '', 'giai_nam' => '', 'giai_sau' => '', 'giai_bay' => '', 'giai_tam' => '', 'tinh_vung' => $tinh_vung]
            );
        }

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

            $ket_qua= ket_qua_mien_nam::updateOrCreate(
                ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                ['dac_biet' => $tung_ngay[1], 'giai_nhat' => '', 'giai_nhi' => '', 'giai_ba' => '', 'giai_bon' => '', 'giai_nam' => '', 'giai_sau' => '', 'giai_bay' => '', 'giai_tam' => '', 'tinh_vung' => $tinh_vung]
            );

        }
    }

    public function mien_bac() {
        $url = 'http://xoso.me/kqxsmb-xstd-ket-qua-xo-so-mien-bac.html';
        $tinh_vung = 0;
        $id_tinh = 1;
        $ten_khong_dau = 'xo-so-mien-bac';
        $ten_co_dau = 'Xổ số miền bắc';
        $ma_tinh = 'MB';


        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );


        if ($this->get_data($url, $data)) {

            preg_match_all('#title="Xổ số miền Bắc ngày (.+?)">Xổ số miền Bắc ngày#', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('#<td class="txt-giai">Đặc biệt</td><td colspan="12" class="number"><b>(.+?)</b></td>#', $data, $db);
            $mdb = [];
            foreach ($db[1] as $value) {
                array_push($mdb, $value);
            }

            $mgiainhat = [];
            preg_match_all('#<td class="txt-giai">Giải nhất</td><td colspan="12" class="number"><b>(.+?)</b></td>#', $data, $gn);
            foreach ($gn[1] as $value) {
                array_push($mgiainhat, $value);
            }

            $mgiainhi = [];
            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b class="">(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi_tt);

            if ($giai_nhi_tt && $giai_nhi_tt[1] && $giai_nhi_tt[2]) {
                for ($loop = 0; $loop < sizeof($giai_nhi_tt[1]); $loop++) {
                    if (array_key_exists($loop, $giai_nhi_tt[1]) && array_key_exists($loop, $giai_nhi_tt[2])) {
                        $tung_giai = $giai_nhi_tt[1][$loop] . ',' . $giai_nhi_tt[2][$loop];
                        array_push($mgiainhi, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="giai3 bg_ef"><td class="txt-giai" rowspan="2">Giải ba<\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><td class="number" colspan="4"><b class="">(\d+)<\/b><\/td><td class="number" colspan="4"><b class="">(\d+)<\/b><\/td><\/tr><tr class="bg_ef"><td class="number" colspan="4"><b>(\d+)<\/b><\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];
            if ($giai_ba && $giai_ba[1] && $giai_ba[2] && $giai_ba[3] && $giai_ba[4] && $giai_ba[5] && $giai_ba[6]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2]) && array_key_exists($loop, $giai_ba[3]) && array_key_exists($loop, $giai_ba[4]) && array_key_exists($loop, $giai_ba[5]) && array_key_exists($loop, $giai_ba[6])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop] . ',' . $giai_ba[3][$loop] . ',' . $giai_ba[4][$loop] . ',' . $giai_ba[5][$loop] . ',' . $giai_ba[6][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }


            $mgiaitu = [];
            preg_match_all('/<tr><td class="txt-giai">Giải tư<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tu);

            if ($giai_tu && $giai_tu[1] && $giai_tu[2] && $giai_tu[3] && $giai_tu[4]) {
                for ($loop = 0; $loop < sizeof($giai_tu[1]); $loop++) {
                    if (array_key_exists($loop, $giai_tu[1]) && array_key_exists($loop, $giai_tu[2]) && array_key_exists($loop, $giai_tu[3]) && array_key_exists($loop, $giai_tu[4])) {
                        $tung_giai = $giai_tu[1][$loop] . ',' . $giai_tu[2][$loop] . ',' . $giai_tu[3][$loop] . ',' . $giai_tu[4][$loop];
                        array_push($mgiaitu, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="giai5 bg_ef"><td class="txt-giai" rowspan="2">Giải năm<\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><\/tr><tr class="bg_ef"><td class="number" colspan="4"><b>(\d+)<\/b><\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><td class="number" colspan="4"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if ($giai_nam && $giai_nam[1] && $giai_nam[2] && $giai_nam[3] && $giai_nam[4] && $giai_nam[5] && $giai_nam[6]) {
                for ($loop = 0; $loop < sizeof($giai_nam[1]); $loop++) {
                    if (array_key_exists($loop, $giai_nam[1]) && array_key_exists($loop, $giai_nam[2]) && array_key_exists($loop, $giai_nam[3]) && array_key_exists($loop, $giai_nam[4]) && array_key_exists($loop, $giai_nam[5]) && array_key_exists($loop, $giai_nam[6])) {
                        $tung_giai = $giai_nam[1][$loop] . ',' . $giai_nam[2][$loop] . ',' . $giai_nam[3][$loop] . ',' . $giai_nam[4][$loop] . ',' . $giai_nam[5][$loop] . ',' . $giai_nam[6][$loop];
                        array_push($mgiainam, $tung_giai);
                    }
                }
            }

            $mgiaisau = [];
            preg_match_all('/<tr><td class="txt-giai">Giải tư<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            $mgiaibay = [];
            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);

            if ($giai_bay && $giai_bay[1] && $giai_bay[2] && $giai_bay[3] && $giai_bay[4]) {
                for ($loop = 0; $loop < sizeof($giai_bay[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bay[1]) && array_key_exists($loop, $giai_bay[2]) && array_key_exists($loop, $giai_bay[3]) && array_key_exists($loop, $giai_bay[4])) {
                        $tung_giai = $giai_bay[1][$loop] . ',' . $giai_bay[2][$loop] . ',' . $giai_bay[3][$loop] . ',' . $giai_bay[4][$loop];
                        array_push($mgiaibay, $tung_giai);
                    }
                }
            }

            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mdb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaitu) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay)) {
                    array_push($mtung_ngay, $mngay[$i], $mdb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaitu[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => '', 'tinh_vung' => $tinh_vung]
                );
            }

        } else {
            echo "khong the ket noi toi url: " . $url;
        }
    }

    public function da_nang() {
        $url = 'http://xoso.me/mien-trung/xsdng-ket-qua-xo-so-da-nang-p24.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsdng-ket-qua-xo-so-da-nang-ngay-(.+?)-p24.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function quang_ngai() {
        $url = 'http://xoso.me/mien-trung/xsqng-ket-qua-xo-so-quang-ngai-p33.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsqng-ket-qua-xo-so-quang-ngai-ngay-(.+?)-p33.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function dak_nong() {
        $url = 'http://xoso.me/mien-trung/xsdno-ket-qua-xo-so-dac-nong-p26.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsdno-ket-qua-xo-so-dac-nong-ngay-(.+?)-p26.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function ninh_thuan() {
        $url = 'http://xoso.me/mien-trung/xsnt-ket-qua-xo-so-ninh-thuan-p30.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsnt-ket-qua-xo-so-ninh-thuan-ngay-(.+?)-p30.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function gia_lai() {
        $url = 'http://xoso.me/mien-trung/xsgl-ket-qua-xo-so-gia-lai-p27.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsgl-ket-qua-xo-so-gia-lai-ngay-(.+?)-p27.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function quang_tri() {
        $url = 'http://xoso.me/mien-trung/xsqt-ket-qua-xo-so-quang-tri-p35.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsqt-ket-qua-xo-so-quang-tri-ngay-(.+?)-p35.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function quang_binh() {
        $url = 'http://xoso.me/mien-trung/xsqb-ket-qua-xo-so-quang-binh-p32.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsqb-ket-qua-xo-so-quang-binh-ngay-(.+?)-p32.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function binh_dinh() {
        $url = 'http://xoso.me/mien-trung/xsbdi-ket-qua-xo-so-binh-dinh-p23.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsbdi-ket-qua-xo-so-binh-dinh-ngay-(.+?)-p23.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function quang_nam() {
        $url = 'http://xoso.me/mien-trung/xsqnm-ket-qua-xo-so-quang-nam-p34.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsqnm-ket-qua-xo-so-quang-nam-ngay-(.+?)-p34.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function daklak() {
        $url = 'http://xoso.me/mien-trung/xsdlk-ket-qua-xo-so-dac-lac-p25.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsdlk-ket-qua-xo-so-dac-lac-ngay-(.+?)-p25.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function hue() {
        $url = 'http://xoso.me/mien-trung/xstth-ket-qua-xo-so-thua-thien-hue-p36.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xstth-ket-qua-xo-so-thua-thien-hue-ngay-(.+?)-p36.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function phu_yen() {
        $url = 'http://xoso.me/mien-trung/xspy-ket-qua-xo-so-phu-yen-p31.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xspy-ket-qua-xo-so-phu-yen-ngay-(.+?)-p31.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function khanh_hoa() {
        $url = 'http://xoso.me/mien-trung/xskh-ket-qua-xo-so-khanh-hoa-p28.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xskh-ket-qua-xo-so-khanh-hoa-ngay-(.+?)-p28.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function kon_tum() {
        $url = 'http://xoso.me/mien-trung/xskt-ket-qua-xo-so-kon-tum-p29.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xskt-ket-qua-xo-so-kon-tum-ngay-(.+?)-p29.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function ho_chi_minh() {
        $url = 'http://xoso.me/mien-nam/xshcm-ket-qua-xo-so-thanh-pho-ho-chi-minh-p14.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xshcm-ket-qua-xo-so-thanh-pho-ho-chi-minh-ngay-(.+?)-p14.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function long_an() {
        $url = 'http://xoso.me/mien-nam/xsla-ket-qua-xo-so-long-an-p16.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsla-ket-qua-xo-so-long-an-ngay-(.+?)-p16.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function hau_giang() {
        $url = 'http://xoso.me/mien-nam/xshg-ket-qua-xo-so-hau-giang-p13.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xshg-ket-qua-xo-so-hau-giang-ngay-(.+?)-p13.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function binh_phuoc() {
        $url = 'http://xoso.me/mien-nam/xsbp-ket-qua-xo-so-binh-phuoc-p6.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsbp-ket-qua-xo-so-binh-phuoc-ngay-(.+?)-p6.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function vinh_long() {
        $url = 'http://xoso.me/mien-nam/xsvl-ket-qua-xo-so-vinh-long-p21.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsvl-ket-qua-xo-so-vinh-long-ngay-(.+?)-p21.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function tra_vinh() {
        $url = 'http://xoso.me/mien-nam/xstv-ket-qua-xo-so-tra-vinh-p20.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xstv-ket-qua-xo-so-tra-vinh-ngay-(.+?)-p20.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function binh_duong() {
        $url = 'http://xoso.me/mien-nam/xsbd-ket-qua-xo-so-binh-duong-p5.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsbd-ket-qua-xo-so-binh-duong-ngay-(.+?)-p5.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function tay_ninh() {
        $url = 'http://xoso.me/mien-nam/xstn-ket-qua-xo-so-tay-ninh-p18.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xstn-ket-qua-xo-so-tay-ninh-ngay-(.+?)-p18.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function binh_thuan() {
        $url = 'http://xoso.me/mien-nam/xsbth-ket-qua-xo-so-binh-thuan-p7.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsbth-ket-qua-xo-so-binh-thuan-ngay-(.+?)-p7.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function an_giang() {
        $url = 'http://xoso.me/mien-nam/xsag-ket-qua-xo-so-an-giang-p2.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsag-ket-qua-xo-so-an-giang-ngay-(.+?)-p2.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function soc_trang() {
        $url = 'http://xoso.me/mien-nam/xsst-ket-qua-xo-so-soc-trang-p17.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsst-ket-qua-xo-so-soc-trang-ngay-(.+?)-p17.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function dong_nai() {
        $url = 'http://xoso.me/mien-nam/xsdn-ket-qua-xo-so-dong-nai-p11.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsdn-ket-qua-xo-so-dong-nai-ngay-(.+?)-p11.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function can_tho() {
        $url = 'http://xoso.me/mien-nam/xsct-ket-qua-xo-so-can-tho-p9.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/sct-ket-qua-xo-so-can-tho-ngay-(.+?)-p9.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function vung_tau() {
        $url = 'http://xoso.me/mien-nam/xsvt-ket-qua-xo-so-vung-tau-p22.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsvt-ket-qua-xo-so-vung-tau-ngay-(.+?)-p22.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function ben_tre() {
        $url = 'http://xoso.me/mien-nam/xsbt-ket-qua-xo-so-ben-tre-p4.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsbt-ket-qua-xo-so-ben-tre-ngay-(.+?)-p4.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua= ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function bac_lieu() {
        $url = 'http://xoso.me/mien-nam/xsbl-ket-qua-xo-so-bac-lieu-p3.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsbl-ket-qua-xo-so-bac-lieu-ngay-(.+?)-p3.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua_bac_lieu = ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function tien_giang() {
        $url = 'http://xoso.me/mien-nam/xstg-ket-qua-xo-so-tien-giang-p19.html';
        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xstg-ket-qua-xo-so-tien-giang-ngay-(.+?)-p19.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua_tien_giang = ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function kien_giang() {
        $url = 'http://xoso.me/mien-nam/xskg-ket-qua-xo-so-kien-giang-p15.html';

        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xskg-ket-qua-xo-so-kien-giang-ngay-(.+?)-p15.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua_kien_giang = ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }
        }
    }

    public function dong_thap() {
        $url = 'http://xoso.me/mien-nam/xsdt-ket-qua-xo-so-dong-thap-p12.html';

        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xsdt-ket-qua-xo-so-dong-thap-ngay-(.+?)-p12.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua_dong_thap = ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }

        }
    }

    public function ca_mau() {
        $url = 'http://xoso.me/mien-nam/xscm-ket-qua-xo-so-ca-mau-p8.html';

        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/xscm-ket-qua-xo-so-ca-mau-ngay-(.+?)-p8.html/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }

            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua_ca_mau = ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }

        }


    }

    public function da_lat() {
        $url = 'http://xoso.me/mien-nam/xsdl-ket-qua-xo-so-da-lat-p10.html';

        $tinh_vung = $this->get_tinh_vung($url);
        $id_tinh = $this->get_id_tinh($url);
        $ten_khong_dau = $this->get_ten_tinh_khong_dau($url);
        $ten_co_dau = $this->get_ten_tinh_co_dau($url);
        $ma_tinh = $this->get_ma_tinh($url);

        $ten_tinh = ten_tinh::updateOrCreate(
            ['id_tinh'=> $id_tinh],
            ['ten_tinh' => $ten_co_dau, 'mo_thuong' => 0, 'tinh_vung' => $tinh_vung, 'ten_tinh_khong_dau' => $ten_khong_dau, 'ma_tinh'=>$ma_tinh]
        );

        if ($this->get_data($url, $data)) {
            preg_match_all('/http:\/\/xoso.me\/DL\/xsdl-ket-qua-xo-so-da-lat-ngay-(.+?)-p10.html"/', $data, $ngay);
            $mngay = [];
            foreach ($ngay[1] as $value) {
                $value = date("Y-m-d", strtotime($value));
                array_push($mngay, $value);
            }

            preg_match_all('/<td class="txt-giai">Giải tám<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_tam);
            $mgiaitam = [];
            foreach ($giai_tam[1] as $value) {
                array_push($mgiaitam, $value);
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải bảy<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bay);
            $mgiaibay = [];
            if($giai_bay && $giai_bay[1]) {
                foreach ($giai_bay[1] as $value) {
                    array_push($mgiaibay, $value);
                }
            }


            preg_match_all('/<tr><td class="txt-giai">Giải sáu<\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_sau);
            $mgiaisau = [];

            if ($giai_sau && $giai_sau[1] && $giai_sau[2] && $giai_sau[3]) {
                for ($loop = 0; $loop < sizeof($giai_sau[1]); $loop++) {
                    if (array_key_exists($loop, $giai_sau[1]) && array_key_exists($loop, $giai_sau[2]) && array_key_exists($loop, $giai_sau[3])) {
                        $tung_giai = $giai_sau[1][$loop] . ',' . $giai_sau[2][$loop] . ',' . $giai_sau[3][$loop];
                        array_push($mgiaisau, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải năm<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nam);
            $mgiainam = [];
            if($giai_nam && $giai_nam[1]) {
                foreach ($giai_nam[1] as $value) {
                    array_push($mgiainam, $value);
                }
            }

            preg_match_all('/<tr class="giai4"><td rowspan="2" class="txt-giai">Giải bốn<\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><td colspan="3" class="number"><b>(\d+)<\/b><\/td><\/tr><tr><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><td colspan="4" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_bon);
            $mgiaibon = [];

            if ($giai_bon && $giai_bon[1] && $giai_bon[2] && $giai_bon[3] && $giai_bon[4] && $giai_bon[5] && $giai_bon[6] && $giai_bon[7])  {
                for ($loop = 0; $loop < sizeof($giai_bon[1]); $loop++) {
                    if (array_key_exists($loop, $giai_bon[1]) && array_key_exists($loop, $giai_bon[2]) && array_key_exists($loop, $giai_bon[3]) && array_key_exists($loop, $giai_bon[4]) && array_key_exists($loop, $giai_bon[5]) && array_key_exists($loop, $giai_bon[6]) && array_key_exists($loop, $giai_bon[7])) {
                        $tung_giai = $giai_bon[1][$loop] . ',' . $giai_bon[2][$loop] . ',' . $giai_bon[3][$loop] . ',' . $giai_bon[4][$loop] . ',' . $giai_bon[5][$loop] . ',' . $giai_bon[6][$loop] . ',' . $giai_bon[7][$loop];
                        array_push($mgiaibon, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải ba<\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><td colspan="6" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_ba);
            $mgiaiba = [];

            if ($giai_ba && $giai_ba[1] && $giai_ba[2]) {
                for ($loop = 0; $loop < sizeof($giai_ba[1]); $loop++) {
                    if (array_key_exists($loop, $giai_ba[1]) && array_key_exists($loop, $giai_ba[2])) {
                        $tung_giai = $giai_ba[1][$loop] . ',' . $giai_ba[2][$loop];
                        array_push($mgiaiba, $tung_giai);
                    }
                }
            }

            preg_match_all('/<tr><td class="txt-giai">Giải nhì<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhi);
            $mgiainhi = [];
            if($giai_nhi && $giai_nhi[1]) {
                foreach ($giai_nhi[1] as $value) {
                    array_push($mgiainhi, $value);
                }
            }

            preg_match_all('/<tr class="bg_ef"><td class="txt-giai">Giải nhất<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_nhat);
            $mgiainhat = [];
            if($giai_nhat && $giai_nhat[1]) {
                foreach ($giai_nhat[1] as $value) {
                    array_push($mgiainhat, $value);
                }
            }

            preg_match_all('/<tr class="db"><td class="txt-giai">Đặc biệt<\/td><td colspan="12" class="number"><b>(\d+)<\/b><\/td><\/tr>/', $data, $giai_db);
            $mgiaidb = [];
            if($giai_db && $giai_db[1]) {
                foreach ($giai_db[1] as $value) {
                    array_push($mgiaidb, $value);
                }
            }


            /*tong het tung ngay theo thu tu*/

            $mtung_ngay = [];
            $mtung_ngay_group = [];
            for ($i = 0; $i < sizeof($giai_ba); $i++) {
                if (array_key_exists($i, $mngay) && array_key_exists($i, $mgiaidb) && array_key_exists($i, $mgiainhat) && array_key_exists($i, $mgiainhi) && array_key_exists($i, $mgiaibon) && array_key_exists($i, $mgiainam) && array_key_exists($i, $mgiaisau) && array_key_exists($i, $mgiaibay) && array_key_exists($i, $mgiaitam)) {
                    array_push($mtung_ngay, $mngay[$i], $mgiaidb[$i], $mgiainhat[$i], $mgiainhi[$i], $mgiaiba[$i], $mgiaibon[$i], $mgiainam[$i], $mgiaisau[$i], $mgiaibay[$i], $mgiaitam[$i]);
                    array_push($mtung_ngay_group, $mtung_ngay);
                    $mtung_ngay = [];
                }
            }


            foreach ($mtung_ngay_group as $key => $tung_ngay) {
                $ket_qua_da_lat = ket_qua_mien_nam::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0], 'id_tinh'=>$id_tinh],
                    ['dac_biet' => $tung_ngay[1], 'giai_nhat' => $tung_ngay[2], 'giai_nhi' => $tung_ngay[3], 'giai_ba' => $tung_ngay[4], 'giai_bon' => $tung_ngay[5], 'giai_nam' => $tung_ngay[6], 'giai_sau' => $tung_ngay[7], 'giai_bay' => $tung_ngay[8], 'giai_tam' => $tung_ngay[9], 'tinh_vung' => $tinh_vung]
                );
            }

        }
    }


    public function get_tinh_vung ($url) {
        preg_match('/\/xoso.me\/(.+?)\//', $url, $match);

        /*Tinh vung luu y:
        * Tinh vung = 0: mien bac
         * Tinh vung = 1 : xo so dien toan
         * Tinh vung = 2 : Mien trung
         * Tinh vung = 3 : Mien nam*/

        $tinh_vung = -1;

        if($match && $match[1]) {
            if($match[1] == 'mien-nam') {
                $tinh_vung = 3;
            }elseif ($match[1] == 'mien-trung') {
                $tinh_vung = 2;
            }
        }
        return $tinh_vung;
    }

    public function get_ma_tinh($url) {
        if ($this->get_data($url, $data)) {

            preg_match('/<strong class="clsms">XS (.+?)<\/strong>/', $data, $match);

            return $match[1];
        }
    }

    public function get_ten_tinh_co_dau($url) {
        if ($this->get_data($url, $data)) {

            preg_match('/<p><span>Kết quả <strong>(.+?)<\/strong>/', $data, $match);

            return $match[1];
        }
    }


    public function get_ten_tinh_khong_dau($url){
        preg_match('/ket-qua-(.+?)-p/', $url, $match);
        return $match[1];
    }

    public function get_id_tinh($url) {
       preg_match('/-p(\d+).html/', $url, $match);
       return $match[1];
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
