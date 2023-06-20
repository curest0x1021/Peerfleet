<?php

namespace App\Controllers;

class Vessel_types extends Security_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
    }

    //load vessel types list view
    function index() {
        return $this->template->rander("vessel_types/index");
    }

    //load vessel types add/edit modal form
    function modal_form() {
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Vessel_types_model->get_one($this->request->getPost('id'));
        return $this->template->view('vessel_types/modal_form', $view_data);
    }

    //save vessel types category
    function save() {

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "title" => $this->request->getPost('title')
        );
        $save_id = $this->Vessel_types_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //delete/undo an vessel types
    function delete() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->request->getPost('undo')) {
            if ($this->Vessel_types_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Vessel_types_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    //get data for vessel types list
    function list_data() {
        $list_data = $this->Vessel_types_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get an expnese category list row
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Vessel_types_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    //prepare an vessel types category list row
    private function _make_row($data) {
        return array($data->title,
            modal_anchor(get_uri("vessel_types/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_vessel_type'), "data-post-id" => $data->id))
            . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_vessel_type'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("vessel_types/delete"), "data-action" => "delete"))
        );
    }

}

/* End of file Vessel_types.php */
/* Location: ./app/controllers/Vessel_types.php */