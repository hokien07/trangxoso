<?php

namespace App\Classes;

use DB;
use Curl\Curl;
use DiDom\Document;
use DiDom\Query;
use DiDom\Element;


class Crawller
{

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


}