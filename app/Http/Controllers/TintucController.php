<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\tintuc;
use App\Http\Controllers\KetquatinhController as getdata;
use App\Http\Controllers\GetdataController as ketquatinh;
use Curl\Curl;
use DiDom\Document;
use DiDom\Query;
use DiDom\Element;
use App\Classes\Crawller;

class TintucController extends Controller
{

    public function xoa_tin($id) {
        echo $id; exit();
    } 

    public function sua_tin($id) {
        $tin = DB::table('tin_tuc')->select('*')->where('id_tin','=', $id)->first();
        
        return view('sua-tin', compact('tin'));
    }

    public function get_tin_tuc() {
        $get_tin = new getdata();

        $url = 'http://xoso.me/tin-tuc';

        if($get_tin->get_data($url, $data)) {
            
            $document = new Document();

            $content = $document->load($data);

            

            //Title news from xoso.me
            
            $title_news = $content->find('ul li.clearfix h3 a strong');
            $link_thumbs = $content->find('ul li.clearfix a img');
            $link_news = $content->find('ul li.clearfix h3 a');
            $rut_gon_news = $content->find('ul li.clearfix p');
            
            // echo count(title_news) . '----' . count(link_thumbs) . '----' . count(link_news);

            $mtitle = [];
            $mthumb = [];
            $mlink = [];
            $mrutgon = [];

            foreach($title_news as $title)
                array_push($mtitle, $title->text());

            foreach($link_thumbs as $thumb)
                array_push($mthumb, $thumb->src);
            
            foreach($link_news as $link)
                array_push($mlink, $link->href);
            
            foreach($rut_gon_news as $rut_gon)
                array_push($mrutgon, $rut_gon->text());





            for($i = 0; $i < sizeof($mtitle); $i++) {
                //get content news 
            foreach($link_news as $link) 
            {
            
                if($get_tin->get_data($mlink[$i], $content)) {
                    $content_new = new Document();

                    $new = $content_new->load($content);

                    $div_new = $new->find('div.cont-detail');

                    foreach($div_new as $content) {
                        $ket_qua= tintuc::updateOrCreate(
                            ['tin_tieu_de' => $mtitle[$i], 'link_bai_viet'=>$mlink[$i]],
                            ['tin_rut_gon' => $mrutgon[$i], 'tin_noi_dung' => $content, 'tin_hinh_anh' => $mthumb[$i], 'link_hinh_anh' => $mthumb[$i]]
                        );
                    }
                }

               
            }
                
            }

        }

    }


    public function xem_tin($id) {
        
        $get_data = new ketquatinh();
        $crawler = new Crawller();
        $ten_tinhs = $get_data->get_ten_tinh();
        $ngay = $crawler->lay_ngay_thang();
        $tin_moi = $get_data->get_news();


        $tin_content = DB::table('tin_tuc')
            ->where('id_tin', '=', $id)
            ->select('tin_noi_dung')
            ->first();            
        
        return view('single-tin-tuc', compact('tin_content', 'ten_tinhs', 'ngay', 'tin_moi' ));
    }


    public function get_all_tin_tuc () {

        $get_data = new ketquatinh();
        $crawler = new Crawller();
        $ten_tinhs = $get_data->get_ten_tinh();
        $ngay = $crawler->lay_ngay_thang();
        $tin_moi = $get_data->get_news();

        $tins = DB::table('tin_tuc')
        ->select('*')
        ->orderBy('id_tin', 'ASC')
        ->paginate(10);  
        
        return view('tin-tuc', compact('tins', 'ten_tinhs', 'ngay', 'tin_moi' ));
    }
}
