<?php

namespace App\Controllers;

class Wires extends Security_Controller {

    function __construct() {
        parent::__construct();

        // check permission
        $this->init_permission_checker("wire");
    }

    /* load wires list view */
    function index() {
        $this->access_only_allowed_members();
        return $this->template->rander("wires/index");
    }

    private function can_edit_wires() {
        if ($this->login_user->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    /* load crane add/edit modal */
    function modal_form() {
        $this->access_only_allowed_members();
        $client_id = $this->request->getPost('client_id');
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }

        $this->can_access_own_client($client_id);
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
        $this->can_access_own_client($client_id);

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
        $this->access_only_allowed_members();
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
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $model_info = $this->Wires_model->get_details(array("client_id" => $client_id))->getRow();
            if ($model_info) {
                $view_data["tab"] = $tab;
                $view_data["crane"] = $model_info;

                return $this->template->rander("wires/view", $view_data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    function info_tab($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data['client_id'] = $client_id;
            return $this->template->view("wires/info/index", $view_data);
        } else {
            show_404();
        }
    }

    function info_modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_wires()) {
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
        if (!$this->can_edit_wires()) {
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
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

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
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            return $this->template->view("wires/history/index", $view_data);
        } else {
            show_404();
        }
    }

    function history_modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_wires()) {
            app_redirect("forbidden");
        }

        $wire_id = $this->request->getPost("wire_id");
        $client_id = $this->request->getPost("client_id");

        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["wire_id"] = $wire_id;
        $view_data["client_id"] = $client_id;

        return $this->template->view("wires/history/modal_form", $view_data);
    }

    function save_history() {
        if (!$this->can_edit_wires()) {
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
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

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
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            return $this->template->view("wires/loadtest/index", $view_data);
        } else {
            show_404();
        }
    }

    function loadtest_modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_wires()) {
            app_redirect("forbidden");
        }

        $client_id = $this->request->getPost("client_id");

        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["client_id"] = $client_id;
        $view_data["cranes_dropdown"] = $this->Wires_model->get_cranes_dropdown($client_id);

        $id = $this->request->getPost("id");
        if ($id) {
            $view_data["model_info"] = $this->Wires_loadtest_model->get_details(array("id" => $this->request->getPost("id")))->getRow();
        }

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
        if (!$this->can_edit_wires()) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost("id");

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "client_id" => "required|numeric",
            "wire_id" => "required|numeric",
            "test_date" => "required",
            "result" => "required",
            "location" => "required"
        ));

        $data = array(
            "client_id" => intval($this->request->getPost("client_id")),
            "wire_id" => intval($this->request->getPost("wire_id")),
            "test_date" => $this->request->getPost("test_date"),
            "result" => $this->request->getPost("result"),
            "location" => $this->request->getPost("location"),
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
            echo json_encode(array("success" => true, "data" => $this->_loadtest_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_loadtest() {
        if (!$this->can_edit_wires()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $this->access_only_allowed_members();

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
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        $list_data = $this->Wires_loadtest_model->get_details(array("client_id" => $client_id))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_loadtest_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    function download_loadtest_file($id, $key) {
        $model_info = $this->Wires_loadtest_model->get_one($id);
        $files = unserialize($model_info->files);
        $client_id = $model_info->client_id;
        $file_data = serialize(array($files[$key]));
        return $this->download_app_files(get_general_file_path("wires", $client_id), $file_data);
    }

    private function _loadtest_row_data($id) {
        $data = $this->Wires_loadtest_model->get_details(array("id" => $id))->getRow();
        return $this->_loadtest_make_row($data);
    }

    private function _loadtest_make_row($data) {
        $action = modal_anchor(get_uri("wires/loadtest_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_loadtest'), "data-post-id" => $data->id, "data-post-client_id" => $data->client_id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("wires/delete_loadtest"), "data-action" => "delete-confirmation"));

        $files_str = "";
        $files = unserialize($data->files);
        foreach ($files as $key => $file) {
            if ($key > 0) {
                $files_str .= ", ";
            }
            $files_str .= anchor(get_uri("wires/download_loadtest_file/" . $data->id . "/" .$key), remove_file_prefix($file["file_name"]));
        }
        return array(
            $data->id,
            $data->test_date,
            $data->crane,
            $data->wire,
            $data->result,
            $data->location,
            $files_str,
            $action
        );
    }

    function wire_inspection_tab($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            return $this->template->view("wires/wire_inspection/index", $view_data);
        } else {
            show_404();
        }
    }

    function wire_inspection_modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_wires()) {
            app_redirect("forbidden");
        }

        $client_id = $this->request->getPost("client_id");

        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["client_id"] = $client_id;
        $view_data["cranes_dropdown"] = $this->Wires_model->get_cranes_dropdown($client_id);

        $id = $this->request->getPost("id");
        if ($id) {
            $view_data["model_info"] = $this->Wires_inspection_model->get_details(array("id" => $this->request->getPost("id")))->getRow();
        }

        return $this->template->view("wires/wire_inspection/modal_form", $view_data);
    }

    function save_wire_inspection() {
        if (!$this->can_edit_wires()) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost("id");

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "client_id" => "required|numeric",
            "wire_id" => "required|numeric",
            "inspection_date" => "required",
            "result" => "required",
            "location" => "required",
            "next_suggested_inspection" => "required"
        ));

        $data = array(
            "client_id" => intval($this->request->getPost("client_id")),
            "wire_id" => intval($this->request->getPost("wire_id")),
            "inspection_date" => $this->request->getPost("inspection_date"),
            "result" => $this->request->getPost("result"),
            "location" => $this->request->getPost("location"),
            "next_suggested_inspection" => $this->request->getPost("next_suggested_inspection")
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
            echo json_encode(array("success" => true, "data" => $this->_wire_inspection_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_wire_inspection() {
        if (!$this->can_edit_wires()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $this->access_only_allowed_members();

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

    function wire_inspection_list_data($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_own_client($client_id);

        $list_data = $this->Wires_inspection_model->get_details(array("client_id" => $client_id))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_wire_inspection_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _wire_inspection_row_data($id) {
        $data = $this->Wires_inspection_model->get_details(array("id" => $id))->getRow();
        return $this->_wire_inspection_make_row($data);
    }

    private function _wire_inspection_make_row($data) {
        $action = modal_anchor(get_uri("wires/wire_inspection_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_wire_inspection'), "data-post-id" => $data->id, "data-post-client_id" => $data->client_id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("wires/delete_wire_inspection"), "data-action" => "delete-confirmation"));

        $files_str = "";
        $files = unserialize($data->files);
        foreach ($files as $key => $file) {
            if ($key > 0) {
                $files_str .= ", ";
            }
            $files_str .= anchor(get_uri("wires/download_wire_inspection_file/" . $data->id . "/" .$key), remove_file_prefix($file["file_name"]));
        }
        return array(
            $data->id,
            $data->inspection_date,
            $data->crane,
            $data->wire,
            $data->result,
            $data->location,
            $data->next_suggested_inspection,
            $files_str,
            $action
        );
    }

    function download_wire_inspection_file($id, $key) {
        $model_info = $this->Wires_inspection_model->get_one($id);
        $files = unserialize($model_info->files);
        $client_id = $model_info->client_id;
        $file_data = serialize(array($files[$key]));
        return $this->download_app_files(get_general_file_path("wires", $client_id), $file_data);
    }

    function get_wires_dropdown() {
        $client_id = $this->request->getPost("client_id");
        $crane = $this->request->getPost("crane");

        $dropdown = $this->Wires_model->get_wires_dropdown($client_id, $crane);
        echo json_encode($dropdown);
    }
}