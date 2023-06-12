<?php

namespace App\Controllers;

class Critical_spare_parts extends Security_Controller {

    function __construct() {
        parent::__construct();
    }

    //load note list view
    function index() {
        return $this->template->rander("critical_spare_parts/index");
    }

    //for team members, check only read_only permission here, since other permission will be checked accordingly
    private function can_edit_items() {
        if ($this->login_user->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    function items_tab() {

    }

    function items_modal_form() {
        $view_data['model_info'] = $this->Critical_spare_parts_model->get_one($this->request->getPost('id'));
        return $this->template->view('critical_spare_parts/modal_form', $view_data);
    }

    function save_item() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required",
            "project_id" => "numeric",
            "client_id" => "numeric",
            "user_id" => "numeric"
        ));

        $id = $this->request->getPost('id');

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "note");
        $new_files = unserialize($files_data);

        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description'),
            "created_by" => $this->login_user->id,
            "labels" => $this->request->getPost('labels'),
            "project_id" => $this->request->getPost('project_id') ? $this->request->getPost('project_id') : 0,
            "client_id" => $this->request->getPost('client_id') ? $this->request->getPost('client_id') : 0,
            "user_id" => $this->request->getPost('user_id') ? $this->request->getPost('user_id') : 0,
            "is_public" => $this->request->getPost('is_public') ? $this->request->getPost('is_public') : 0
        );

        if ($id) {
            $note_info = $this->Critical_spare_parts_model->get_one($id);
            $timeline_file_path = get_setting("timeline_file_path");

            $new_files = update_saved_files($timeline_file_path, $note_info->files, $new_files);
        }

        $data["files"] = serialize($new_files);

        if ($id) {
            //saving existing note. check permission
            $note_info = $this->Critical_spare_parts_model->get_one($id);

            $this->validate_access_to_note($note_info, true);
        } else {
            $data['created_at'] = get_current_utc_time();
        }

        $data = clean_data($data);

        $save_id = $this->Critical_spare_parts_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_item() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        $note_info = $this->Critical_spare_parts_model->get_one($id);
        $this->validate_access_to_note($note_info, true);

        if ($this->Critical_spare_parts_model->delete($id)) {
            //delete the files
            $file_path = get_setting("timeline_file_path");
            if ($note_info->files) {
                $files = unserialize($note_info->files);

                foreach ($files as $file) {
                    delete_app_files($file_path, array($file));
                }
            }

            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function items_list_data($type = "", $id = 0) {
        validate_numeric_value($id);
        $options = array();

        if ($type == "project" && $id) {
            $options["created_by"] = $this->login_user->id;
            $options["project_id"] = $id;
        } else if ($type == "client" && $id) {
            $options["client_id"] = $id;
        } else if ($type == "user" && $id) {
            $options["user_id"] = $id;
        } else {
            $options["created_by"] = $this->login_user->id;
            $options["my_notes"] = true;
        }

        $list_data = $this->Critical_spare_parts_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _items_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Critical_spare_parts_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    private function _items_make_row($data) {
        $public_icon = "";
        if ($data->is_public) {
            $public_icon = "<i data-feather='globe' class='icon-16'></i> ";
        }

        $title = modal_anchor(get_uri("critical_spare_parts/view/" . $data->id), $public_icon . $data->title, array("title" => app_lang('note'), "data-post-id" => $data->id));

        if ($data->labels_list) {
            $note_labels = make_labels_view_data($data->labels_list, true);
            $title .= "<br />" . $note_labels;
        }

        $files_link = "";
        $file_download_link = "";
        if ($data->files) {
            $files = unserialize($data->files);
            if (count($files)) {
                foreach ($files as $key => $value) {
                    $file_name = get_array_value($value, "file_name");
                    $link = get_file_icon(strtolower(pathinfo($file_name, PATHINFO_EXTENSION)));
                    $file_download_link = anchor(get_uri("critical_spare_parts/download_files/" . $data->id), "<i data-feather='download'></i>", array("title" => app_lang("download"), "class" => "font-22"));
                    $files_link .= js_anchor("<i data-feather='$link'></i>", array('title' => "", "data-toggle" => "app-modal", "data-sidebar" => "0", "class" => "float-start font-22 mr10", "title" => remove_file_prefix($file_name), "data-url" => get_uri("critical_spare_parts/file_preview/" . $data->id . "/" . $key)));
                }
            }
        }

        //only creator and admin can edit/delete notes
        $actions = modal_anchor(get_uri("critical_spare_parts/view/" . $data->id), "<i data-feather='cloud-lightning' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('note_details'), "data-modal-title" => app_lang("note"), "data-post-id" => $data->id));
        if ($data->created_by == $this->login_user->id || $this->login_user->is_admin || $data->client_id) {
            $actions = modal_anchor(get_uri("critical_spare_parts/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_note'), "data-post-id" => $data->id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_note'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("critical_spare_parts/delete"), "data-action" => "delete-confirmation"));
        }


        return array(
            $data->created_at,
            format_to_relative_time($data->created_at),
            $title,
            $files_link . $file_download_link,
            $actions
        );
    }
}

/* End of file notes.php */
/* Location: ./app/controllers/notes.php */