<?php

namespace App\Controllers;

use Exception;
use stdClass;

class Wires extends Security_Controller {

    function __construct() {
        parent::__construct();
    }

    /* load wires list view */
    function index() {
        return $this->template->rander("wires/index");
    }

    /* load crane add/edit modal */
    function modal_form() {
        $client_id = $this->request->getPost('client_id');
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data["label_column"] = "col-md-4";
        $view_data["field_column"] = "col-md-8";
        $view_data["client_id"] = $client_id;

        return $this->template->view("wires/modal_form", $view_data);
    }

    /* insert or update a crane */
    function save() {
        $client_id = $this->request->getPost('client_id');
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $cranes = array(
            "crane1" => $this->request->getPost("crane1"),
            "crane2" => $this->request->getPost("crane2"),
            "crane3" => $this->request->getPost("crane3"),
            "gangway" => $this->request->getPost("gangway"),
            "provision" => $this->request->getPost("provision"),
            "rescueboat" => $this->request->getPost("rescueboat"),
            "liferaft" => $this->request->getPost("liferaft"),
            "freefallboat" => $this->request->getPost("freefallboat")
        );

        $this->save_wires($client_id, $cranes);

        echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
    }

    function save_wires($client_id, $cranes) {
        $data = array();
        if ($cranes["crane1"]) {
            // Crane #1
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #1',
                'wire' => 'Luffing wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #1',
                'wire' => 'Hoisting wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #1',
                'wire' => 'Aux. wire'
            );
        }

        if ($cranes["crane2"]) {
            // Crane #2
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #2',
                'wire' => 'Luffing wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #2',
                'wire' => 'Hoisting wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #2',
                'wire' => 'Aux. wire'
            );
        }

        if ($cranes["crane3"]) {
            // Crane #3
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #3',
                'wire' => 'Luffing wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #3',
                'wire' => 'Hoisting wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #3',
                'wire' => 'Aux. wire'
            );
        }

        if ($cranes["gangway"]) {
            // Gangway
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Gangway',
                'wire' => 'S/S'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Gangway',
                'wire' => 'P/S'
            );
        }

        if ($cranes["provision"]) {
            // Provision
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Provision',
                'wire' => ''
            );
        }

        if ($cranes["rescueboat"]) {
            // Rescueboat
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Rescueboat',
                'wire' => 'L. raft'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Rescueboat',
                'wire' => 'Boat + L. raft'
            );
        }

        if ($cranes["liferaft"]) {
            // Liferaft
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Liferaft',
                'wire' => ''
            );
        }

        if ($cranes["freefallboat"]) {
            // Freefallboat
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Freefallboat',
                'wire' => '(SB)'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Freefallboat',
                'wire' => '(PS)'
            );
        }

        foreach ($data as $item) {
            $this->Wires_model->ci_save($item, null);
        }
    }

    function list_data() {
        $list_data = $this->Wires_model->get_details(array())->getResult();

        $result_data = array();
        foreach ($list_data as $data) {
            $result_data[] = $this->_make_row($data);
        }

        $result["data"] = $result_data;

        echo json_encode($result);
    }

    private function _make_row($data) {
        $name = $data->name;
        $action = "";
        if ($this->can_access_own_client($data->client_id)) {
            if (!$data->hasCrane) {
                $action = modal_anchor(get_uri("wires/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('add_crane'), "data-post-client_id" => $data->client_id));
            } else {
                $name = anchor(get_uri("wires/view/" . $data->client_id), $data->name);
            }
        }

        $icon = "";
        $required_exchanges = $data->required_exchanges;
        if ($required_exchanges > 0) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            $required_exchanges = '<span style="color: #d50000">' . $required_exchanges . '</span>';
        }

        return array(
            $data->client_id,
            $icon,
            $name,
            $data->cranes,
            $data->wires,
            $required_exchanges,
            $action
        );
    }

    /* load crane details view */
    function view($client_id, $tab = "") {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($client_id) {
            $model_info = $this->Wires_model->get_details(array("client_id" => $client_id))->getRow();
            if ($model_info) {
                $view_data["tab"] = $tab;
                $view_data["crane"] = $model_info;

                $info = $this->Wires_model->get_warnning_info($client_id);
                $require_exchanges = ($info && $info->require_exchanges > 0) ? $info->require_exchanges : 0;
                $require_loadtests = ($info && $info->require_loadtests > 0) ? $info->require_loadtests : 0;
                $require_inspections = ($info && $info->require_inspections > 0) ? $info->require_inspections : 0;
                $warnning = array(
                    "exchanges" => $require_exchanges > 0 ? '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $require_exchanges . '</span>' : "",
                    "loadtests" => $require_loadtests > 0 ? '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $require_loadtests . '</span>' : "",
                    "inspections" => $require_inspections > 0 ? '<span style="width: 18px; height: 18px; color: #ffffff; background-color: #d50000; border-radius: 6px; padding-left: 4px; padding-right: 4px; margin-left: 4px;">' . $require_inspections . '</span>' : ""
                );
                $view_data['warnning'] = $warnning;

                return $this->template->rander("wires/view", $view_data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    function info_tab($client_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($client_id) {
            $view_data['client_id'] = $client_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("wires/info/index", $view_data);
        } else {
            show_404();
        }
    }

    function info_modal_form() {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $wire_id = $this->request->getPost("wire_id");
        $client_id = $this->request->getPost("client_id");

        $model_info = $this->Wires_info_model->get_details(array("wire_id" => $wire_id))->getRow();
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["wire_id"] = $wire_id;
        $view_data["client_id"] = $client_id;
        $view_data["model_info"] = $model_info;

        return $this->template->view("wires/info/modal_form", $view_data);
    }

    function save_info() {
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "wire_id" => "required|numeric",
            "client_id" => "required|numeric",
            "diameter" => "required|numeric",
            "length" => "required|numeric",
            "swl" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        $wire_id = intval($this->request->getPost("wire_id"));

        $data = array(
            "wire_id" => $wire_id,
            "client_id" => intval($this->request->getPost("client_id")),
            "diameter" => floatval($this->request->getPost("diameter")),
            "length" => floatval($this->request->getPost("length")),
            "swl" => floatval($this->request->getPost("swl")),
        );

        $save_id = $this->Wires_info_model->ci_save($data, $id);

        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function info_list_data($client_id) {
        $list_data = $this->Wires_info_model->get_details(array("client_id" => $client_id))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_info_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _info_make_row($data) {
        $action = modal_anchor(get_uri("wires/info_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit') . " - " . $data->crane . " " . $data->wire, "data-post-wire_id" => $data->wire_id, "data-post-client_id" => $data->client_id));

        return array(
            $data->wire_id,
            $data->crane,
            $data->wire,
            $data->diameter,
            $data->length,
            $data->swl,
            $action
        );
    }

    function history_tab($client_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("wires/history/index", $view_data);
        } else {
            show_404();
        }
    }

    function history_modal_form() {
        $wire_id = $this->request->getPost("wire_id");
        $client_id = $this->request->getPost("client_id");

        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["wire_id"] = $wire_id;
        $view_data["client_id"] = $client_id;

        return $this->template->view("wires/history/modal_form", $view_data);
    }

    function save_history() {
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "wire_id" => "required|numeric",
            "client_id" => "required|numeric",
            "replacement" => "required"
        ));

        $data = array(
            "wire_id" => intval($this->request->getPost("wire_id")),
            "client_id" => intval($this->request->getPost("client_id")),
            "replacement" => $this->request->getPost("replacement")
        );

        $save_id = $this->Wires_history_model->ci_save($data, null);

        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function history_list_data($client_id) {
        $list_data = $this->Wires_history_model->get_details($client_id);
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_history_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _history_make_row($data) {
        $action = modal_anchor(get_uri("wires/history_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('add_history') . " - " . $data->name, "data-post-wire_id" => $data->wire_id, "data-post-client_id" => $data->client_id));
        $icon = "";
        if ($data->required_exchanges) {
            $icon = '<div style="width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
        }
        return array(
            $data->wire_id,
            $icon,
            $data->name,
            $data->initial,
            $data->first,
            $data->second,
            $data->third,
            $data->forth,
            $data->fifth,
            $action
        );
    }

    function loadtest_tab($client_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("wires/loadtest/index", $view_data);
        } else {
            show_404();
        }
    }

    function loadtest_modal_form($wire_id) {
        $wire = $this->Wires_model->get_one($wire_id);
        if (!$this->can_access_own_client($wire->client_id)) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost("id");
        $view_data["model_info"] = $this->Wires_loadtest_model->get_one($id);
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["wire"] = $wire;

        return $this->template->view("wires/loadtest/modal_form", $view_data);
    }

    /* upload a post file */
    function upload_file() {
        upload_file_to_temp();
    }

    /* check valid file for client */
    function validate_file() {
        return validate_post_file($this->request->getPost("file_name"));
    }

    function save_loadtest() {
        $id = $this->request->getPost("id");
        $client_id = $this->request->getPost("client_id");

        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "client_id" => "required|numeric",
            "wire_id" => "required|numeric",
            "test_date" => "required",
            "location" => "required"
        ));

        $data = array(
            "client_id" => intval($this->request->getPost("client_id")),
            "wire_id" => intval($this->request->getPost("wire_id")),
            "test_date" => $this->request->getPost("test_date"),
            "location" => $this->request->getPost("location"),
            "passed" => $this->request->getPost("passed"),
            "result" => $this->request->getPost("result"),
        );

        $target_path = getcwd() . "/" . get_general_file_path("wires", $data["client_id"]);
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path);
        $new_files = unserialize($files_data);

        if ($id) {
            $model_info = $this->Wires_loadtest_model->get_one($id);
            $new_files = update_saved_files($target_path, $model_info->files, $new_files);
        }
        $data["files"] = serialize($new_files);

        $save_id = $this->Wires_loadtest_model->ci_save($data, $id);

        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_loadtest() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $model_info = $this->Wires_loadtest_model->get_one($id);

        if ($this->Wires_loadtest_model->delete($id)) {
            // delete files
            if ($model_info->files) {
                $files = unserialize($model_info->files);
                $file_path = getcwd() . "/" . get_general_file_path("wires", $model_info["client_id"]);
                foreach ($files as $file) {
                    delete_app_files($file_path, array($file));
                }
            }
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function loadtest_list_data($client_id) {
        $list = $this->Wires_loadtest_model->get_loadtests($client_id);
        $result = [];
        foreach ($list as $data) {
            $result[] = $this->_loadtest_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    function download_loadtest_file($id, $key) {
        $model_info = $this->Wires_loadtest_model->get_one($id);
        $files = unserialize($model_info->files);
        $client_id = $model_info->client_id;
        $file_data = serialize(array($files[$key]));
        return $this->download_app_files(get_general_file_path("wires", $client_id), $file_data);
    }

    private function _loadtest_make_row($data, $is_detail = false, $last_date = true) {
        $action = "";
        if ($is_detail) {
            if ($this->can_access_own_client($data->client_id)) {
                $action = modal_anchor(get_uri("wires/loadtest_modal_form/" . $data->wire_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                        . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("wires/delete_loadtest"), "data-action" => "delete-confirmation"));
            }
        } else {
            $name = $data->name;

            if ($this->can_access_own_client($data->client_id)) {
                $name = anchor(get_uri("wires/loadtest_detail_view/" . $data->id), $name);
                $action = modal_anchor(get_uri("wires/loadtest_modal_form/" . $data->id), "<i data-feather='plus-circle' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('add_item')));
            }
        }

        $passed = '';
        if ($data->passed) {
            $loadtest_reminder_date = get_loadtest_reminder_date();
            if ($last_date && $loadtest_reminder_date > $data->test_date) {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Due to over due"></div>';
            } else {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;" title="Passed"></div>';
            }
        } else {
            $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Not passed"></div>';
        }

        $files_str = "";
        $files = unserialize($data->files);
        if (is_array($files)) {
            foreach ($files as $key => $file) {
                if ($key > 0) {
                    $files_str .= ", ";
                }
                $files_str .= anchor(get_uri("wires/download_loadtest_file/" . $data->id . "/" .$key), remove_file_prefix($file["file_name"]));
            }
        }

        if ($is_detail) {
            return array(
                $data->id,
                $data->test_date,
                $data->location,
                $passed,
                $data->result,
                $files_str,
                $action
            );
        } else {
            return array(
                $data->id,
                $name,
                $data->test_date,
                $data->location,
                $passed,
                $data->result,
                $files_str,
                $action
            );
        }
    }

    function loadtest_detail_view($wire_id) {
        $model_info = $this->Wires_model->get_one($wire_id);
        if ($model_info->id) {
            if (!$this->can_access_own_client($model_info->client_id)) {
                app_redirect("forbidden");
            }

            $view_data["model_info"] = $model_info;
            return $this->template->rander("wires/loadtest/detail_view", $view_data);
        } else {
            show_404();
        }
    }

    function loadtest_detail_list_data($wire_id) {
        $list = $this->Wires_loadtest_model->get_details($wire_id);
        $result = [];
        foreach ($list as $key => $data) {
            $result[] = $this->_loadtest_make_row($data, true, $key == 0);
        }
        echo json_encode(array("data" => $result));
    }

    function inspection_tab($client_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("wires/inspection/index", $view_data);
        } else {
            show_404();
        }
    }

    function inspection_modal_form($wire_id) {
        $wire = $this->Wires_model->get_one($wire_id);
        if (!$this->can_access_own_client($wire->client_id)) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost("id");
        $view_data["model_info"] = $this->Wires_inspection_model->get_one($id);
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["wire"] = $wire;

        return $this->template->view("wires/inspection/modal_form", $view_data);
    }

    function save_inspection() {
        $id = $this->request->getPost("id");
        $client_id = $this->request->getPost("client_id");
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "client_id" => "required|numeric",
            "wire_id" => "required|numeric",
            "inspection_date" => "required",
            "location" => "required"
        ));

        $data = array(
            "client_id" => intval($this->request->getPost("client_id")),
            "wire_id" => intval($this->request->getPost("wire_id")),
            "inspection_date" => $this->request->getPost("inspection_date"),
            "location" => $this->request->getPost("location"),
            "passed" => $this->request->getPost("passed"),
            "result" => $this->request->getPost("result"),
        );

        $target_path = getcwd() . "/" . get_general_file_path("wires", $data["client_id"]);
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path);
        $new_files = unserialize($files_data);

        if ($id) {
            $model_info = $this->Wires_inspection_model->get_one($id);
            $new_files = update_saved_files($target_path, $model_info->files, $new_files);
        }
        $data["files"] = serialize($new_files);

        $save_id = $this->Wires_inspection_model->ci_save($data, $id);

        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_inspection() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        $model_info = $this->Wires_inspection_model->get_one($id);

        if ($this->Wires_inspection_model->delete($id)) {
            // delete files
            if ($model_info->files) {
                $files = unserialize($model_info->files);
                $file_path = getcwd() . "/" . get_general_file_path("wires", $model_info["client_id"]);
                foreach ($files as $file) {
                    delete_app_files($file_path, array($file));
                }
            }
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function inspection_list_data($client_id) {
        $list_data = $this->Wires_inspection_model->get_inspections($client_id);
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_inspection_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _inspection_make_row($data, $is_detail = false, $last_date = true) {
        $action = "";
        if ($is_detail) {
            if ($this->can_access_own_client($data->client_id)) {
                $action = modal_anchor(get_uri("wires/inspection_modal_form/" . $data->wire_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                        . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("wires/delete_inspection"), "data-action" => "delete-confirmation"));
            }
        } else {
            $name = $data->name;

            if ($this->can_access_own_client($data->client_id)) {
                $name = anchor(get_uri("wires/inspection_detail_view/" . $data->id), $name);
                $action = modal_anchor(get_uri("wires/inspection_modal_form/" . $data->id), "<i data-feather='plus-circle' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('add_item')));
            }
        }

        $passed = '';
        if ($data->passed) {
            $inspection_reminder_date = get_visual_inspection_reminder_date();
            if ($last_date && $inspection_reminder_date > $data->inspection_date) {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Due to over due"></div>';
            } else {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;" title="Passed"></div>';
            }
        } else {
            $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;" title="Not passed"></div>';
        }

        $files_str = "";
        $files = unserialize($data->files);
        if (is_array($files)) {
            foreach ($files as $key => $file) {
                if ($key > 0) {
                    $files_str .= ", ";
                }
                $files_str .= anchor(get_uri("wires/download_inspection_file/" . $data->id . "/" .$key), remove_file_prefix($file["file_name"]));
            }
        }
        $next_suggested_inspection = "";
        if ($data->inspection_date) {
            $next_suggested_inspection = date('Y-m-d', strtotime($data->inspection_date . ' + 12 months'));
        }

        if ($is_detail) {
            return array(
                $data->id,
                $data->inspection_date,
                $data->location,
                $passed,
                $data->result,
                $next_suggested_inspection,
                $files_str,
                $action
            );
        } else {
            return array(
                $data->id,
                $name,
                $data->inspection_date,
                $data->location,
                $passed,
                $data->result,
                $next_suggested_inspection,
                $files_str,
                $action
            );
        }
    }

    function download_inspection_file($id, $key) {
        $model_info = $this->Wires_inspection_model->get_one($id);
        $files = unserialize($model_info->files);
        $client_id = $model_info->client_id;
        $file_data = serialize(array($files[$key]));
        return $this->download_app_files(get_general_file_path("wires", $client_id), $file_data);
    }

    function inspection_detail_view($wire_id) {
        $model_info = $this->Wires_model->get_one($wire_id);
        if ($model_info->id) {
            if (!$this->can_access_own_client($model_info->client_id)) {
                app_redirect("forbidden");
            }

            $view_data["model_info"] = $model_info;
            return $this->template->rander("wires/inspection/detail_view", $view_data);
        } else {
            show_404();
        }
    }

    function inspection_detail_list_data($wire_id) {
        $list = $this->Wires_inspection_model->get_details($wire_id);
        $result = [];
        foreach ($list as $key => $data) {
            $result[] = $this->_inspection_make_row($data, true, $key == 0);
        }
        echo json_encode(array("data" => $result));
    }

    function get_wires_dropdown() {
        $client_id = $this->request->getPost("client_id");
        $crane = $this->request->getPost("crane");

        $dropdown = $this->Wires_model->get_wires_dropdown($client_id, $crane);
        echo json_encode($dropdown);
    }

    // Import data from excel
    function import_modal_form($client_id, $tab) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }
        $view_data["tab"] = $tab;
        $view_data["client_id"] = $client_id;
        return $this->template->view("wires/import_modal_form", $view_data);
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

    function download_sample_excel_file($tab) {
        $file_name = "";
        if ($tab == "info") {
            $file_name = "import-wires-facts-and-figure-sample.xlsx";
        } else if ($tab == "history") {
            $file_name = "import-wires-history-sample.xlsx";
        } else if ($tab == "loadtest") {
            $file_name = "import-wires-loadtest-sample.xlsx";
        } else if ($tab == "inspection") {
            $file_name = "import-wires-inspection-sample.xlsx";
        }
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => $file_name))));
    }

    private function _get_allowed_headers($tab) {
        if ($tab == "info") {
            return array(
                [ "key" => "crane", "required" => true ],
                [ "key" => "wire", "required" => false ],
                [ "key" => "diameter", "required" => false ],
                [ "key" => "length", "required" => false ],
                [ "key" => "swl", "required" => false ]
            );
        } else if ($tab == "history") {
            return array(
                [ "key" => "crane", "required" => true ],
                [ "key" => "wire", "required" => false ],
                [ "key" => "initial", "required" => false ],
                [ "key" => "1st_replacement", "required" => false ],
                [ "key" => "2nd_replacement", "required" => false ],
                [ "key" => "3rd_replacement", "required" => false ],
                [ "key" => "4th_replacement", "required" => false ],
                [ "key" => "5th_replacement", "required" => false ],
            );
        } else if ($tab == "loadtest") {
            return array(
                [ "key" => "crane", "required" => true ],
                [ "key" => "wire", "required" => false ],
                [ "key" => "test_date", "required" => false ],
                [ "key" => "location", "required" => false ],
                [ "key" => "passed", "required" => false ],
                [ "key" => "result", "required" => false ]
            );
        } else if ($tab == "inspection") {
            return array(
                [ "key" => "crane", "required" => true ],
                [ "key" => "wire", "required" => false ],
                [ "key" => "inspection_date", "required" => false ],
                [ "key" => "location", "required" => false ],
                [ "key" => "passed", "required" => false ],
                [ "key" => "result", "required" => false ]
            );
        }
        return [];
    }

    private function _store_item_headers_position($tab, $headers_row = array()) {
        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers($tab));

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

    private function _row_data_validation_and_get_error_message($tab, $key, $data) {
        $allowed_headers = $this->_get_allowed_headers($tab);
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
        $item_data = array();
        $wire_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }

            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "crane") {
                $wire_data["crane"] = $row_data_value;
            } else if ($header_key_value == 'wire') {
                $wire_data["wire"] = $row_data_value;
            } else {
                $item_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "item_data" => $item_data,
            "wire_data" => $wire_data
        );
    }

    function validate_import_file_data($tab, $check_on_submit = false) {
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
                $headers = $this->_store_item_headers_position($tab, $value);

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
                        $row_data_validation = $this->_row_data_validation_and_get_error_message($tab, $key, $row_data);
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

    function save_from_excel_file() {
        $client_id = $this->request->getPost("client_id");
        $tab = $this->request->getPost("tab");
        $file_name = $this->request->getPost('file_name');

        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        if (!$this->validate_import_file_data($tab, true)) {
            echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
        }

        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers($tab));

        if ($tab == "info") {
            $this->_save_wire_info_from_excel_file($client_id, $allowed_headers, $excel_file);
        } else if ($tab == "history") {
            $this->_save_wire_history_from_excel_file($client_id, $allowed_headers, $excel_file);
        } else if ($tab == "loadtest") {
            $this->_save_wire_loadtest_from_excel_file($client_id, $allowed_headers, $excel_file);
        } else if ($tab == "inspection") {
            $this->_save_wire_inspection_from_excel_file($client_id, $allowed_headers, $excel_file);
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    private function _save_wire_info_from_excel_file($client_id, $allowed_headers, $excel_file) {
        $wire_list = $this->Wires_model->get_all_where(array("client_id" => $client_id))->getResult();
        $info_list = $this->Wires_info_model->get_all_where(array("client_id" => $client_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $wire_data = get_array_value($data_array, "wire_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // Wires
                $wire = $this->_find_wire($wire_data, $wire_list);
                if ($wire) {
                    $item_data["wire_id"] = $wire->id;
                } else {
                    $wire_data["client_id"] = $client_id;
                    $m_save_id = $this->Wires_model->ci_save($wire_data);
                    $item_data["wire_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->crane = $wire_data["crane"];
                    $temp->wire = $wire_data["wire"];
                    $wire_list[] = $temp;
                }

                $item_data["client_id"] = $client_id;
                $wire_info = $this->_find_wire_info($item_data["wire_id"], $info_list);
                if ($wire_info) {
                    $this->Wires_info_model->ci_save($item_data, $wire_info->id);
                } else {
                    $m_save_id = $this->Wires_info_model->ci_save($item_data);

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->wire_id = $item_data["wire_id"];
                    $info_list[] = $temp;
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }

    private function _save_wire_history_from_excel_file($client_id, $allowed_headers, $excel_file) {
        $wire_list = $this->Wires_model->get_all_where(array("client_id" => $client_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $wire_data = get_array_value($data_array, "wire_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // Wires
                $wire = $this->_find_wire($wire_data, $wire_list);
                if ($wire) {
                    $wire_id = $wire->id;
                } else {
                    $wire_data["client_id"] = $client_id;
                    $m_save_id = $this->Wires_model->ci_save($wire_data);
                    $wire_id = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->crane = $wire_data["crane"];
                    $temp->wire = $wire_data["wire"];
                    $wire_list[] = $temp;
                }

                // Wires history
                if (isset($item_data["initial"]) && is_valid_date($item_data["initial"])) {
                    $replacement = date_format(date_create($item_data["initial"]), "Y-m-d");
                    $data = array(
                        "client_id" => $client_id,
                        "wire_id" => $wire_id,
                        "replacement" => $replacement,
                        "is_initial" => 1
                    );
                    $this->Wires_history_model->ci_save($data);
                }

                if (isset($item_data["1st_replacement"]) && is_valid_date($item_data["1st_replacement"])) {
                    $replacement = date_format(date_create($item_data["1st_replacement"]), "Y-m-d");
                    $data = array(
                        "client_id" => $client_id,
                        "wire_id" => $wire_id,
                        "replacement" => $replacement
                    );
                    $this->Wires_history_model->ci_save($data);
                }

                if (isset($item_data["2nd_replacement"]) && is_valid_date($item_data["2nd_replacement"])) {
                    $replacement = date_format(date_create($item_data["2nd_replacement"]), "Y-m-d");
                    $data = array(
                        "client_id" => $client_id,
                        "wire_id" => $wire_id,
                        "replacement" => $replacement
                    );
                    $this->Wires_history_model->ci_save($data);
                }

                if (isset($item_data["3rd_replacement"]) && is_valid_date($item_data["3rd_replacement"])) {
                    $replacement = date_format(date_create($item_data["3rd_replacement"]), "Y-m-d");
                    $data = array(
                        "client_id" => $client_id,
                        "wire_id" => $wire_id,
                        "replacement" => $replacement
                    );
                    $this->Wires_history_model->ci_save($data);
                }

                if (isset($item_data["4th_replacement"]) && is_valid_date($item_data["4th_replacement"])) {
                    $replacement = date_format(date_create($item_data["4th_replacement"]), "Y-m-d");
                    $data = array(
                        "client_id" => $client_id,
                        "wire_id" => $wire_id,
                        "replacement" => $replacement
                    );
                    $this->Wires_history_model->ci_save($data);
                }

                if (isset($item_data["5th_replacement"]) && is_valid_date($item_data["5th_replacement"])) {
                    $replacement = date_format(date_create($item_data["5th_replacement"]), "Y-m-d");
                    $data = array(
                        "client_id" => $client_id,
                        "wire_id" => $wire_id,
                        "replacement" => $replacement
                    );
                    $this->Wires_history_model->ci_save($data);
                }
            } catch (Exception $e) {
                continue;
            }

        }
    }

    private function _save_wire_loadtest_from_excel_file($client_id, $allowed_headers, $excel_file) {
        $wire_list = $this->Wires_model->get_all_where(array("client_id" => $client_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $wire_data = get_array_value($data_array, "wire_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // Wires
                $wire = $this->_find_wire($wire_data, $wire_list);
                if ($wire) {
                    $item_data["wire_id"] = $wire->id;
                } else {
                    $wire_data["client_id"] = $client_id;
                    $m_save_id = $this->Wires_model->ci_save($wire_data);
                    $item_data["wire_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->crane = $wire_data["crane"];
                    $temp->wire = $wire_data["wire"];
                    $wire_list[] = $temp;
                }

                $item_data["client_id"] = $client_id;
                if (isset($item_data["test_date"]) && is_valid_date($item_data["test_date"])) {
                    $test_date = date_format(date_create($item_data["test_date"]), "Y-m-d");
                    $item_data["test_date"] = $test_date;
                    $this->Wires_loadtest_model->ci_save($item_data);
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }

    private function _save_wire_inspection_from_excel_file($client_id, $allowed_headers, $excel_file) {
        $wire_list = $this->Wires_model->get_all_where(array("client_id" => $client_id))->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $wire_data = get_array_value($data_array, "wire_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // Wires
                $wire = $this->_find_wire($wire_data, $wire_list);
                if ($wire) {
                    $item_data["wire_id"] = $wire->id;
                } else {
                    $wire_data["client_id"] = $client_id;
                    $m_save_id = $this->Wires_model->ci_save($wire_data);
                    $item_data["wire_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->crane = $wire_data["crane"];
                    $temp->wire = $wire_data["wire"];
                    $wire_list[] = $temp;
                }

                $item_data["client_id"] = $client_id;
                if (isset($item_data["inspection_date"]) && is_valid_date($item_data["inspection_date"])) {
                    $inspection_date = date_format(date_create($item_data["inspection_date"]), "Y-m-d");
                    $item_data["inspection_date"] = $inspection_date;
                    $this->Wires_inspection_model->ci_save($item_data);
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }

    private function _find_wire($data, $arr) {
        $crane = strtolower(trim($data["crane"]));
        $wire = $data["wire"] ? strtolower(trim($data["wire"])) : "";

        foreach ($arr as $item) {
            if (strtolower($item->crane) == $crane && strtolower($item->wire) == $wire) {
                return $item;
            }
        }
        return false;
    }

    private function _find_wire_info($wire_id, $arr) {
        foreach ($arr as $item) {
            if ($item->wire_id == $wire_id) {
                return $item;
            }
        }
        return false;
    }
}