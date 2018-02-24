<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrawlerController extends Controller
{

    public function getUrl(){
        include_once (app_path() . '\crawler\simple_html_dom.php');
        $html = file_get_html('http://www.google.com/');
        echo $html;
    }
}
