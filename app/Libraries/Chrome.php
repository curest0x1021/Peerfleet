<?php

namespace App\Libraries;

use App\Controllers\App_Controller;
use HeadlessChromium\BrowserFactory;
use phpQuery;
use HeadlessChromium\Page;
use Psr\Log\LoggerInterface;

class Chrome {

    private $ci;

    public function __construct() {
        $this->ci = new App_Controller();
        $this->page_url = "https://www.shipserv.com";
        //load Guzzle resources
        require_once(APPPATH . "ThirdParty/chrome-php/vendor/autoload.php");
        require_once(APPPATH . "ThirdParty/phpquery/vendor/autoload.php");
    }

    public function run_scrape() {
        try {
            $browserFactory = new BrowserFactory();
            $browser = $browserFactory->createBrowser();

            $service_page = $this->ci->Settings_model->get_setting("service_page");
            if ($service_page === NULL) {
                $service_page = 0;
            }

            // creates a new page and navigate to an URL
            $page = $browser->createPage();
            $navigation = $page->navigate('https://www.shipserv.com/search?page=' . $service_page);
            // $navigation = $page->navigate('https://stackoverflow.com/questions/47220255/how-to-set-timeout-for-headless-chrome');
            $navigation->waitForNavigation();
            // $navigation->waitForNavigation(Page::DOM_CONTENT_LOADED, 10000);
            // $page->screenshot()->saveToFile('/foo/bar.png');
            $htmlContent = $page->getHtml(10000);

            $dom = phpQuery::newDocument($htmlContent);
            $cardContents = pq('div.css-o9wnv9');
            
            $find_href = false;
            foreach ($cardContents as $cardContent) {
                echo pq($cardContent)->html() . PHP_EOL;
                $links = pq($cardContent)->find('a');
                $link_href = pq($links)->attr('href');
                
                $services = $this->ci->Services_model->get_all_where(array("href" => $link_href, "deleted" => 0))->getResult();

                if (count($services) == 0) {
                    $companyname = pq($cardContent)->find('h6.css-6hmwef');
                    $planCompanyname = pq($companyname)->find('div')->html();

                    if ($planCompanyname != NULL && $planCompanyname != '') {
                        $description = pq($cardContent)->find('div.css-nn7xcu');
                        
                        $country = pq($cardContent)->find('div.css-1mfn0nf');
        
                        $country_name = pq($country)->find('span')->html();
                        // echo $country_name . $description->html() .  PHP_EOL;
                        $country_data = $this->ci->Country_model->get_one_by_name($country_name);
                        $data = array(
                            "href" => $link_href,
                            "company" => $planCompanyname,
                            "country_id" => $country_data ? $country_data->id : 'US',
                            "description" => pq($description)->find('div')->html(),
                        );
                        $save_id = $this->ci->Services_model->ci_save($data, null);

                        $navigation = $page->navigate($link_href . '/ports');
                        $navigation->waitForNavigation();

                        $htmlContent = $page->getHtml(10000);
                        $dom = phpQuery::newDocument($htmlContent);
                        $portContents = pq('a.css-pbaefo');

                        
                        foreach ($portContents as $portContent) {
                            $ports = pq($portContent)->find('p.css-153827o');

                            $myArray = explode(',', $ports->html());
                            $data1 = array(
                                "service_id" => $save_id,
                                "city" => $myArray[0],
                                "country_id" => $myArray[1] ? trim($myArray[1]) : ($country_data ? $country_data->id : 'US'),
                            );
                            $this->ci->Service_ports_model->ci_save($data1, null);

                        }
                    }
                    
                } else {
                    $find_href = true;
                }
                
            }

            if ($find_href) {
                $this->ci->Settings_model->save_setting("service_page", intval($service_page) + 1);
            }

        } catch (\Exception $ex) {
            echo $ex;
        } finally {
            // bye
            $browser->close();
        }
    }
}
