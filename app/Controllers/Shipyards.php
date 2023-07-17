<?php

namespace App\Controllers;

class Shipyards extends Security_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->country();
    }

    function country($country_id = "") {
        $view_data["active_tab"] = "country";
        if (empty($country_id)) {
            $view_data["show_checkboxs"] = false;
            $view_data["countries"] = $this->Shipyards_model->get_countries();
            return $this->template->rander("shipyards/country", $view_data);
        } else {
            $view_data["show_checkboxs"] = true;
            $view_data["companies"] = $this->Shipyards_model->get_details(array("country_id" => $country_id))->getResult();
            return $this->template->rander("shipyards/view", $view_data);
        }
    }

    function region($region = "") {
        $view_data["active_tab"] = "region";
        if (empty($region)) {
            $view_data["show_checkboxs"] = false;
            $view_data["regions"] = $this->Shipyards_model->get_regions();
            return $this->template->rander("shipyards/region", $view_data);
        } else {
            $view_data["show_checkboxs"] = true;
            $view_data["companies"] = $this->Shipyards_model->get_details(array("region" => $region))->getResult();
            return $this->template->rander("shipyards/view", $view_data);
        }
    }

    function sailingarea($sailingarea = "") {
        $view_data["active_tab"] = "sailingarea";
        if (empty($sailingarea)) {
            $view_data["show_checkboxs"] = false;
            return $this->template->rander("shipyards/sailingarea", $view_data);
        } else {
            $view_data["show_checkboxs"] = true;
            $view_data["companies"] = $this->Shipyards_model->get_details(array("sailingarea" => $sailingarea))->getResult();
            return $this->template->rander("shipyards/view", $view_data);
        }
    }

    function temp() {
        $temp_path = get_setting("temp_file_path");
        $json = file_get_contents($temp_path . "sailing_area.json");
        $json_data = json_decode($json);

        $ids = [];
        foreach ($json_data as $items) {
            foreach ($items as $k) {
                if ($k->onlyNewBuild) {
                    $ids[] = $k->id;
                }
            }
            // print_r(count($k));
            // if ($k->onlyNewBuild) {
            //     $ids[] = $k->id;
            // }
        }
        print_r(json_encode($ids));
    }

}