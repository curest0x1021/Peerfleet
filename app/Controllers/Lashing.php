<?php

namespace App\Controllers;

use Exception;
use stdClass;

class Lashing extends Security_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        return $this->template->rander("lashing/index");
    }

    function list_data() {
        $list_data = $this->Lashing_model->get_details(array())->getResult();

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
            $name = anchor(get_uri("lashing/view/" . $data->client_id), $data->name);
        }

        $total_items = "---";
        $require_inspections = "---";
        if ($data->total_items > 0) {
            $total_items = $data->total_items;
        }
        if ($data->require_inspections > 0) {
            $require_inspections = '<span style="color: #df0000;">' . $data->require_inspections . '<span>';
        }

        return array(
            $data->client_id,
            $name,
            $require_inspections,
            $total_items,
        );
    }

    /* load lashing details view */
    function view($client_id) {
        if ($client_id) {
            $view_data['client_id'] = $client_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            $view_data['vessel'] = $this->Clients_model->get_one($client_id);
            return $this->template->rander("lashing/view", $view_data);
        } else {
            show_404();
        }
    }

    // Load lashing info tab
    function info_tab($client_id) {
        if ($client_id) {
            $view_data['client_id'] = $client_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("lashing/info/index", $view_data);
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
            "no" => "required",
            "category_id" => "required",
            "name" => "required",
            "qty" => "required",
            "property" => "required"
        ));

        $data = array(
            "client_id" => $this->request->getPost("client_id"),
            "no" => $this->request->getPost("no"),
            "category_id" => $this->request->getPost("category_id"),
            "name" => $this->request->getPost("name"),
            "description" => $this->request->getPost("description"),
            "qty" => $this->request->getPost("qty"),
            "length" => $this->request->getPost("length"),
            "width" => $this->request->getPost("width"),
            "height" => $this->request->getPost("height"),
            "msl" => $this->request->getPost("msl"),
            "bl" => $this->request->getPost("bl"),
            "supplied_date" => $this->request->getPost("supplied_date"),
            "supplied_place" => $this->request->getPost("supplied_place"),
            "property" => $this->request->getPost("property"),
        );

        $save_id = $this->Lashing_model->ci_save($data, $id);
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

        if ($this->Lashing_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function info_list_data($client_id) {
        $list_data = $this->Lashing_model->get_lashing_details(array("client_id" => $client_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_info_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _info_row_data($id) {
        $row = $this->Lashing_model->get_lashing_details(array("id" => $id))->getRow();
        return $this->_info_make_row($row);
    }

    private function _info_make_row($data) {
        $name = $data->name;
        $action = "";
        if ($this->can_access_own_client($data->client_id)) {
            $name = modal_anchor(get_uri("lashing/info_detail_view/" . $data->id), $data->name, array("class" => "edit", "title" => app_lang('lashing'), "data-post-id" => $data->id));
            $action = modal_anchor(get_uri("lashing/info_modal_form/" . $data->client_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("lashing/delete_info"), "data-action" => "delete-confirmation"));
        }

        return array(
            $data->id,
            $data->no,
            $data->category,
            $name,
            $data->description,
            $data->qty,
            $data->length,
            $data->width,
            $data->height,
            $data->msl,
            $data->bl,
            $data->supplied_date,
            $data->supplied_place,
            $data->property,
            $action
        );
    }

    function info_detail_view($id) {
        $model_info = $this->Lashing_model->get_lashing_details(array("id" => $id))->getRow();
        if (!$this->can_access_own_client($model_info->client_id)) {
            app_redirect("forbidden");
        }
        $view_data["model_info"] = $model_info;
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";
        return $this->template->view("lashing/info/detail_view", $view_data);
    }

    function info_modal_form($client_id) {
        if (!$this->can_access_own_client($client_id)) {
            app_redirect("forbidden");
        }
        $id = $this->request->getPost("id");
        $view_data["client_id"] = $client_id;
        $view_data["model_info"] = $this->Lashing_model->get_one($id);
        if (!$id) {
            $view_data["next_no"] = $this->Lashing_model->get_next_no($client_id);
        }
        $view_data["label_column"] = "col-md-4";
        $view_data["field_column"] = "col-md-8";
        $view_data["category_dropdown"] = $this->get_lashing_category_dropdown();

        return $this->template->view("lashing/info/modal_form", $view_data);
    }


    // Load lashing inspection tab
    function inspection_tab($client_id) {
        if ($client_id) {
            $view_data['client_id'] = $client_id;
            $view_data['can_edit_items'] = $this->can_access_own_client($client_id);
            return $this->template->view("lashing/inspection/index", $view_data);
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
            "lashing_id" => "required",
            "inspection_date" => "required",
            "inspected_by" => "required"
        ));

        $data = array(
            "lashing_id" => $this->request->getPost("lashing_id"),
            "inspection_date" => $this->request->getPost("inspection_date"),
            "inspected_by" => $this->request->getPost("inspected_by"),
            "location" => $this->request->getPost("location"),
            "passed" => $this->request->getPost("passed"),
            "remarks" => $this->request->getPost("remarks")
        );

        if (empty($id) && !$this->Lashing_inspection_model->check_valid_inspection($data["lashing_id"], $data["inspection_date"])) {
            echo json_encode(array("success" => false, 'message' => app_lang('inspection_date_invalid')));
        } else {
            $save_id = $this->Lashing_inspection_model->ci_save($data, $id);
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

        if ($this->Lashing_inspection_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function inspection_list_data($client_id) {
        $list_data = $this->Lashing_inspection_model->get_details(array("client_id" => $client_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_inspection_make_row($data, $client_id);
        }
        echo json_encode(array("data" => $result));
    }

    function inspection_detail_list_data($client_id, $lashing_id) {
        $list_data = $this->Lashing_inspection_model->get_history(array("lashing_id" => $lashing_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_inspection_make_row($data, $client_id, false);
        }
        echo json_encode(array("data" => $result));
    }

    private function _inspection_row_data($id, $client_id) {
        $data = $this->Lashing_inspection_model->get_one($id);
        return $this->_inspection_make_row($data, $client_id, false);
    }

    private function _inspection_make_row($data, $client_id, $showInternalId = true) {
        $name = "";
        if ($showInternalId) {
            $name = $data->name;
        }
        $action = "";
        if ($this->can_access_own_client($client_id)) {
            if ($showInternalId) {
                $name = anchor(get_uri("lashing/inspection_detail_view/" . $data->lashing_id), $data->name, array("class" => "edit", "title" => app_lang('lashing')));
                $action = modal_anchor(get_uri("lashing/inspection_modal_form/" . $data->lashing_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "add", "title" => app_lang('add_item'), "data-post-force_refresh" => true));
            } else {
                $action = modal_anchor(get_uri("lashing/inspection_modal_form/" . $data->lashing_id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_item'), "data-post-id" => $data->id, "data-post-force_refresh" => false))
                    . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("lashing/delete_inspection"), "data-action" => "delete-confirmation"));
            }
        }

        $passed = '';
        if ($data->inspection_date) {
            if ($data->passed) {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #00e676; border-radius: 6px;"></div>';
            } else {
                $passed = '<div style="display: inline-block; width: 12px; height: 12px; background-color: #d50000; border-radius: 6px;"></div>';
            }
        }

        $next_inspection_date = "";
        if ($data->inspection_date && $showInternalId) {
            $next_inspection_date = date('Y-m-d', strtotime($data->inspection_date. ' + 1 years'));
        }

        return array(
            $data->id,
            $name,
            $data->inspection_date,
            $data->inspected_by,
            $data->location,
            $passed,
            $data->remarks,
            $next_inspection_date,
            $action
        );
    }

    function inspection_modal_form($lashing_id) {
        $lashing = $this->Lashing_model->get_one($lashing_id);
        if (!$this->can_access_own_client($lashing->client_id)) {
            app_redirect("forbidden");
        }
        $view_data["model_info"] = $this->Lashing_inspection_model->get_one($this->request->getPost("id"));
        $view_data["lashing"] = $lashing;
        $view_data["force_refresh"] = $this->request->getPost("force_refresh");
        $view_data["label_column"] = "col-md-3";
        $view_data["field_column"] = "col-md-9";

        return $this->template->view("lashing/inspection/modal_form", $view_data);
    }

    function inspection_detail_view($lashing_id) {
        $lashing = $this->Lashing_model->get_one($lashing_id);
        if (!$this->can_access_own_client($lashing->client_id)) {
            app_redirect("forbidden");
        }
        $view_data["lashing"] = $lashing;

        return $this->template->rander("lashing/inspection/detail_view", $view_data);
    }

    // Import data from excel
    function import_modal_form($client_id) {
        $view_data["client_id"] = $client_id;
        return $this->template->view("lashing/import_modal_form", $view_data);
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
        $file_name = "import-lashing-sample.xlsx";
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => $file_name))));
    }

    private function _get_allowed_headers() {
        return array(
            ["key" => "no", "required" => true],
            ["key" => "category", "required" => true],
            ["key" => "name", "required" => true],
            ["key" => "description", "required" => false],
            ["key" => "qty", "required" => true],
            ["key" => "length", "required" => false],
            ["key" => "width", "required" => false],
            ["key" => "height", "required" => false],
            ["key" => "msl", "required" => false],
            ["key" => "bl", "required" => false],
            ["key" => "supplied_place", "required" => false],
            ["key" => "supplied_date", "required" => false],
            ["key" => "property", "required" => true],
            ["key" => "inspection_date", "required" => false],
            ["key" => "inspection_authority", "required" => false],
            ["key" => "remarks", "required" => false],
            ["key" => "inspection_passed", "required" => false],
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
        $category_data = array();
        $inspection_data = array();

        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }
            $row_data_value = trim($row_data_value);
            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if ($header_key_value == "category") {
                $category_data["name"] = $row_data_value;
            } else if ($header_key_value == "inspection_date") {
                $inspection_data["inspection_date"] = $row_data_value;
            } else if ($header_key_value == "inspection_authority") {
                $inspection_data["inspected_by"] = $row_data_value;
            } else if ($header_key_value == "inspection_passed") {
                $inspection_data["passed"] = $row_data_value;
            } else if ($header_key_value == "remarks") {
                $inspection_data["remarks"] = $row_data_value;
            } else if ($header_key_value == "supplied_date") {
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
            "item_data" => $item_data,
            "category_data" => $category_data,
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

        $categories = $this->Lashing_category_model->get_all()->getResult();
        $inspections = $this->Lashing_inspection_model->get_all()->getResult();
        $lashings = $this->Lashing_model->get_data($client_id);

        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, continue for the next loop
                continue;
            }

            $data_array = $this->_prepare_item_data($value, $allowed_headers);
            $item_data = get_array_value($data_array, "item_data");
            $category_data = get_array_value($data_array, "category_data");
            $inspection_data = get_array_value($data_array, "inspection_data");

            //couldn't prepare valid data
            if (!($item_data && count($item_data))) {
                continue;
            }

            try {
                // Lashing categories
                $category = $this->findObjectByName($category_data["name"], $categories);
                if ($category) {
                    $item_data["category_id"] = $category->id;
                } else {
                    $m_save_id = $this->Lashing_category_model->ci_save($category_data);
                    $item_data["category_id"] = $m_save_id;

                    $temp = new stdClass();
                    $temp->id = $m_save_id;
                    $temp->name = $category_data["name"];
                    $categories[] = $temp;
                }

                $item_data["client_id"] = $client_id;
                $lashing = $this->findLashingByNo($item_data["no"], $lashings);
                if ($lashing) {
                    $save_id = $lashing->id;
                } else {
                    $save_id = $this->Lashing_model->ci_save($item_data);

                    $temp = new stdClass();
                    $temp->id = $save_id;
                    $temp->no = $item_data["no"];
                    $lashings[] = $temp;
                }

                // Save visual inspection
                if (isset($inspection_data["inspection_date"]) && is_valid_date($inspection_data["inspection_date"])) {
                    $inspection_date = date_format(date_create($inspection_data["inspection_date"]), "Y-m-d");
                    $data = array(
                        "lashing_id" => $save_id,
                        "inspection_date" => $inspection_date,
                        "inspected_by" => $inspection_data["inspected_by"],
                        "remarks" => $inspection_data["remarks"] ?? "",
                        "passed" => $inspection_data["passed"] ?? 0
                    );
                    if ($this->valid_inspection($save_id, $data["inspection_date"], $inspections)) {
                        $this->Lashing_inspection_model->ci_save($data);

                        $temp = new stdClass();
                        $temp->lashing_id = $save_id;
                        $temp->inspection_date = $data["inspection_date"];
                        $inspections[] = $temp;
                    }
                }
            } catch (Exception $e) {
                print_r($e);
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

    private function findLashingByNo($no, $arr) {
        foreach ($arr as $item) {
            if ($no == $item->no) {
                return $item;
            }
        }
        return false;
    }

    private function valid_inspection($lashing_id, $inspection_date, $arr) {
        foreach ($arr as $item) {
            if ($lashing_id == $item->lashing_id && $inspection_date == $item->inspection_date) {
                return false;
            }
        }
        return true;
    }
}
