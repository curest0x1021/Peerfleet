<?php

namespace App\Libraries;

use App\Controllers\App_Controller;
use GuzzleHttp\Client;
use phpQuery;

class Guzzle {

    private $page = 0;
    private $ci;

    public function __construct() {
        $this->ci = new App_Controller();
        $this->page_url = "https://www.shipserv.com";
        //load Guzzle resources
        require_once(APPPATH . "ThirdParty/Guzzle/vendor/autoload.php");
        require_once(APPPATH . "ThirdParty/phpquery/vendor/autoload.php");
    }

    public function run_guzzle() {
        try {
            $client = new Client(['base_uri' => $this->page_url]);
            $res = $client->request('GET', '/search');
            $this->page = $this->page + 1;
            $htmlContent = (string)$res->getBody();
            $dom = phpQuery::newDocument($htmlContent);
            $cardContents = pq('div.css-o9wnv9');
            // $cardContents = $rightContent->find('div.css-o9wnv9');
            foreach ($cardContents as $cardContent) {
                // echo pq($cardContent)->html() . PHP_EOL;
                $links = pq($cardContent)->find('a');
                echo pq($links)->attr('href') . PHP_EOL;
                
                $companyname = pq($cardContent)->find('h6.css-6hmwef');
                echo pq($companyname)->find('span')->html() . PHP_EOL;
                
                $description = pq($cardContent)->find('p.css-8v85rc');
                echo pq($description)->find('span')->html() . PHP_EOL;
                echo "============" . PHP_EOL;
                $country = pq($cardContent)->find('span.css-1j56a9j');
                echo pq($country)->html() . PHP_EOL;
                echo "============" . PHP_EOL;
                $ports = pq($cardContent)->find('span.css-6itan7');
                echo pq($ports)->html() . PHP_EOL;
                echo "============" . PHP_EOL;
            }
        } catch (\Exception $ex) {
            echo $ex;
        }
        
    }

}
