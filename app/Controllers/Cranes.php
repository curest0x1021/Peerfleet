<?php

namespace App\Controllers;

class Cranes extends Security_Controller {

    function __construct() {
        parent::__construct();

        // check permission
        $this->init_permission_checker("crane");
    }

    /* load cranes list view */
    function index() {
        $this->access_only_allowed_members();
        return $this->template->rander("cranes/index");
    }

    private function can_edit_clients() {
        if ($this->login_user->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    /* load crane add/edit modal */
    function modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $client_id = $this->request->getPost('client_id');
        $this->can_access_this_client($client_id);
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["client_id"] = $client_id;
        $cranes_dropdown = ["2" => "2", "3" => 3];
        $view_data["cranes_dropdown"] = $cranes_dropdown;

        return $this->template->view("cranes/modal_form", $view_data);
    }

    /* insert or update a crane */
    function save() {
        $client_id = $this->request->getPost('client_id');
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }
        $this->can_access_this_client($client_id);

        $cranes = intval($this->request->getPost("cranes"));
        $gangway = $this->request->getPost("gangway");
        $provision = $this->request->getPost("provision");

        $this->save_ropes($client_id, $cranes, $gangway, $provision);

        echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
    }

    function save_ropes($client_id, $cranes = 2, $gangway = true, $provision = false) {
        $data = array();
        // Crane #1
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Crane #1',
            'rope' => 'Luffing wire'
        );
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Crane #1',
            'rope' => 'Hoisting wire'
        );
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Crane #1',
            'rope' => 'Aux. wire'
        );
        // Crane #2
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Crane #2',
            'rope' => 'Luffing wire'
        );
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Crane #2',
            'rope' => 'Hoisting wire'
        );
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Crane #2',
            'rope' => 'Aux. wire'
        );
        if ($cranes == 3) {
            // Crane #3
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #3',
                'rope' => 'Luffing wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #3',
                'rope' => 'Hoisting wire'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Crane #3',
                'rope' => 'Aux. wire'
            );
        }

        // Gangway
        if ($gangway) {
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Gangway',
                'rope' => 'S/S'
            );
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Gangway',
                'rope' => 'P/S'
            );
        }

        // Provision
        if ($provision) {
            $data[] = array(
                'client_id' => $client_id,
                'crane' => 'Provision',
                'rope' => ''
            );
        }

        // Rescueboat
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Rescueboat',
            'rope' => 'L. raft'
        );
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Rescueboat',
            'rope' => 'Boat + L. raft'
        );

        // Liferaft
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Liferaft',
            'rope' => ''
        );

        // Freefallboat
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Freefallboat',
            'rope' => '(SB)'
        );
        $data[] = array(
            'client_id' => $client_id,
            'crane' => 'Freefallboat',
            'rope' => '(PS)'
        );

        foreach ($data as $item) {
            $this->Cranes_model->ci_save($item, null);
        }
    }

    function list_data() {
        $this->access_only_allowed_members();
        $list_data = $this->Cranes_model->get_details(array())->getResult();

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
        if ($this->can_edit_clients()) {
            if (!$data->hasCrane) {
                $action = modal_anchor(get_uri("cranes/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('add_crane'), "data-post-client_id" => $data->client_id));
            } else {
                $name = anchor(get_uri("cranes/view/" . $data->client_id), $data->name);
            }
        }

        return array(
            $data->client_id,
            $name,
            $action
        );
    }

    /* load crane details view */
    function view($client_id, $tab = "") {
        $this->access_only_allowed_members();
        $this->can_access_this_client($client_id);

        if ($client_id) {
            $model_info = $this->Cranes_model->get_details(array("client_id" => $client_id))->getRow();
            if ($model_info) {
                $view_data["tab"] = $tab;
                $view_data["crane"] = $model_info;

                return $this->template->rander("cranes/view", $view_data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    function info_tab($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_this_client($client_id);

        if ($client_id) {
            $view_data['client_id'] = $client_id;
            return $this->template->view("cranes/info/index", $view_data);
        } else {
            show_404();
        }
    }

    function info_modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $rope_id = $this->request->getPost("rope_id");
        $client_id = $this->request->getPost("client_id");

        $model_info = $this->Cranes_info_model->get_details(array("rope_id" => $rope_id))->getRow();
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["rope_id"] = $rope_id;
        $view_data["client_id"] = $client_id;
        $view_data["model_info"] = $model_info;

        return $this->template->view("cranes/info/modal_form", $view_data);
    }

    function save_info() {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "rope_id" => "required|numeric",
            "client_id" => "required|numeric",
            "diameter" => "required|numeric",
            "length" => "required|numeric",
            "swl" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        $rope_id = intval($this->request->getPost("rope_id"));

        $data = array(
            "rope_id" => $rope_id,
            "client_id" => intval($this->request->getPost("client_id")),
            "diameter" => floatval($this->request->getPost("diameter")),
            "length" => floatval($this->request->getPost("length")),
            "swl" => floatval($this->request->getPost("swl")),
        );

        $save_id = $this->Cranes_info_model->ci_save($data, $id);

        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function info_list_data($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_this_client($client_id);

        $list_data = $this->Cranes_info_model->get_details(array("client_id" => $client_id))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_info_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _info_make_row($data) {
        $action = modal_anchor(get_uri("cranes/info_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit') . " - " . $data->crane . " " . $data->rope, "data-post-rope_id" => $data->rope_id, "data-post-client_id" => $data->client_id));

        return array(
            $data->rope_id,
            $data->crane,
            $data->rope,
            $data->diameter,
            $data->length,
            $data->swl,
            $action
        );
    }

    function history_tab($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_this_client($client_id);

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            return $this->template->view("cranes/history/index", $view_data);
        } else {
            show_404();
        }
    }

    function history_modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $rope_id = $this->request->getPost("rope_id");
        $client_id = $this->request->getPost("client_id");

        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["rope_id"] = $rope_id;
        $view_data["client_id"] = $client_id;

        return $this->template->view("cranes/history/modal_form", $view_data);
    }

    function save_history() {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "rope_id" => "required|numeric",
            "client_id" => "required|numeric",
            "replacement" => "required"
        ));

        $data = array(
            "rope_id" => intval($this->request->getPost("rope_id")),
            "client_id" => intval($this->request->getPost("client_id")),
            "replacement" => $this->request->getPost("replacement")
        );

        $save_id = $this->Cranes_history_model->ci_save($data, null);

        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function history_list_data($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_this_client($client_id);

        $list_data = $this->Cranes_history_model->get_details($client_id);
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_history_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _history_make_row($data) {
        $action = modal_anchor(get_uri("cranes/history_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('add_history') . " - " . $data->name, "data-post-rope_id" => $data->rope_id, "data-post-client_id" => $data->client_id));

        return array(
            $data->rope_id,
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
        $this->can_access_this_client($client_id);

        if ($client_id) {
            $view_data["client_id"] = $client_id;
            return $this->template->view("cranes/loadtest/index", $view_data);
        } else {
            show_404();
        }
    }

    function loadtest_modal_form() {
        $this->access_only_allowed_members();
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $client_id = $this->request->getPost("client_id");

        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["client_id"] = $client_id;

        $id = $this->request->getPost("id");
        $view_data["model_info"] = $this->Cranes_loadtest_model->get_one($this->request->getPost("id"));

        return $this->template->view("cranes/loadtest/modal_form", $view_data);
    }

    function save_loadtest() {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost("id");

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "client_id" => "required|numeric",
            "test_date" => "required",
            "result" => "required",
            "location" => "required"
        ));

        $data = array(
            "client_id" => intval($this->request->getPost("client_id")),
            "test_date" => $this->request->getPost("test_date"),
            "result" => $this->request->getPost("result"),
            "location" => $this->request->getPost("location"),
        );

        $save_id = $this->Cranes_loadtest_model->ci_save($data, $id);

        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_loadtest() {
        if (!$this->can_edit_clients()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $this->access_only_allowed_members();

        $id = $this->request->getPost('id');

        if ($this->Cranes_loadtest_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function loadtest_list_data($client_id) {
        $this->access_only_allowed_members();
        $this->can_access_this_client($client_id);

        $list_data = $this->Cranes_loadtest_model->get_details(array("client_id" => $client_id))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_loadtest_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _loadtest_make_row($data) {
        $action = modal_anchor(get_uri("cranes/loadtest_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_loadtest'), "data-post-id" => $data->id, "data-post-client_id" => $data->client_id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_loadtest'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("cranes/delete_loadtest"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->test_date,
            $data->result,
            $data->location,
            $action
        );
    }
}