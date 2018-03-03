<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl\Curl;
use DiDom\Document;
use DiDom\Query;
use DiDom\Element;

class CrawlerController extends Controller
{
    public function get_data() {
        $dom = new Document('https://ketqua.vn/', true);

        $result_box = $dom->find('div[class="result-box"]')[0];

        echo count($result_box);




    }
}
