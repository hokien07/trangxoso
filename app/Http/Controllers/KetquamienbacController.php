<?php

namespace App\Http\Controllers;

use App\Classes\Crawller;
use Illuminate\Http\Request;
use App\Model\ket_qua_mien_bac;

class KetquamienbacController extends Controller
{
    public function Lay_ket_qua()
    {
        $url = 'http://xoso.me/kqxsmb-xstd-ket-qua-xo-so-mien-bac.html';
        $content = $this->lay_ket_qua_mien_bac($url);


    }

    public function lay_ket_qua_mien_bac($content)
    {
        if ($this->get_data($content, $data)) {

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
                $ket_qua_mien_bac = ket_qua_mien_bac::updateOrCreate(
                    ['ngay_mo_thuong' => $tung_ngay[0]],
                    ['mien_bac_dac_biet' => $tung_ngay[1], 'mien_bac_giai_nhat' => $tung_ngay[2], 'mien_bac_giai_nhi' => $tung_ngay[3], 'mien_bac_giai_ba' => $tung_ngay[4], 'mien_bac_giai_bon' => $tung_ngay[5], 'mien_bac_giai_nam' => $tung_ngay[6], 'mien_bac_giai_sau' => $tung_ngay[7], 'mien_bac_giai_bay' => $tung_ngay[8], 'tinh_vung' => 0]
                );
            }

            echo "Success!!!";


        } else {
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


    function mb_strrev($str, $encoding = "utf-8")
    {
        $ret = "";
        for ($i = mb_strlen($str, $encoding) - 1; $i >= 0; $i--) {
            $ret .= mb_substr($str, $i, 1, $encoding);
        }
        return $ret;
    }

}
