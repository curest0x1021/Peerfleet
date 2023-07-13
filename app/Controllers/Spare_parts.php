<?php

namespace App\Controllers;

use stdClass;

class Spare_parts extends Security_Controller {

    function __construct() {
        parent::__construct();
    }

    //load note list view
    function index() {
        $view_data["can_edit_items"] = $this->can_edit_items();
        return $this->template->rander("spare_parts/index", $view_data);
    }

    //for team members, check only read_only permission here, since other permission will be checked accordingly
    private function can_edit_items() {
        if ($this->login_user->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    function modal_form() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $view_data['model_info'] = $this->Spare_parts_model->get_one($this->request->getPost('id'));
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        $view_data["manufacturers_dropdown"] = $this->get_manufacturers_dropdown();
        $view_data["applicable_equipments_dropdown"] = $this->get_applicable_machinery_equipments_dropdown();
        $view_data["ship_equipments_dropdown"] = $this->get_ship_machinery_equipments_dropdown();
        $view_data["units_dropdown"] = $this->get_units_dropdown();

        return $this->template->view('spare_parts/modal_form', $view_data);
    }

    function upload_excel_file() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }
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

    function download_sample_excel_file() {
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => "import-spare-parts-sample.xlsx"))));
    }

    function import_modal_form() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        return $this->template->view("spare_parts/import_modal_form");
    }

    private function _get_allowed_headers() {
        return array(
            "is_critical",
            "name",
            "manufacturer",
            "applicable_equipment",
            "ship_equipment",
            "unit_code",
            "unit_name",
            "part_number",
            "part_description",
            "article_number",
            "drawing_number",
            "hs_code"
        );
    }

    private function _store_item_headers_position($headers_row = array()) {
        $allowed_headers = $this->_get_allowed_headers();

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
        $header_value = get_array_value($allowed_headers, $key);

        //there has no date field on default import fields
        //check on custom fields
        if (((count($allowed_headers) - 1) < $key) && $data) {
            if (empty($data)) {
                $error_message = sprintf(app_lang("import_data_empty_message"), app_lang($header_value));
                return $error_message;
            }
        }
    }

    private function _prepare_item_data($data_row, $allowed_headers) {
        //prepare data
        $item_data = array();
        $manufacturer_data = array();
        $applicable_data = array();
        $ship_data = array();
        $unit_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }

            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "manufacturer") {
                $manufacturer_data["name"] = $row_data_value;
            } else if ($header_key_value == "applicable_equipment") {
                $applicable_data["name"] = $row_data_value;
            } else if ($header_key_value == "ship_equipment") {
                $ship_data["name"] = $row_data_value;
            } else if ($header_key_value == "unit_code") {
                $unit_data["code"] = $row_data_value;
            } else if ($header_key_value == 'unit_name') {
                $unit_data["name"] = $row_data_value;
            } else {
                $item_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "item_data" => $item_data,
            "manufacturer_data" => $manufacturer_data,
            "applicable_data" => $applicable_data,
            "ship_data" => $ship_data,
            "unit_data" => $unit_data
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

    function save_from_excel_file() {
        if (!$this->can_edit_items()) {
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

        $allowed_headers = $this->_get_allowed_headers();
        $manufacturers = $this->Manufacturers_model->get_all()->getResult();
        $applicable_equipments = $this->Applicable_equipments_model->get_all()->getResult();
        $ship_equipments = $this->Ship_equipments_model->get_all()->getResult();
        $units = $this->Units_model->get_all()->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $manufacturer_data = get_array_value($data_array, "manufacturer_data");
            $applicable_data = get_array_value($data_array, "applicable_data");
            $ship_data = get_array_value($data_array, "ship_data");
            $unit_data = get_array_value($data_array, "unit_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            // manufacturer
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

            // applicable machinery equipments
            $applicable = $this->findObjectByName($applicable_data["name"], $applicable_equipments);
            if ($applicable) {
                $item_data["applicable_equip_id"] = $applicable->id;
            } else {
                $m_save_id = $this->Applicable_equipments_model->ci_save($applicable_data);
                $item_data["applicable_equip_id"] = $m_save_id;

                $temp = new stdClass();
                $temp->id = $m_save_id;
                $temp->name = $applicable_data["name"];
                $applicable_equipments[] = $temp;
            }

            // ship machinery equipments
            $ship_item = $this->findObjectByName($ship_data["name"], $ship_equipments);
            if ($ship_item) {
                $item_data["ship_equip_id"] = $ship_item->id;
            } else {
                $m_save_id = $this->Ship_equipments_model->ci_save($ship_data);
                $item_data["ship_equip_id"] = $m_save_id;

                $temp = new stdClass();
                $temp->id = $m_save_id;
                $temp->name = $ship_data["name"];
                $ship_equipments[] = $temp;
            }

            // units
            $unit = $this->findObjectByName($unit_data["name"], $units);
            if ($unit) {
                $item_data["unit_code"] = $unit->code;
            } else {
                $m_save_id = $this->Units_model->ci_save($unit_data);
                $item_data["unit_code"] = $unit_data["code"];

                $temp = new stdClass();
                $temp->id = $m_save_id;
                $temp->name = $unit_data["name"];
                $temp->code = $unit_data["code"];
                $units[] = $temp;
            }

            $this->Spare_parts_model->ci_save($item_data);
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    private function findObjectByName($name, $arr) {
        $name = trim($name);
        foreach ($arr as $item) {
            if ($name == $item->name) {
                return $item;
            }
        }
        return false;
    }

    function save() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required|max_length[40]",
            "manufacturer_id" => "required|numeric",
            "applicable_equip_id" => "required|numeric",
            "ship_equip_id" => "required|numeric",
            "unit_code" => "required",
            "part_number" => "required|max_length[30]",
            "part_description" => "required",
            "article_number" => "required|max_length[30]",
            "drawing_number" => "required|max_length[30]",
            "hs_code" => "required|max_length[10]"
        ));

        $id = $this->request->getPost('id');

        $part_description = $this->request->getPost("part_description");
        if (!empty($part_description)) {
            $part_description = str_replace('"', '\"', $part_description);
            $part_description = str_replace("'", "\'", $part_description);
        }

        $data = array(
            "name" => $this->request->getPost('name'),
            "manufacturer_id" => $this->request->getPost('manufacturer_id'),
            "applicable_equip_id" => $this->request->getPost('applicable_equip_id'),
            "ship_equip_id" => $this->request->getPost('ship_equip_id'),
            "unit_code" => $this->request->getPost('unit_code'),
            "part_number" => $this->request->getPost('part_number'),
            "part_description" => $this->request->getPost('part_description'),
            "article_number" => $this->request->getPost('article_number'),
            "drawing_number" => $this->request->getPost('drawing_number'),
            "hs_code" => $this->request->getPost('hs_code'),
            "is_critical" => $this->request->getPost('is_critical')
        );

        $data = clean_data($data);

        $save_id = $this->Spare_parts_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_items_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function save_critical($id = 0) {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        validate_numeric_value($id);
        $is_critical = $this->request->getPost('value');

        $data = $this->Spare_parts_model->get_one($id);
        $data->is_critical = $is_critical;

        $save_id = $this->Spare_parts_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_items_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        if ($this->Spare_parts_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function list_data() {
        $is_critical = $this->request->getPost('is_critical') ? implode(",", $this->request->getPost('is_critical')) : '';
        $list_data = $this->Spare_parts_model->get_details(array('is_critical' => $is_critical))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_items_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _items_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Spare_parts_model->get_details($options)->getRow();
        return $this->_items_make_row($data);
    }

    private function _items_make_row($data) {
        $checkbox_class = "checkbox-blank";
        if ($data->is_critical) {
            $checkbox_class = "checkbox-checked";
        }
        if ($this->can_edit_items()) {
            //show changeable status checkbox and link to team members
            $check_critical = js_anchor("<span class='$checkbox_class mr15 float-start'></span>", array('title' => "", "class" => "js-task", "data-id" => $data->id, "data-value" => $data->is_critical === '1' ? '0' : '1', "data-act" => "update-critical-checkbox"));
        } else {
            $check_critical = "<span class='$checkbox_class mr15 float-start'></span>";
        }

        $actions = "";
        if ($this->can_edit_items()) {
            $actions = modal_anchor(get_uri("spare_parts/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("spare_parts/delete"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $check_critical,
            $data->name,
            $data->manufacturer,
            $data->applicable_equip,
            $data->ship_equip,
            $data->unit,
            $data->part_number,
            $data->hs_code,
            $actions
        );
    }

}

/* End of file notes.php */
/* Location: ./app/controllers/notes.php */