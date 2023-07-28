<?php

namespace App\Controllers;

class Shipyards extends Security_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->country();
    }

    private function can_edit_items() {
        if ($this->login_user->is_admin) {
            return true;
        }
        return false;
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
            $view_data["can_edit_items"] = $this->can_edit_items();

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
            $view_data["can_edit_items"] = $this->can_edit_items();

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
            $view_data["can_edit_items"] = $this->can_edit_items();

            return $this->template->rander("shipyards/view", $view_data);
        }
    }

    function modal_view($id = 0) {
        $model_info = $this->Shipyards_model->get_details(array("id" => $id))->getRow();
        if (empty($model_info->id)) {
            show_404();
        } else {
            $view_data["model_info"] = $model_info;
            $view_data["label_column"] = "col-md-3";
            $view_data["field_column"] = "col-md-9";
            return $this->template->view("shipyards/modal_view", $view_data);
        }
    }

    function modal_form() {
        $id = $this->request->getPost("id");
        $model_info = $this->Shipyards_model->get_one($id);

        $view_data["model_info"] = $model_info;
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["country_map"] = $this->Shipyards_model->get_country_map();
        $view_data["countries_dropdown"] = $this->_get_countries_dropdown();
        $view_data["regions_dropdown"] = $this->_get_regions_dropdown();
        $view_data["sailing_areas_dropdown"] = $this->_get_sailing_areas_dropdown();
        $view_data["services_dropdown"] = $this->_get_services_dropdown();
        return $this->template->view("shipyards/modal_form", $view_data);
    }

    function save() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost("id");
        $this->validate_submitted_data(array(
            "id" => "required",
            "name" => "required",
            "country_id" => "required",
            "region_id" => "required",
            "sailingarea_id" => "required",
            "lat" => "required",
            "lon" => "required",
            "services" => "required"
        ));

        $data = array(
            "id" => $this->request->getPost("id"),
            "name" => $this->request->getPost("name"),
            "description" => $this->request->getPost("description"),
            "country_id" => strtoupper($this->request->getPost("country_id")),
            "region_id" => $this->request->getPost("region_id"),
            "sailingarea_id" => $this->request->getPost("sailingarea_id"),
            "lat" => $this->request->getPost("lat"),
            "lon" => $this->request->getPost("lon"),
            "url" => $this->request->getPost("url"),
            "services" => $this->request->getPost("services"),
            "score" => $this->request->getPost("score"),
            "maxLength" => $this->request->getPost("maxLength"),
            "maxWidth" => $this->request->getPost("maxWidth"),
            "maxDepth" => $this->request->getPost("maxDepth"),
            "docksCount" => $this->request->getPost("docksCount"),
            "cranesCount" => $this->request->getPost("cranesCount"),
            "dock" => $this->request->getPost("dock"),
            "email" => $this->request->getPost("email"),
            "phone" => $this->request->getPost("phone"),
            "fax" => $this->request->getPost("fax"),
            "city" => $this->request->getPost("city"),
            "street" => $this->request->getPost("street"),
            "zip" => $this->request->getPost("zip"),
            "only_new_build" => $this->request->getPost("only_new_build"),
            "published" => $this->request->getPost("published")
        );

        $save_id = $this->Shipyards_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
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
        $name = modal_anchor(get_uri("shipyards/modal_view/" . $data->id), $data->name, array("class" => "shipyard-text", "title" => $data->name . " " . app_lang("information"), "data-id" => '_' . $data->id));

        $services = '<div class="shipyard-row">';
        if (str_contains($data->services, "service-2")) {
            $services .= '<img src="/assets/images/shipyards/repair.png" title="Repairs" alt="Repairs"/>';
        }
        if (str_contains($data->services, "service-1")) {
            $services .= '<img src="/assets/images/shipyards/newbuilding.png" title="New Buildings" alt="New Buildings"/>';
        }
        if (str_contains($data->services, "service-3")) {
            $services .= '<img src="/assets/images/shipyards/recycling.png" title="Scrapping" alt="Scrapping"/>';
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

    private function _get_services_dropdown() {
        $dropdown = [
            [ "id" => "service-2", "text" => app_lang("repairs") ],
            [ "id" => "service-1", "text" => app_lang("new_buildings") ],
            [ "id" => "service-3", "text" => app_lang("scrapping") ]
        ];
        return json_encode($dropdown);
    }

    private function _get_sailing_areas_dropdown() {
        $list = $this->Shipyards_model->get_sailing_areas();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
    }

    private function _get_regions_dropdown() {
        $list = $this->Shipyards_model->get_regions();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
    }

    private function _get_countries_dropdown() {
        $list = $this->Shipyards_model->get_countries();
        $dropdown = array("" => "-");
        foreach ($list as $item) {
            $dropdown[$item->id] = $item->name;
        }
        return $dropdown;
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