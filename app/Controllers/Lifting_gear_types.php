<?php

namespace App\Controllers;

class Lifting_gear_types extends Security_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
    }

    function index() {
        return $this->template->rander('lifting_gear_types/index');
    }

    // Certificate types tab
    function certificates_tab() {
        return $this->template->view('lifting_gear_types/certificates/index');
    }

    function certificate_modal_form() {
        $view_data["model_info"] = $this->Certificate_types_model->get_one($this->request->getPost("id"));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view('lifting_gear_types/certificates/modal_form', $view_data);
    }

    function save_certificate() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required|max_length[50]"
        ));

        $id = $this->request->getPost("id");

        $data = array(
            "name" => $this->request->getPost("name")
        );
        $data = clean_data($data);

        //check duplicate type, if found then show an error message
        if ($this->Certificate_types_model->is_duplicated($data["name"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_type")));
            exit();
        }

        $save_id = $this->Certificate_types_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'data' => $this->_certificate_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_certificate() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        if ($this->Certificate_types_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function certificates_list_data() {
        $list_data = $this->Certificate_types_model->get_all_where(array("deleted" => 0))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_certificate_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _certificate_row_data($id) {
        $data = $this->Certificate_types_model->get_one($id);
        return $this->_certificate_make_row($data);
    }

    private function _certificate_make_row($data) {
        $action = modal_anchor(get_uri("lifting_gear_types/certificate_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_type'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("lifting_gear_types/delete_certificate"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->name,
            $action
        );
    }

    // Shackle types tab
    function shackles_tab() {
        return $this->template->view('lifting_gear_types/shackles/index');
    }

    function shackle_modal_form() {
        $view_data["model_info"] = $this->Shackle_types_model->get_one($this->request->getPost("id"));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view('lifting_gear_types/shackles/modal_form', $view_data);
    }

    function save_shackle() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required|max_length[50]"
        ));

        $id = $this->request->getPost("id");

        $data = array(
            "name" => $this->request->getPost("name")
        );
        $data = clean_data($data);

        //check duplicate type, if found then show an error message
        if ($this->Shackle_types_model->is_duplicated($data["name"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_type")));
            exit();
        }

        $save_id = $this->Shackle_types_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'data' => $this->_shackle_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_shackle() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        if ($this->Shackle_types_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function shackles_list_data() {
        $list_data = $this->Shackle_types_model->get_all_where(array("deleted" => 0))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_shackle_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _shackle_row_data($id) {
        $data = $this->Shackle_types_model->get_one($id);
        return $this->_shackle_make_row($data);
    }

    private function _shackle_make_row($data) {
        $action = modal_anchor(get_uri("lifting_gear_types/shackle_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_type'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("lifting_gear_types/delete_shackle"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->name,
            $action
        );
    }

    // Misc. Lifting types tab
    function misc_tab() {
        return $this->template->view('lifting_gear_types/misc/index');
    }

    function misc_modal_form() {
        $view_data["model_info"] = $this->Misc_types_model->get_one($this->request->getPost("id"));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view('lifting_gear_types/misc/modal_form', $view_data);
    }

    function save_misc() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required|max_length[50]"
        ));

        $id = $this->request->getPost("id");

        $data = array(
            "name" => $this->request->getPost("name")
        );
        $data = clean_data($data);

        //check duplicate type, if found then show an error message
        if ($this->Misc_types_model->is_duplicated($data["name"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_type")));
            exit();
        }

        $save_id = $this->Misc_types_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'data' => $this->_misc_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_misc() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        if ($this->Misc_types_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function misc_list_data() {
        $list_data = $this->Misc_types_model->get_all_where(array("deleted" => 0))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_misc_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _misc_row_data($id) {
        $data = $this->Misc_types_model->get_one($id);
        return $this->_misc_make_row($data);
    }

    private function _misc_make_row($data) {
        $action = modal_anchor(get_uri("lifting_gear_types/misc_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_type'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("lifting_gear_types/delete_misc"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->name,
            $action
        );
    }

    // Identified Color Codes tab
    function icc_tab() {
        return $this->template->view('lifting_gear_types/icc/index');
    }

    function icc_modal_form() {
        $view_data["model_info"] = $this->Color_codes_model->get_one($this->request->getPost("id"));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view('lifting_gear_types/icc/modal_form', $view_data);
    }

    function save_icc() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required|max_length[50]"
        ));

        $id = $this->request->getPost("id");

        $data = array(
            "name" => $this->request->getPost("name")
        );
        $data = clean_data($data);

        //check duplicate type, if found then show an error message
        if ($this->Color_codes_model->is_duplicated($data["name"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_type")));
            exit();
        }

        $save_id = $this->Color_codes_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'data' => $this->_icc_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_icc() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        if ($this->Color_codes_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function icc_list_data() {
        $list_data = $this->Color_codes_model->get_all_where(array("deleted" => 0))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_icc_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _icc_row_data($id) {
        $data = $this->Color_codes_model->get_one($id);
        return $this->_icc_make_row($data);
    }

    private function _icc_make_row($data) {
        $action = modal_anchor(get_uri("lifting_gear_types/icc_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_type'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("lifting_gear_types/delete_icc"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->name,
            $action
        );
    }

    // Lashing types tab
    function lashing_tab() {
        return $this->template->view('lifting_gear_types/lashing/index');
    }

    function lashing_modal_form() {
        $view_data["model_info"] = $this->Lashing_category_model->get_one($this->request->getPost("id"));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view('lifting_gear_types/lashing/modal_form', $view_data);
    }

    function save_lashing() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required|max_length[50]"
        ));

        $id = $this->request->getPost("id");

        $data = array(
            "name" => $this->request->getPost("name")
        );
        $data = clean_data($data);

        //check duplicate type, if found then show an error message
        if ($this->Lashing_category_model->is_duplicated($data["name"], $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang("already_exists_type")));
            exit();
        }

        $save_id = $this->Lashing_category_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'data' => $this->_lashing_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_lashing() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost("id");
        if ($this->Lashing_category_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function lashing_list_data() {
        $list_data = $this->Lashing_category_model->get_all_where(array("deleted" => 0))->getResult();
        $result_data = [];
        foreach ($list_data as $data) {
            $result_data[] = $this->_lashing_make_row($data);
        }

        $result["data"] = $result_data;
        echo json_encode($result);
    }

    private function _lashing_row_data($id) {
        $data = $this->Lashing_category_model->get_one($id);
        return $this->_lashing_make_row($data);
    }

    private function _lashing_make_row($data) {
        $action = modal_anchor(get_uri("lifting_gear_types/lashing_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_type'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("lifting_gear_types/delete_lashing"), "data-action" => "delete-confirmation"));

        return array(
            $data->id,
            $data->name,
            $action
        );
    }

}

/* End of file manufacturers.php */
/* Location: ./app/controllers/manufacturers.php */