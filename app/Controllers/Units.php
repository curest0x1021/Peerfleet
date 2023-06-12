<?php

namespace App\Controllers;

class Units extends Security_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
    }

    function index() {
        return $this->template->rander('units/index');
    }

    function modal_form() {
        $view_data["model_info"] = $this->Units_model->get_one($this->request->getPost("id"));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view('units/modal_form', $view_data);
    }

    function save() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "code" => "required",
            "name" => "required"
        ));

        $id = $this->request->getPost("id");

        $data = array(
            "code" => $this->request->getPost("code"),
            "name" => $this->request->getPost("name")
        );
        $data = clean_data($data);

        //check duplicate company name, if found then show an error message
        if ($this->Units_model->is_duplicate_unit_code($data["code"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_unit_code")));
            exit();
        }

        $save_id = $this->Units_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        if ($this->Units_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function list_data() {
        $list_data = $this->Units_model->get_all_where(array("deleted" => 0))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _make_row($data) {
        $action = modal_anchor(get_uri("units/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_unit'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_unit'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("units/delete"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->code,
            $data->name,
            $action
        );
    }

}

/* End of file Units.php */
/* Location: ./app/controllers/Units.php */