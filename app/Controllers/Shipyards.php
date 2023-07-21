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
            $countries = $this->Shipyards_model->get_countries();
            $htmlContent = "";
            foreach ($countries as $k) {
                $htmlContent .= '<div class="d-flex align-items-center col-sm-3 mt10">';
                $htmlContent .= '<div title="' . $k->name . '" class="flag flag-icon-background fi-' . $k->id . '"></div>';
                $htmlContent .= '<a href="' . get_uri("shipyards/country/" . $k->id) . '" data-id="' . $k->id . '" class="shipyard-text">' . $k->name . '</a>';
                $htmlContent .= '</div>';
            }
            $view_data["htmlContent"] = $htmlContent;
            return $this->template->rander("shipyards/index", $view_data);
        } else {
            $view_data["show_checkboxs"] = true;
            $companies = $this->Shipyards_model->get_details(array("country_id" => $country_id))->getResult();
            $view_data["companies"] = $companies;
            $view_data["repair_list"] = $this->repair_list($companies);
            $view_data["new_build_list"] = $this->new_build_list($companies);
            $view_data["scrapping_list"] = $this->scrapping_list($companies);

            return $this->template->rander("shipyards/view", $view_data);
        }
    }

    function region($region = "") {
        $view_data["active_tab"] = "region";
        if (empty($region)) {
            $view_data["show_checkboxs"] = false;
            $regions = $this->Shipyards_model->get_regions();
            $htmlContent = "";
            foreach ($regions as $k) {
                $htmlContent .= '<div class="d-flex align-items-center col-sm-3 mt10">';
                $htmlContent .= '<a href="' . get_uri("shipyards/region/" . $k->id) . '" data-id="' . $k->id . '" class="shipyard-text">' . $k->name . '</a>';
                $htmlContent .= '</div>';
            }
            $view_data["htmlContent"] = $htmlContent;
            return $this->template->rander("shipyards/index", $view_data);
        } else {
            $view_data["show_checkboxs"] = true;
            $companies = $this->Shipyards_model->get_details(array("region" => $region))->getResult();
            $view_data["companies"] = $companies;
            $view_data["repair_list"] = $this->repair_list($companies);
            $view_data["new_build_list"] = $this->new_build_list($companies);
            $view_data["scrapping_list"] = $this->scrapping_list($companies);
            return $this->template->rander("shipyards/view", $view_data);
        }
    }

    function sailingarea($sailingarea = "") {
        $view_data["active_tab"] = "sailingarea";
        if (empty($sailingarea)) {
            $view_data["show_checkboxs"] = false;
            $sailing_areas = $this->Shipyards_model->get_sailing_areas();
            $htmlContent = "";
            foreach ($sailing_areas as $k) {
                $htmlContent .= '<div class="d-flex align-items-center col-sm-3 mt10">';
                $htmlContent .= '<a href="' . get_uri("shipyards/sailingarea/" . $k->id) . '" data-id="' . $k->id . '" class="shipyard-text">' . $k->name . '</a>';
                $htmlContent .= '</div>';
            }
            $view_data["htmlContent"] = $htmlContent;
            return $this->template->rander("shipyards/index", $view_data);
        } else {
            $view_data["show_checkboxs"] = true;
            $companies = $this->Shipyards_model->get_details(array("sailingarea" => $sailingarea))->getResult();
            $view_data["companies"] = $companies;
            $view_data["repair_list"] = $this->repair_list($companies);
            $view_data["new_build_list"] = $this->new_build_list($companies);
            $view_data["scrapping_list"] = $this->scrapping_list($companies);
            return $this->template->rander("shipyards/view", $view_data);
        }
    }

    function modal_form($id = 0) {
        $model_info = $this->Shipyards_model->get_details(array("id" => $id))->getRow();
        if (empty($model_info->id)) {
            show_404();
        } else {
            $view_data["model_info"] = $model_info;
            $view_data["label_column"] = "col-md-3";
            $view_data["field_column"] = "col-md-9";
            return $this->template->view("shipyards/modal_form", $view_data);
        }
    }

    function repair_list($companies) {
        $list = array_filter($companies, function($k) {
            return str_contains($k->services, "service-2");
        });
        return $this->list_data($list);
    }

    function new_build_list($companies) {
        $list = array_filter($companies, function($k) {
            return str_contains($k->services, "service-1");
        });
        return $this->list_data($list);
    }

    function scrapping_list($companies) {
        $list = array_filter($companies, function($k) {
            return str_contains($k->services, "service-3");
        });
        return $this->list_data($list);
    }

    function list_data($list) {
        $result = [];
        foreach ($list as $data) {
            $result[] = $this->_make_row($data);
        }

        return $result;
    }

    private function _make_row($data) {
        $name = modal_anchor(get_uri("shipyards/modal_form/" . $data->id), $data->name, array("class" => "shipyard-text", "title" => $data->name . " " . app_lang("information"), "data-id" => '_' . $data->id));

        $services = '<div class="shipyard-row">';
        if (str_contains($data->services, "service-2")) {
            $services .= '<img src="/assets/images/shipyards/repair.png" title="Repairs" alt="Repairs"/>';
        }
        if (str_contains($data->services, "service-1")) {
            $services .= '<img src="/assets/images/shipyards/newbuilding.png" title="New Buildings" alt="New Buildings"/>';
        }
        if (str_contains($data->services, "service-3")) {
            $services .= '<img src="/assets/images/shipyards/recycling.png" title="Recycling" alt="Recycling"/>';
        }
        $services .= '</div>';

        $country = '<span class="flag flag-icon-background fi-' . strtolower($data->country_id) . '"></span> ' . $data->country;

        return array(
            $name,
            $services,
            $country,
            $data->maxLength,
            $data->maxWidth,
            $data->maxDepth,
            $data->phone
        );
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