<?php

namespace App\Controllers;

use Exception;
use stdClass;

class Services extends Security_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
    }

    //load services list view
    function index() {
        $view_data["can_edit_items"] = $this->can_edit_items();
        return $this->template->rander("services/index", $view_data);
    }

    private function can_edit_items() {
        if ($this->login_user->is_admin) {
            return true;
        }
        return false;
    }

    //load services add/edit modal form
    function modal_form() {
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Services_model->get_one($this->request->getPost('id'));
        $view_data['country_dropdown'] = $this->get_country_dropdown();
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";
        return $this->template->view('services/modal_form', $view_data);
    }

    //save service
    function save() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "company" => "required",
            "serviced_ports" => "required",
            "service_type" => "required",
            "website" => "required",
            "email" => "required",
            "phone" => "required",
            "fax" => "required",
            "address" => "required",
            "city" => "required",
            "po_box" => "required",
            "country_id" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "company" => $this->request->getPost('company'),
            "serviced_ports" => $this->request->getPost('serviced_ports'),
            "service_type" => $this->request->getPost('service_type'),
            "website" => $this->request->getPost('website'),
            "email" => $this->request->getPost('email'),
            "phone" => $this->request->getPost('phone'),
            "fax" => $this->request->getPost('fax'),
            "address" => $this->request->getPost('address'),
            "city" => $this->request->getPost('city'),
            "po_box" => $this->request->getPost('po_box'),
            "country_id" => $this->request->getPost('country_id')
        );
        $save_id = $this->Services_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //delete a service
    function delete() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->Services_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    //get data for services list
    function list_data() {
        $list_data = $this->Services_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get an service row data
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Services_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    //prepare an service list row
    private function _make_row($data) {
        $company = $data->company;
        $action = "";

        $website = $data->website;
        if (strpos($website, "http") !== 0) {
            $website = "https://" . $website;
        }
        $website = anchor($website, $website, array("target" => "_blank"));

        if ($this->can_edit_items()) {
            $company = anchor(get_uri('services/view/' . $data->id), $company);
            $action = modal_anchor(get_uri("services/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("services/delete"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $company,
            $data->serviced_ports,
            $data->service_type,
            $website,
            $data->email,
            $data->phone,
            $data->fax,
            $data->address,
            $data->city,
            $data->po_box,
            $data->country,
            $action
        );
    }

    // Detail view page
    function view($id) {
        $model_info = $this->Services_model->get_one($id);
        if ($model_info -> id) {
            $view_data["model_info"] = $model_info;

            return $this->template->rander("services/view", $view_data);
        } else {
            show_404();
        }
    }

    // General Information tab
    function info_tab($id) {
        $view_data["model_info"] = $this->Services_model->get_one($id);
        $view_data["can_edit_items"] = $this->can_edit_items();
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";
        $view_data["country_dropdown"] = $this->get_country_dropdown();

        return $this->template->view("services/info/index", $view_data);
    }

    // Contacts tab
    function contacts_tab($id) {
        $view_data["service_id"] = $id;
        $view_data["can_edit_items"] = $this->can_edit_items();

        return $this->template->view("services/contacts/index", $view_data);
    }

    function contact_modal_form() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $service_id = $this->request->getPost("service_id");
        $id = $this->request->getPost("id");
        $view_data["model_info"] = $this->Service_contacts_model->get_one($id);
        $view_data["service_id"] = $service_id;
        $view_data['label_column'] = "col-md-3";
        $view_data['field_column'] = "col-md-9";

        return $this->template->view("services/contacts/modal_form", $view_data);
    }

    // save service contact
    function save_contact() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "service_id" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "job_title" => "required",
            "email" => "required",
            "phone" => "required"
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "service_id" => $this->request->getPost('service_id'),
            "first_name" => $this->request->getPost('first_name'),
            "last_name" => $this->request->getPost('last_name'),
            "job_title" => $this->request->getPost('job_title'),
            "email" => $this->request->getPost('email'),
            "phone" => $this->request->getPost('phone')
        );
        $save_id = $this->Service_contacts_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_contact_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    // delete a service contact
    function delete_contact() {
        if (!$this->can_edit_items()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->Service_contacts_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    //get data for service contacts list
    function contact_list_data() {
        $list_data = $this->Service_contacts_model->get_all_where(array("deleted" => 0))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_contact_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get an contact row data
    private function _contact_row_data($id) {
        $data = $this->Service_contacts_model->get_one($id);
        return $this->_contact_make_row($data);
    }

    //prepare an contact list row
    private function _contact_make_row($data) {
        $action = "";

        if ($this->can_edit_items()) {
            $action = modal_anchor(get_uri("services/contact_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-service_id" => $data->service_id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("services/delete_contact"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $data->first_name,
            $data->last_name,
            $data->job_title,
            $data->email,
            $data->phone,
            $action
        );
    }



    // Import data from excel
    function import_modal_form() {
        return $this->template->view("services/import_modal_form");
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

    function download_sample_excel_file() {
        $file_name = "import-services-sample.xlsx";
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => $file_name))));
    }

    private function _get_allowed_headers() {
        return array(
            ["key" => "company", "required" => true],
            ["key" => "serviced_ports", "required" => true],
            ["key" => "service_type", "required" => true],
            ["key" => "website", "required" => true],
            ["key" => "email", "required" => true],
            ["key" => "phone", "required" => true],
            ["key" => "fax", "required" => true],
            ["key" => "address", "required" => true],
            ["key" => "city", "required" => true],
            ["key" => "po_box", "required" => true],
            ["key" => "country", "required" => true]
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
        $item_data = array();
        $country_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }
            $row_data_value = trim($row_data_value);
            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "country") {
                $country_data["name"] = $row_data_value;
            } else {
                $item_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "item_data" => $item_data,
            "country_data" => $country_data
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
            exit;
        }

        $file_name = $this->request->getPost('file_name');
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();

        $allowed_headers = array_map(function ($h) {
            return $h["key"];
        }, $this->_get_allowed_headers());

        $services = $this->Services_model->get_all()->getResult();
        $countries = $this->Country_model->get_all()->getResult();

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);

            $item_data = get_array_value($data_array, "item_data");
            $country_data = get_array_value($data_array, "country_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {

                // countries
                $country = $this->findCountry($country_data["name"], $countries);
                if ($country) {
                    $item_data["country_id"] = $country->id;
                } else {
                    continue;
                }

                $service = $this->findService($item_data["company"], $item_data["serviced_ports"], $services);
                if (!$service) {
                    $save_id = $this->Services_model->ci_save($item_data);

                    $temp = new stdClass();
                    $temp->id = $save_id;
                    $temp->company = $item_data["company"];
                    $temp->serviced_ports = $item_data["serviced_ports"];
                    $services[] = $temp;
                }
            } catch (Exception $e) {
                echo json_encode(array('success' => false, 'message' => $e->getMessage()));
                exit;
            }
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }

    private function findCountry($name, $arr) {
        $name = trim(strtolower($name));
        foreach ($arr as $item) {
            if ($name == strtolower($item->name) || $name == strtolower($item->id)) {
                return $item;
            }
        }
        return false;
    }

    private function findService($company, $serviced_ports, $arr) {
        $company = trim(strtolower($company));
        $serviced_ports = trim(strtolower($serviced_ports));
        foreach ($arr as $item) {
            if ($company == strtolower($item->company) && $serviced_ports == strtolower($item->serviced_ports)) {
                return $item;
            }
        }
        return false;
    }
}

/* End of file Services.php */
/* Location: ./app/controllers/Services.php */