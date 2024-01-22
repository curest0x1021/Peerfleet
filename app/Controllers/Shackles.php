<?php

namespace App\Controllers;

use Exception;
use stdClass;

class Shackles extends Security_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->template->rander("shackles/index");
    }

    function list_data() {
        $list_data = $this->Shackles_model->get_details(array())->getResult();

        $result_data = array();
        foreach ($list_data as $data) {
            $result_data[] = $this->_make_row($data);
        }

        $result["data"] = $result_data;

        echo json_encode($result);
    }

    private function _make_row($data) {
        $name = $data->name;
        if ($this->can_access_own_client($data->client_id)) {
            $name = anchor(get_uri("shackles/main_view/" . $data->client_id), $data->name);
        }

        $total_items = "---";
        $require_loadtests = "---";
        $require_inspections = "---";
        if ($data->total_items > 0) {
            $total_items = $data->total_items;
        }
        if ($data->require_loadtests > 0) {
            $require_loadtests = '<span style="color: #df0000;">' . $data->require_loadtests . '<span>';
        }
        if ($data->require_inspections > 0) {
            $require_inspections = '<span style="color: #df0000;">' . $data->require_inspections . '<span>';
        }

        return array(
            $data->client_id,
            $name,
            $require_loadtests,
            $require_inspections,
            $total_items,
        );
    }

    function main_view($client_id) {
        $view_data["client_id"] = $client_id;
        $view_data["can_edit_items"] = $this->can_access_own_client($client_id);
        $view_data['vessel'] = $this->Clients_model->get_one($client_id);
        return $this->template->rander("shackles/main/index", $view_data);
    }

    function main_modal_form($client_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }
        $view_data["client_id"] = $client_id;
        $view_data["label_column"] = "col-md-4";
        $view_data["field_column"] = "col-md-8";
        $view_data["types_dropdown"] = $this->get_shackle_types_dropdown();
        $view_data["manufacturers_dropdown"] = $this->get_manufacturers_dropdown();
        $view_data["icc_dropdown"] = $this->get_identified_color_codes_dropdown();
        $view_data["certificate_types_dropdown"] = $this->get_certificate_types_dropdown();

        return $this->template->view("shackles/main/modal_form", $view_data);
    }

    function save_main() {
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "client_id" => "required",
            "item_description" => "required",
            "internal_id" => "required",
            "wll" => "required",
            "type_id" => "required",
            "bl" => "required",
            "iw" => "required",
            "pd" => "required",
            "il" => "required",
            "icc_id" => "required",
            "certificate_number" => "required",
            "certificate_type_id" => "required",
            "manufacturer_id" => "required",
            "supplied_date" => "required",
            "supplied_place" => "required",
            "lifts" => "required"
        ));

        $main_data = array(
            "item_description" => $this->request->getPost("item_description"),
            "wll" => $this->request->getPost("wll"),
            "type_id" => $this->request->getPost("type_id"),
            "bl" => $this->request->getPost("bl"),
            "iw" => $this->request->getPost("iw"),
            "pd" => $this->request->getPost("pd"),
            "il" => $this->request->getPost("il")
        );

        $main_row = $this->Shackles_main_model->get_all_where(array("item_description" => $main_data["item_description"]))->getRow();
        if ($main_row) {
            $m_save_id = $this->Shackles_main_model->ci_save($main_data, $main_row->id);
        } else {
            $m_save_id = $this->Shackles_main_model->ci_save($main_data);
        }

        $data = array(
            "internal_id" => $this->request->getPost("internal_id"),
            "client_id" => $this->request->getPost("client_id"),
            "main_id" => $m_save_id,
            "icc_id" => $this->request->getPost("icc_id"),
            "certificate_number" => $this->request->getPost("certificate_number"),
            "certificate_type_id" => $this->request->getPost("certificate_type_id"),
            "tag_marking" => $this->request->getPost("tag_marking"),
            "manufacturer_id" => $this->request->getPost("manufacturer_id"),
            "supplied_date" => $this->request->getPost("supplied_date"),
            "supplied_place" => $this->request->getPost("supplied_place"),
            "lifts" => $this->request->getPost("lifts"),
            "date_of_discharged" => $this->request->getPost("date_of_discharged"),
        );

        $save_id = $this->Shackles_model->ci_save($data);
        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }

    }

    function main_list_data($client_id) {
        $list_data = [];
        if ($client_id) {
            $list_data = $this->Shackles_main_model->get_details($client_id);
        }

        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_main_make_row($data, $client_id);
        }

        echo json_encode(array("data" => $result));
    }

    private function _main_make_row($data, $client_id) {
        $item = $data->item_description;
        if ($this->can_access_own_client($client_id)) {
            $item = anchor(get_uri("shackles/view/" . $client_id . "/" . $data->id), $item);
        }

        $success_icon = '  <span style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;"></span>';
        $failed_icon = '  <span style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></span>';

        $total_test = $data->total_test ? $data->total_test : 0;
        $loadtest_passed = $data->loadtest_passed ? $data->loadtest_passed : 0;
        $inspection_passed = $data->inspection_passed ? $data->inspection_passed : 0;
        $load_tests = $loadtest_passed . " of " . $total_test . " tested";
        if ($loadtest_passed < $total_test) {
            $load_tests .= $failed_icon;
        } else {
            $load_tests .= $success_icon;
        }

        $inspection_tests = $inspection_passed . " of " . $total_test . " inspected";
        if ($inspection_passed < $total_test) {
            $inspection_tests .= $failed_icon;
        } else {
            $inspection_tests .= $success_icon;
        }

        return array(
            $data->id,
            $item,
            $data->wll,
            $data->type,
            $total_test,
            $data->bl,
            $data->iw,
            $data->pd,
            $data->il,
            $data->supplied_place,
            $data->supplied_date,
            $load_tests,
            $inspection_tests
        );
    }

    /* load shackles details view */
    function view($client_id, $main_id) {
        if ($client_id && $main_id) {
            $view_data['client_id'] = $client_id;
            $view_data['main_id'] = $main_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            $view_data['vessel'] = $this->Clients_model->get_one($client_id);
            $view_data['main_info'] = $this->Shackles_main_model->get_one($main_id);
            $info = $this->Shackles_model->get_warnning_info($client_id, $main_id);
            $require_loadtests = ($info && $info->require_loadtests > 0) ? $info->require_loadtests : 0;
            $require_inspections = ($info && $info->require_inspections > 0) ? $info->require_inspections : 0;
            $warnning = array(
                "loadtests" => $require_loadtests > 0 ? '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $require_loadtests . '</span>' : "",
                "inspections" => $require_inspections > 0 ? '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $require_inspections . '</span>' : ""
            );
            $view_data['warnning'] = $warnning;
            return $this->template->rander("shackles/view", $view_data);
        } else {
            show_404();
        }
    }

    // Load shackles info tab
    function info_tab($client_id, $main_id) {
        if ($client_id && $main_id) {
            $view_data['client_id'] = $client_id;
            $view_data['main_id'] = $main_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("shackles/info/index", $view_data);
        } else {
            show_404();
        }
    }

    function save_info() {
        $id = $this->request->getPost("id");
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "client_id" => "required",
            "main_id" => "required",
            "internal_id" => "required",
            "icc_id" => "required",
            "certificate_number" => "required",
            "certificate_type_id" => "required",
            "manufacturer_id" => "required",
            "tag_marking" => "required",
            "supplied_date" => "required",
            "supplied_place" => "required",
            "lifts" => "required"
        ));

        $data = array(
            "internal_id" => $this->request->getPost("internal_id"),
            "client_id" => $this->request->getPost("client_id"),
            "main_id" => $this->request->getPost("main_id"),
            "icc_id" => $this->request->getPost("icc_id"),
            "certificate_number" => $this->request->getPost("certificate_number"),
            "certificate_type_id" => $this->request->getPost("certificate_type_id"),
            "tag_marking" => $this->request->getPost("tag_marking"),
            "manufacturer_id" => $this->request->getPost("manufacturer_id"),
            "supplied_date" => $this->request->getPost("supplied_date"),
            "supplied_place" => $this->request->getPost("supplied_place"),
            "lifts" => $this->request->getPost("lifts"),
            "date_of_discharged" => $this->request->getPost("date_of_discharged"),
        );

        $target_path = getcwd() . "/" . get_general_file_path("shackles", $data["client_id"]);
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path);
        $new_files = unserialize($files_data);

        if ($id) {
            $model_info = $this->Shackles_model->get_one($id);
            $new_files = update_saved_files($target_path, $model_info->files, $new_files);
        }
        $data["files"] = serialize($new_files);

        $save_id = $this->Shackles_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_info_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }

    }

    function delete_info() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Shackles_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function info_list_data($client_id, $main_id) {
        $list_data = $this->Shackles_model->get_shackles_details(array("client_id" => $client_id, "main_id" => $main_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_info_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _info_row_data($id) {
        $row = $this->Shackles_model->get_shackles_details(array("id" => $id))->getRow();
        return $this->_info_make_row($row);
    }

    private function _info_make_row($data, $is_certificate = false) {
        $internal_id = $data->internal_id;
        $action = "";
        if ($this->can_access_own_client($data->client_id)) {
            $internal_id = $is_certificate ? $data->internal_id : modal_anchor(get_uri("shackles/info_detail_view/" . $data->id), $data->internal_id, array("class" => "edit", "title" => app_lang('shackles'), "data-post-id" => $data->id));
            $action = modal_anchor(get_uri("shackles/info_modal_form/" . $data->client_id . "/" . $data->main_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("shackles/delete_info"), "data-action" => "delete-confirmation"));
        }

        $loadtest_reminder_date = get_loadtest_reminder_date();
        $inspection_reminder_date = get_visual_inspection_reminder_date();

        $loadtest_passed = '';
        if ($data->loadtest_passed) {
            if ($loadtest_reminder_date > $data->test_date) {
                $loadtest_passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Due to over due"></div>';
            } else {
                $loadtest_passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;" title="Passed"></div>';
            }
        } else {
            $loadtest_passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Not passed"></div>';
        }

        $inspection_passed = '';
        if ($data->inspection_passed) {
            if ($inspection_reminder_date > $data->inspection_date) {
                $inspection_passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Due to over due"></div>';
            } else {
                $inspection_passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;" title="Passed"></div>';
            }
        } else {
            $inspection_passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Not Passed"></div>';
        }

        $files_str = "";
        $files = unserialize($data->files);
        if (is_array($files)) {
            foreach ($files as $key => $file) {
                if ($key > 0) {
                    $files_str .= ", ";
                }
                $files_str .= anchor(get_uri("shackles/download_certificate_file/" . $data->id . "/" .$key), remove_file_prefix($file["file_name"]));
            }
        }

        return array(
            $data->id,
            $internal_id,
            $data->item_description,
            $data->wll,
            $data->type,
            $data->bl,
            $data->iw,
            $data->pd,
            $data->il,
            $data->icc,
            $data->manufacturer,
            $data->supplied_date,
            $data->lifts,
            $loadtest_passed,
            $inspection_passed,
            $files_str,
            $action
        );
    }

    function info_detail_view($id) {
        $model_info = $this->Shackles_model->get_shackles_details(array("id" => $id))->getRow();
        if (!$this->can_access_own_client($model_info->client_id)) {
            app_redirect("forbidden");
        }
        $view_data["model_info"] = $model_info;
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view("shackles/info/detail_view", $view_data);
    }

    function info_modal_form($client_id, $main_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }
        $id = $this->request->getPost("id");
        $view_data["client_id"] = $client_id;
        $model_info = $this->Shackles_model->get_one($id);
        $main_info = $this->Shackles_main_model->get_one($main_id);
        if (!$id) {
            $next_internal_id = $this->Shackles_model->get_next_internal_id($client_id, $main_id);
            $view_data["next_internal_id"] = $next_internal_id;
        }
        $view_data["model_info"] = $model_info;
        $view_data["main_info"] = $main_info;
        $view_data["label_column"] = "col-md-4";
        $view_data["field_column"] = "col-md-8";
        $view_data["types_dropdown"] = $this->get_shackle_types_dropdown();
        $view_data["manufacturers_dropdown"] = $this->get_manufacturers_dropdown();
        $view_data["icc_dropdown"] = $this->get_identified_color_codes_dropdown();
        $view_data["certificate_types_dropdown"] = $this->get_certificate_types_dropdown();

        return $this->template->view("shackles/info/modal_form", $view_data);
    }

    function get_internal_id() {
        $client_id = $this->request->getPost("client_id");
        $wll = $this->request->getPost("wll");
        $type_id = $this->request->getPost("type_id");
        $internal_id = $this->Shackles_model->get_internal_id($client_id, $wll, $type_id);

        echo json_encode(array("internal_id" => $internal_id));
    }


    // Load shackles loadtest tab
    function loadtest_tab($client_id, $main_id) {
        if ($client_id && $main_id) {
            $view_data['client_id'] = $client_id;
            $view_data['main_id'] = $main_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("shackles/loadtest/index", $view_data);
        } else {
            show_404();
        }
    }

    function save_loadtest() {
        $client_id = $this->request->getPost("client_id");
        $id = $this->request->getPost("id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "shackle_id" => "required",
            "test_date" => "required",
            "tested_by" => "required"
        ));

        $data = array(
            "shackle_id" => $this->request->getPost("shackle_id"),
            "test_date" => $this->request->getPost("test_date"),
            "tested_by" => $this->request->getPost("tested_by"),
            "location" => $this->request->getPost("location"),
            "passed" => $this->request->getPost("passed"),
            "remarks" => $this->request->getPost("remarks"),
            "initial_test" => $this->request->getPost("initial_test")
        );

        if (empty($id) && $data["initial_test"] == 0 && !$this->Shackles_loadtest_model->check_valid_loadtest($data["shackle_id"], $data["test_date"])) {
            echo json_encode(array("success" => false, 'message' => app_lang('loadtest_date_invalid')));
        } else {
            $save_id = $this->Shackles_loadtest_model->ci_save($data, $id);
            if ($save_id) {
                echo json_encode(array("success" => true, "data" => $this->_loadtest_row_data($save_id, $client_id), "id" => $save_id, 'message' => app_lang('record_saved')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
            }
        }

    }

    function delete_loadtest() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Shackles_loadtest_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function loadtest_list_data($client_id, $main_id) {
        $list_data = $this->Shackles_loadtest_model->get_details(array("client_id" => $client_id, "main_id" => $main_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_loadtest_make_row($data, $client_id);
        }
        echo json_encode(array("data" => $result));
    }

    function loadtest_detail_list_data($client_id, $shackle_id) {
        $list_data = $this->Shackles_loadtest_model->get_history(array("shackle_id" => $shackle_id))->getResult();
        $result = array();
        foreach ($list_data as $key => $data) {
            $result[] = $this->_loadtest_make_row($data, $client_id, false, $key == 0);
        }
        echo json_encode(array("data" => $result));
    }

    private function _loadtest_row_data($id, $client_id) {
        $data = $this->Shackles_loadtest_model->get_one($id);
        return $this->_loadtest_make_row($data, $client_id, false, true);
    }

    private function _loadtest_make_row($data, $client_id, $showInternalId = true, $last_date = true) {
        $internal_id = "";
        if ($showInternalId) {
            $internal_id = $data->internal_id;
        }
        $action = "";
        if ($this->can_access_own_client($client_id)) {
            if ($showInternalId) {
                $internal_id = anchor(get_uri("shackles/loadtest_detail_view/" . $data->shackle_id), $internal_id, array("title" => $data->internal_id));
                $action = modal_anchor(get_uri("shackles/loadtest_modal_form/" . $data->shackle_id), "<i data-feather='plus-circle' class='icon-16'></i>", array("class" => "add", "title" => app_lang('add_item'), "data-post-force_refresh" => true));
            } else {
                $action = modal_anchor(get_uri("shackles/loadtest_modal_form/" . $data->shackle_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-force_refresh" => false))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("shackles/delete_loadtest"), "data-action" => "delete-confirmation"));
            }
        }

        $passed = '';
        if ($data->passed) {
            $reminder_date = get_loadtest_reminder_date();
            if ($last_date && $reminder_date > $data->test_date) {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Due to over due"></div>';
            } else {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;" title="Passed"></div>';
            }
        } else {
            $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Not passed"></div>';
        }

        $next_test_date = "";
        if ($data->test_date && $showInternalId) {
            $next_test_date = date('Y-m-d', strtotime($data->test_date. ' + 5 years'));
        }

        if ($showInternalId) {
            return array(
                $data->id,
                $internal_id,
                $data->initial_test_date,
                $data->test_date,
                $data->tested_by,
                $data->location,
                $passed,
                $data->remarks,
                $next_test_date,
                $action
            );
        } else {
            $initial_test = $data->initial_test == "1" ? "<span class='checkbox-checked mr15 float-start'></span>" : "";
            return array(
                $data->id,
                $internal_id,
                $initial_test,
                $data->test_date,
                $data->tested_by,
                $data->location,
                $passed,
                $data->remarks,
                $next_test_date,
                $action
            );
        }
    }

    function loadtest_modal_form($shackle_id) {
        $shackle = $this->Shackles_model->get_one($shackle_id);
        if (!$this->can_access_own_client($shackle->client_id)) {
            app_redirect("forbidden");
        }
        $id = $this->request->getPost("id");
        $view_data["model_info"] = $this->Shackles_loadtest_model->get_one($id);
        $view_data["allow_initial_test"] = $this->Shackles_loadtest_model->is_allow_initial_test($shackle_id, $id);
        $view_data["shackle"] = $shackle;
        $view_data["force_refresh"] = $this->request->getPost("force_refresh");
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";

        return $this->template->view("shackles/loadtest/modal_form", $view_data);
    }

    function loadtest_detail_view($shackle_id) {
        $shackle = $this->Shackles_model->get_one($shackle_id);
        if (!$this->can_access_own_client($shackle->client_id)) {
            app_redirect("forbidden");
        }
        $view_data["shackle"] = $shackle;

        return $this->template->rander("shackles/loadtest/detail_view", $view_data);
    }


    // Load shackles loadtest tab
    function inspection_tab($client_id, $main_id) {
        if ($client_id && $main_id) {
            $view_data['client_id'] = $client_id;
            $view_data['main_id'] = $main_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("shackles/inspection/index", $view_data);
        } else {
            show_404();
        }
    }

    // Load shackles certificate tab
    function certificate_tab($client_id, $main_id) {
        if ($client_id && $main_id) {
            $view_data['client_id'] = $client_id;
            $view_data['main_id'] = $main_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("shackles/certificate/index", $view_data);
        } else {
            show_404();
        }
    }

    function save_inspection() {
        $client_id = $this->request->getPost("client_id");
        $id = $this->request->getPost("id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "shackle_id" => "required",
            "inspection_date" => "required",
            "inspected_by" => "required"
        ));

        $data = array(
            "shackle_id" => $this->request->getPost("shackle_id"),
            "inspection_date" => $this->request->getPost("inspection_date"),
            "inspected_by" => $this->request->getPost("inspected_by"),
            "location" => $this->request->getPost("location"),
            "passed" => $this->request->getPost("passed"),
            "remarks" => $this->request->getPost("remarks")
        );

        if (empty($id) && !$this->Shackles_inspection_model->check_valid_inspection($data["shackle_id"], $data["inspection_date"])) {
            echo json_encode(array("success" => false, 'message' => app_lang('inspection_date_invalid')));
        } else {
            $save_id = $this->Shackles_inspection_model->ci_save($data, $id);
            if ($save_id) {
                echo json_encode(array("success" => true, "data" => $this->_inspection_row_data($save_id, $client_id), "id" => $save_id, 'message' => app_lang('record_saved')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
            }
        }

    }

    function delete_inspection() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Shackles_inspection_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function inspection_list_data($client_id, $main_id) {
        $list_data = $this->Shackles_inspection_model->get_details(array("client_id" => $client_id, "main_id" => $main_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_inspection_make_row($data, $client_id);
        }
        echo json_encode(array("data" => $result));
    }

    function inspection_detail_list_data($client_id, $shackle_id) {
        $list_data = $this->Shackles_inspection_model->get_history(array("shackle_id" => $shackle_id))->getResult();
        $result = array();
        foreach ($list_data as $key => $data) {
            $result[] = $this->_inspection_make_row($data, $client_id, false, $key == 0);
        }
        echo json_encode(array("data" => $result));
    }

    private function _inspection_row_data($id, $client_id) {
        $data = $this->Shackles_inspection_model->get_one($id);
        return $this->_inspection_make_row($data, $client_id, false, true);
    }

    private function _inspection_make_row($data, $client_id, $showInternalId = true, $last_date = true) {
        $internal_id = "";
        if ($showInternalId) {
            $internal_id = $data->internal_id;
        }
        $action = "";
        if ($this->can_access_own_client($client_id)) {
            if ($showInternalId) {
                $internal_id = anchor(get_uri("shackles/inspection_detail_view/" . $data->shackle_id), $internal_id, array("title" => $data->internal_id));
                $action = modal_anchor(get_uri("shackles/inspection_modal_form/" . $data->shackle_id), "<i data-feather='plus-circle' class='icon-16'></i>", array("class" => "add", "title" => app_lang('add_item'), "data-post-force_refresh" => true));
            } else {
                $action = modal_anchor(get_uri("shackles/inspection_modal_form/" . $data->shackle_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-force_refresh" => false))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("shackles/delete_inspection"), "data-action" => "delete-confirmation"));
            }
        }

        $passed = '';
        if ($data->passed) {
            $reminder_date = get_visual_inspection_reminder_date();
            if ($last_date && $reminder_date > $data->inspection_date) {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Due to over due"></div>';
            } else {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;" title="Passed"></div>';
            }
        } else {
            $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Not passed"></div>';
        }

        $next_inspection_date = "";
        if ($data->inspection_date && $showInternalId) {
            $next_inspection_date = date('Y-m-d', strtotime($data->inspection_date. ' + 1 years'));
        }

        return array(
            $data->id,
            $internal_id,
            $data->inspection_date,
            $data->inspected_by,
            $data->location,
            $passed,
            $data->remarks,
            $next_inspection_date,
            $action
        );
    }

    function inspection_modal_form($shackle_id) {
        $shackle = $this->Shackles_model->get_one($shackle_id);
        if (!$this->can_access_own_client($shackle->client_id)) {
            app_redirect("forbidden");
        }
        $view_data["model_info"] = $this->Shackles_inspection_model->get_one($this->request->getPost("id"));
        $view_data["shackle"] = $shackle;
        $view_data["force_refresh"] = $this->request->getPost("force_refresh");
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";

        return $this->template->view("shackles/inspection/modal_form", $view_data);
    }

    function inspection_detail_view($shackle_id) {
        $shackle = $this->Shackles_model->get_one($shackle_id);
        if (!$this->can_access_own_client($shackle->client_id)) {
            app_redirect("forbidden");
        }
        $view_data["shackle"] = $shackle;

        return $this->template->rander("shackles/inspection/detail_view", $view_data);
    }

    function certificate_list_data($client_id, $main_id) {
        $list = $this->Shackles_model->get_shackles_details(array("client_id" => $client_id, "main_id" => $main_id))->getResult();
        $result = [];
        foreach ($list as $data) {
            $result[] = $this->_info_make_row($data, true);
        }

        echo json_encode(array("data" => $result));
    }

    function download_certificate_file($id, $key) {
        $model_info = $this->Shackles_model->get_one($id);
        $files = unserialize($model_info->files);
        $client_id = $model_info->client_id;
        $file_data = serialize(array($files[$key]));
        return $this->download_app_files(get_general_file_path("shackles", $client_id), $file_data);
    }

    // Import data from excel
    function import_modal_form($client_id) {
        $view_data["client_id"] = $client_id;
        return $this->template->view("shackles/import_modal_form", $view_data);
    }

    function upload_excel_file() {
        upload_file_to_temp(true);
    }

    function validate_import_file() {
        $file_name = $this->request->getPost("file_name");
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!is_valid_file_to_upload($file_name)) {
            echo json_encode(array("success" => false, 'message' => app_lang('invalid_file_type')));
            exit();
        }

        if ($file_ext == "xlsx") {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('please_upload_a_excel_file') . " (.xlsx)"));
        }
    }

    /* upload a post file */
    function upload_file() {
        upload_file_to_temp();
    }

    /* check valid file for client */
    function validate_file() {
        return validate_post_file($this->request->getPost("file_name"));
    }

    function download_sample_excel_file() {
        $file_name = "import-shackles-sample.xlsx";
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => $file_name))));
    }

    private function _get_allowed_headers() {
        return array(
            ["key" => "item_description", "required" => true],
            ["key" => "internal_id", "required" => true],
            ["key" => "wll", "required" => true],
            ["key" => "type", "required" => true],
            ["key" => "bl", "required" => false],
            ["key" => "iw", "required" => false],
            ["key" => "pd", "required" => false],
            ["key" => "il", "required" => false],
            ["key" => "icc", "required" => false],
            ["key" => "certificate_number", "required" => true],
            ["key" => "certificate_type", "required" => false],
            ["key" => "tag_marking", "required" => false],
            ["key" => "manufacturer", "required" => false],
            ["key" => "supplied_date", "required" => true],
            ["key" => "supplied_place", "required" => false],
            ["key" => "initial_test_date", "required" => false],
            ["key" => "initial_test_authority", "required" => false],
            ["key" => "last_test_date", "required" => false],
            ["key" => "last_test_authority", "required" => false],
            ["key" => "inspection_date", "required" => false],
            ["key" => "inspection_authority", "required" => false],
            ["key" => "date_of_discharged", "required" => false],
            ["key" => "remarks_load_test", "required" => false],
            ["key" => "remarks_visual_inspection", "required" => false],
            ["key" => "last_test_passed", "required" => true],
            ["key" => "inspection_passed", "required" => true],
        );
    }

    private function _store_item_headers_position($headers_row = array()) {
        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers());

        //check if all headers are correct and on the right position
        $final_headers = array();
        foreach ($headers_row as $key => $header) {
            if (!$header) {
                continue;
            }

            $key_value = str_replace(' ', '_', strtolower(trim($header, " ")));
            $header_on_this_position = get_array_value($allowed_headers, $key);
            $header_array = array("key_value" => $header_on_this_position, "value" => $header);

            if ($header_on_this_position == $key_value) {
                //allowed headers
                //the required headers should be on the correct positions
                //the rest headers will be treated as custom fields
                //pushed header at last of this loop
            } else { //invalid header, flag as red
                $header_array["has_error"] = true;
            }

            if ($key_value) {
                array_push($final_headers, $header_array);
            }
        }

        return $final_headers;
    }

    private function _row_data_validation_and_get_error_message($key, $data) {
        $allowed_headers = $this->_get_allowed_headers();
        $header = null;
        foreach ($allowed_headers as $el) {
            if ($el["key"] == $key) {
                $header = $el;
                break;
            }
        }

        if ($header && $header["required"]) {
            if (empty($data)) {
                $error_message = sprintf(app_lang("import_data_empty_message"), app_lang($header["key"]));
                return $error_message;
            }
        }
    }

    private function _prepare_item_data($data_row, $allowed_headers) {
        //prepare data
        $main_data = array();
        $item_data = array();
        $type_data = array();
        $manufacturer_data = array();
        $icc_data = array();
        $certificate_data = array();
        $loadtest_data = array();
        $inspection_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }
            $row_data_value = trim($row_data_value);
            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "item_description") {
                $main_data["item_description"] = $row_data_value;
            } else if ($header_key_value == "wll") {
                $main_data["wll"] = $row_data_value;
            } else if ($header_key_value == "bl") {
                $main_data["bl"] = $row_data_value;
            } else if ($header_key_value == "iw") {
                $main_data["iw"] = $row_data_value;
            } else if ($header_key_value == "pd") {
                $main_data["pd"] = $row_data_value;
            } else if ($header_key_value == "il") {
                $main_data["il"] = $row_data_value;
            } else if ($header_key_value == "type") {
                $type_data["name"] = $row_data_value;
            } else if ($header_key_value == "manufacturer") {
                $manufacturer_data["name"] = $row_data_value;
            } else if ($header_key_value == "icc") {
                $icc_data["name"] = $row_data_value;
            } else if ($header_key_value == "certificate_type") {
                $certificate_data["name"] = $row_data_value;
            } else if ($header_key_value == "initial_test_date") {
                $loadtest_data["initial"]["test_date"] = $row_data_value;
            } else if ($header_key_value == "initial_test_authority") {
                $loadtest_data["initial"]["tested_by"] = $row_data_value;
            } else if ($header_key_value == "last_test_date") {
                $loadtest_data["last"]["test_date"] = $row_data_value;
            } else if ($header_key_value == "last_test_authority") {
                $loadtest_data["last"]["tested_by"] = $row_data_value;
            } else if ($header_key_value == "last_test_passed") {
                $loadtest_data["last"]["passed"] = $row_data_value;
            } else if ($header_key_value == "remarks_load_test") {
                $loadtest_data["last"]["remarks"] = $row_data_value;
            } else if ($header_key_value == "inspection_date") {
                $inspection_data["inspection_date"] = $row_data_value;
            } else if ($header_key_value == "inspection_authority") {
                $inspection_data["inspected_by"] = $row_data_value;
            } else if ($header_key_value == "inspection_passed") {
                $inspection_data["passed"] = $row_data_value;
            } else if ($header_key_value == "remarks_visual_inspection") {
                $inspection_data["remarks"] = $row_data_value;
            } else if ($header_key_value == "supplied_date") {
                if (is_valid_date($row_data_value)) {
                    $item_data[$header_key_value] = date_format(date_create($row_data_value), "Y-m-d");
                } else {
                    $item_data[$header_key_value] = "";
                }
            } else if ($header_key_value == "date_of_discharged") {
                if (is_valid_date($row_data_value)) {
                    $item_data[$header_key_value] = date_format(date_create($row_data_value), "Y-m-d");
                } else {
                    $item_data[$header_key_value] = "";
                }
            } else {
                $item_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "main_data" => $main_data,
            "item_data" => $item_data,
            "type_data" => $type_data,
            "manufacturer_data" => $manufacturer_data,
            "icc_data" => $icc_data,
            "certificate_data" => $certificate_data,
            "loadtest_data" => $loadtest_data,
            "inspection_data" => $inspection_data,
        );
    }

    function validate_import_file_data($check_on_submit = false) {
        $table_data = "";
        $error_message = "";
        $headers = array();
        $got_error_header = false; //we've to check the valid headers first, and a single header at a time
        $got_error_table_data = false;

        $file_name = $this->request->getPost("file_name");

        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $table_data .= '<table class="table table-responsive table-bordered table-hover" style="width: 100%; color: #444;">';

        $table_data_header_array = array();
        $table_data_body_array = array();

        foreach ($excel_file as $row_key => $value) {
            if ($row_key == 0) { //validate headers
                $headers = $this->_store_item_headers_position($value);

                foreach ($headers as $row_data) {
                    $has_error_class = false;
                    if (get_array_value($row_data, "has_error") && !$got_error_header) {
                        $has_error_class = true;
                        $got_error_header = true;

                        $error_message = sprintf(app_lang("import_error_header"), app_lang(get_array_value($row_data, "key_value")));
                    }

                    array_push($table_data_header_array, array("has_error_class" => $has_error_class, "value" => get_array_value($row_data, "value")));
                }
            } else { //validate data
                if (!array_filter($value)) {
                    continue;
                }

                $error_message_on_this_row = "<ol class='pl15'>";

                foreach ($value as $key => $row_data) {
                    $has_error_class = false;

                    if (!$got_error_header) {
                        $row_data_validation = $this->_row_data_validation_and_get_error_message($key, $row_data);
                        if ($row_data_validation) {
                            $has_error_class = true;
                            $error_message_on_this_row .= "<li>" . $row_data_validation . "</li>";
                            $got_error_table_data = true;
                        }
                    }

                    if (count($headers) > $key) {
                        $table_data_body_array[$row_key][] = array("has_error_class" => $has_error_class, "value" => $row_data);
                    }
                }

                $error_message_on_this_row .= "</ol>";

                //error messages for this row
                if ($got_error_table_data) {
                    $table_data_body_array[$row_key][] = array("has_error_text" => true, "value" => $error_message_on_this_row);
                }
            }
        }

        //return false if any error found on submitting file
        if ($check_on_submit) {
            return ($got_error_header || $got_error_table_data) ? false : true;
        }

        //add error header if there is any error in table body
        if ($got_error_table_data) {
            array_push($table_data_header_array, array("has_error_text" => true, "value" => app_lang("error")));
        }

        //add headers to table
        $table_data .= "<tr>";
        foreach ($table_data_header_array as $table_data_header) {
            $error_class = get_array_value($table_data_header, "has_error_class") ? "error" : "";
            $error_text = get_array_value($table_data_header, "has_error_text") ? "text-danger" : "";
            $value = get_array_value($table_data_header, "value");
            $table_data .= "<th class='$error_class $error_text'>" . $value . "</th>";
        }
        $table_data .= "</tr>";

        //add body data to table
        foreach ($table_data_body_array as $table_data_body_row) {
            $table_data .= "<tr>";
            $error_text = "";

            foreach ($table_data_body_row as $table_data_body_row_data) {
                $error_class = get_array_value($table_data_body_row_data, "has_error_class") ? "error" : "";
                $error_text = get_array_value($table_data_body_row_data, "has_error_text") ? "text-danger" : "";
                $value = get_array_value($table_data_body_row_data, "value");
                $table_data .= "<td class='$error_class $error_text'>" . $value . "</td>";
            }

            if ($got_error_table_data && !$error_text) {
                $table_data .= "<td></td>";
            }

            $table_data .= "</tr>";
        }

        //add error message for header
        if ($error_message) {
            $total_columns = count($table_data_header_array);
            $table_data .= "<tr><td class='text-danger' colspan='$total_columns'><i data-feather='alert-triangle' class='icon-16'></i> " . $error_message . "</td></tr>";
        }

        $table_data .= "</table>";

        echo json_encode(array("success" => true, 'table_data' => $table_data, 'got_error' => ($got_error_header || $got_error_table_data) ? true : false));
    }

    function save_from_excel_file($client_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if (!$this->validate_import_file_data(true)) {
            echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
        }

        $file_name = $this->request->getPost('file_name');
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers());

        $mains = $this->Shackles_main_model->get_all()->getResult();
        $types = $this->Shackle_types_model->get_all()->getResult();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $iccs = $this->Color_codes_model->get_all()->getResult();
        $certificate_types = $this->Certificate_types_model->get_all()->getResult();
        $load_tests = $this->Shackles_loadtest_model->get_all()->getResult();
        $inspections = $this->Shackles_inspection_model->get_all()->getResult();
        $shackles = $this->Shackles_model->get_data($client_id);

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $main_data = get_array_value($data_array, "main_data");
            $item_data = get_array_value($data_array, "item_data");
            $type_data = get_array_value($data_array, "type_data");
            $manufacturer_data = get_array_value($data_array, "manufacturer_data");
            $icc_data = get_array_value($data_array, "icc_data");
            $certificate_data = get_array_value($data_array, "certificate_data");
            $loadtest_data = get_array_value($data_array, "loadtest_data");
            $inspection_data = get_array_value($data_array, "inspection_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // Shackle type
                $type = $this->findObjectByName($type_data["name"], $types);
                if ($type) {
                    $main_data["type_id"] = $type->id;
                } else {
                    $m_save_id = $this->Shackle_types_model->ci_save($type_data);
                    $main_data["type_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->name = $type_data["name"];
                    $types[] = $temp;
                }

                // manufacturer
                if (isset($manufacturer_data["name"]) && $manufacturer_data["name"] !== "---") {
                    $manufacturer = $this->findObjectByName($manufacturer_data["name"], $manufacturers);
                    if ($manufacturer) {
                        $item_data["manufacturer_id"] = $manufacturer->id;
                    } else {
                        $m_save_id = $this->Manufacturers_model->ci_save($manufacturer_data);
                        $item_data["manufacturer_id"] = $m_save_id;

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->name = $manufacturer_data["name"];
                        $manufacturers[] = $temp;
                    }
                }

                // Identified color codes
                if (isset($icc_data["name"]) && $icc_data["name"] != "---") {
                    $icc = $this->findObjectByName($icc_data["name"], $iccs);
                    if ($icc) {
                        $item_data["icc_id"] = $icc->id;
                    } else {
                        $m_save_id = $this->Color_codes_model->ci_save($icc_data);
                        $item_data["icc_id"] = $m_save_id;

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->name = $icc_data["name"];
                        $iccs[] = $temp;
                    }
                }

                // Certificate types
                if (isset($certificate_data["name"]) && $certificate_data["name"] !== "---") {
                    $certificate = $this->findObjectByName($certificate_data["name"], $certificate_types);
                    if ($certificate) {
                        $item_data["certificate_type_id"] = $certificate->id;
                    } else {
                        $m_save_id = $this->Certificate_types_model->ci_save($certificate_data);
                        $item_data["certificate_type_id"] = $m_save_id;

                        $temp = new stdClass();
                        $temp->id = $m_save_id;
                        $temp->name = $certificate_data["name"];
                        $certificate_types[] = $temp;
                    }
                }

                // Shackles main data
                $main = $this->findMainByItem($main_data, $mains);
                if ($main) {
                    $item_data["main_id"] = $main->id;
                } else {
                    $m_save_id = $this->Shackles_main_model->ci_save($main_data);
                    $item_data["main_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->item_description = $main_data["item_description"];
                    $temp->wll = $main_data["wll"];
                    $temp->type_id = $main_data["type_id"];
                    $mains[] = $temp;
                }

                $item_data["client_id"] = $client_id;
                $shackle = $this->findShackleByInternalId($item_data["internal_id"], $shackles);
                if ($shackle) {
                    $save_id = $shackle->id;
                } else {
                    $save_id = $this->Shackles_model->ci_save($item_data);

                    $temp = new stdClass();
                    $temp->id = $save_id;
                    $temp->internal_id = $item_data["internal_id"];
                    $shackles[] = $temp;
                }

                // Save load tests
                if (isset($loadtest_data["initial"]["test_date"]) && is_valid_date($loadtest_data["initial"]["test_date"])) {
                    $test_date = date_format(date_create($loadtest_data["initial"]["test_date"]), "Y-m-d");
                    $data = array(
                        "shackle_id" => $save_id,
                        "initial_test" => 1,
                        "test_date" => $test_date,
                        "tested_by" => $loadtest_data["initial"]["tested_by"] ?? "",
                        "passed" => 1
                    );
                    if ($this->valid_loadtest($save_id, $data["test_date"], $load_tests)) {
                        $this->Shackles_loadtest_model->ci_save($data);

                        $temp = new stdClass();
                        $temp->shackle_id = $save_id;
                        $temp->test_date = $data["test_date"];
                        $load_tests[] = $temp;
                    }
                }

                if (isset($loadtest_data["last"]["test_date"]) && is_valid_date($loadtest_data["last"]["test_date"])) {
                    $test_date = date_format(date_create($loadtest_data["last"]["test_date"]), "Y-m-d");
                    $data = array(
                        "shackle_id" => $save_id,
                        "test_date" => $test_date,
                        "tested_by" => $loadtest_data["last"]["tested_by"] ?? "",
                        "passed" => $loadtest_data["last"]["passed"] ?? 0,
                        "remarks" => $loadtest_data["last"]["remarks"] ?? ""
                    );
                    if ($this->valid_loadtest($save_id, $data["test_date"], $load_tests)) {
                        $this->Shackles_loadtest_model->ci_save($data);

                        $temp = new stdClass();
                        $temp->shackle_id = $save_id;
                        $temp->test_date = $data["test_date"];
                        $load_tests[] = $temp;
                    }
                }

                // Save visual inspection
                if (isset($inspection_data["inspection_date"]) && is_valid_date($inspection_data["inspection_date"])) {
                    $inspection_date = date_format(date_create($inspection_data["inspection_date"]), "Y-m-d");
                    $data = array(
                        "shackle_id" => $save_id,
                        "inspection_date" => $inspection_date,
                        "inspected_by" => $inspection_data["inspected_by"] ?? "",
                        "passed" => $inspection_data["passed"] ?? 0,
                        "remarks" => $inspection_data["remarks"] ?? ""
                    );
                    if ($this->valid_inspection($save_id, $data["inspection_date"], $inspections)) {
                        $this->Shackles_inspection_model->ci_save($data);

                        $temp = new stdClass();
                        $temp->shackle_id = $save_id;
                        $temp->inspection_date = $data["inspection_date"];
                        $inspections[] = $temp;
                    }
                }
            } catch (Exception $e) {
                echo json_encode(array('success' => false, 'message' => $e->getMessage()));
                return;
            }
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    private function findObjectByName($name, $arr) {
        $name = trim(strtolower($name));
        foreach ($arr as $item) {
            if ($name == trim(strtolower($item->name))) {
                return $item;
            }
        }
        return false;
    }

    private function findMainByItem($data, $arr) {
        foreach ($arr as $item) {
            if (($data["item_description"] == $item->item_description) || ($data["wll"] == $item->wll && $data["type_id"] == $item->type_id)) {
                return $item;
            }
        }
        return false;
    }

    private function findShackleByInternalId($internal_id, $arr) {
        foreach ($arr as $item) {
            if ($item->internal_id == $internal_id) {
                return $item;
            }
        }
        return false;
    }

    private function valid_loadtest($shackle_id, $test_date, $arr) {
        foreach ($arr as $item) {
            if ($shackle_id == $item->shackle_id && $test_date == $item->test_date) {
                return false;
            }
        }
        return true;
    }

    private function valid_inspection($shackle_id, $inspection_date, $arr) {
        foreach ($arr as $item) {
            if ($shackle_id == $item->shackle_id && $inspection_date == $item->inspection_date) {
                return false;
            }
        }
        return true;
    }
}
