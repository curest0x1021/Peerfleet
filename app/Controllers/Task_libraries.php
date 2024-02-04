<?php

namespace App\Controllers;

class Task_libraries extends Security_Controller {
    public function __construct() {
        parent::__construct();
        // $this->access_only_admin_or_settings_admin();
        $this->Task_priority_model = model("App\Models\Task_priority_model");
        $this->Task_libraries_model = model("App\Models\Task_libraries_model");
    }

    function index() {
        $allStatus=$this->Task_status_model->get_all()->getResultArray();
        $allPriorities=$this->Task_priority_model->get_all()->getResultArray();
        $allMilestones=$this->Milestones_model->get_all()->getResultArray();
        $allTasklibraries=$this->Task_libraries_model->get_all()->getResultArray();
        return $this->template->rander('task_libraries/index',["allTasklibraries"=>$allTasklibraries,"allMilestones"=>$allMilestones,"allStatus"=>$allStatus,"allPriorities"=>$allPriorities]);
    }
    function import_modal(){
        $this->access_only_team_members();
        if (!$this->can_create_tasks()) {
            app_redirect("forbidden");
        }
        $view_data['project_id'] = $this->request->getPost('project_id');
        return $this->template->view("task_libraries/import_modal", $view_data);
    }
    function export_modal(){
        $this->access_only_team_members();
        if (!$this->can_create_tasks()) {
            app_redirect("forbidden");
        }
        $view_data['project_id'] = $this->request->getPost('project_id');
        return $this->template->view("task_libraries/export_modal", $view_data);
    }
    function download_sample_excel_file() {
        return $this->download_app_files(get_setting("system_file_path"), serialize(array(array("file_name" => "import-task-libraries-sample.xlsx"))));
    }
    function save(){
        $id = $this->request->getPost('id');
        $data = array(
            "title" => $this->request->getPost('title'),
            "category" => $this->request->getPost('category'),
            "dock_list_number" => $this->request->getPost('dock_list_number'),
            "assigned_to" => $this->request->getPost('assigned_to'),
            "collaborators" => $this->request->getPost('collaborators'),
            "status_id" => $this->request->getPost('status_id'),
            "priority_id" => $this->request->getPost('priority_id'),
            "milestone_id" => $this->request->getPost('milestone_id'),
            "supplier" => $this->request->getPost('supplier'),
            "description" => $this->request->getPost('description'),
            "location" => $this->request->getPost('location'),
            "specification" => $this->request->getPost('specification'),
            "checklists" => $this->request->getPost('checklists')?$this->request->getPost('checklists'):"",
            "dependencies" => $this->request->getPost('dependencies')?$this->request->getPost('dependencies'):"",
        );
        $save_id = $this->Task_libraries_model->ci_save($data, $id);
        return redirect()->to("/task_libraries"."/view"."/".$save_id);
    }
    function view($id){
        $allStatus=$this->Task_status_model->get_all()->getResultArray();
        $allPriorities=$this->Task_priority_model->get_all()->getResultArray();
        $allMilestones=$this->Milestones_model->get_all()->getResultArray();
        $allTasklibraries=$this->Task_libraries_model->get_all()->getResultArray();
        $gotTasklibrary=$this->Task_libraries_model->get_one($id);
        return $this->template->rander('task_libraries/index',["gotTasklibrary"=>$gotTasklibrary,"allTasklibraries"=>$allTasklibraries,"allMilestones"=>$allMilestones,"allStatus"=>$allStatus,"allPriorities"=>$allPriorities]);
    }
    function validate_import_tasks_file() {
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
    function upload_excel_file() {
        upload_file_to_temp(true);
    }
    function validate_import_tasks_file_data($check_on_submit = false) {
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
                $headers = $this->_store_headers_position($value);

                foreach ($headers as $row_data) {
                    $has_error_class = false;
                    if (get_array_value($row_data, "has_error") && !$got_error_header) {
                        $has_error_class = true;
                        $got_error_header = true;

                        if (get_array_value($row_data, "custom_field")) {
                            $error_message = app_lang("no_such_custom_field_found");
                        } else {
                            $error_message = sprintf(app_lang("import_client_error_header"), app_lang(get_array_value($row_data, "key_value")));
                        }
                    }

                    array_push($table_data_header_array, array("has_error_class" => $has_error_class, "value" => get_array_value($row_data, "value")));
                }
            } else { //validate data
                if (!array_filter($value)) {
                    continue;
                }

                $error_message_on_this_row = "<ol class='pl15'>";
                $has_contact_first_name = get_array_value($value, 1) ? true : false;

                foreach ($value as $key => $row_data) {
                    $has_error_class = false;

                    if (!$got_error_header) {
                        $row_data_validation = $this->_row_data_validation_and_get_error_message($key, $row_data, $has_contact_first_name, $headers);
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
        // echo json_encode(array("success" => true, 'table_data' => $table_data, 'got_error' => ($got_error_header || $got_error_table_data) ? true : false));
    }
    private function _store_headers_position($headers_row = array()) {
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
            } else if (((count($allowed_headers) - 1) < $key) && $key_value) {
                //custom fields headers
                //check if there is any existing custom field with this title
                $existing_id = $this->_get_existing_custom_field_id(trim($header, " "));
                if ($existing_id) {
                    $header_array["custom_field_id"] = $existing_id;
                } else {
                    $header_array["has_error"] = true;
                    $header_array["custom_field"] = true;
                }
            } else { //invalid header, flag as red
                $header_array["has_error"] = true;
            }

            if ($key_value) {
                array_push($final_headers, $header_array);
            }
        }

        return $final_headers;
    }
    private function _get_allowed_headers() {
        return array(
            "title",
            "category",
            "dock_list_number",
            "reference_drawing",
            "description",
            "location",
            "specification",
            "requisition_number",
            "milestone",
            "assigned_to",
            "collaborators",
            "status",
            "priority",
            "start_date",
            "deadline",
            "budget",
            "gas_free_certificate",
            "light",
            "ventilation",
            "crane_assistance",
            "cleaning_before",
            "cleaning_after",
            "work_permit",
            "painting_after_completion",
            "parts_on_board",
            "transport_to_yard_workshop",
            "transport_outside_yard",
            "material_yards_supply",
            "material_owners_supply",
            "risk_assessment",
            "marker",
            "type",
            "serial_number",
            "pms_scs_number"
        );
    }
    private function _row_data_validation_and_get_error_message($key, $data, $headers = array()) {
        $allowed_headers = $this->_get_allowed_headers();
        $header_value = get_array_value($allowed_headers, $key);

        //required fields
        if (($header_value == "title" || $header_value == "status") && !$data) {
            return sprintf(app_lang("import_error_field_required"), app_lang($header_value));
        }

        //check dates
        // if (($header_value == "start_date" || $header_value == "end_date") && !$this->_check_valid_date($data)) {
        //     return app_lang("import_date_error_message");
        // }

        //existance required on this fields
        if ($data && (
                ($header_value == "status_id" && !$this->_get_status_id($data)) ||
                ($header_value == "status" && !$this->_get_status_id($data)) ||
                ($header_value == "priority" && !$this->_get_priority_id($data)) ||
                ($header_value == "milestone" && !$this->_get_milestone_id($data)) ||
                ($header_value == "assigned_to" && !$this->_get_assigned_to_id($data)) ||
                ($header_value == "collaborators" && !$this->_get_collaborators_ids($data))
                )) {
            if ($header_value == "assigned_to" || $header_value == "collaborators") {
                return sprintf(app_lang("import_not_exists_error_message"), app_lang("user"));
            } else {
                return sprintf(app_lang("import_not_exists_error_message"), app_lang($header_value));
            }
        }

        //there has no date field on default import fields
        //check on custom fields
        if (((count($allowed_headers) - 1) < $key) && $data) {
            $header_info = get_array_value($headers, $key);
            $custom_field_info = $this->Custom_fields_model->get_one(get_array_value($header_info, "custom_field_id"));
            if ($custom_field_info->field_type === "date" && !$this->_check_valid_date($data)) {
                return app_lang("import_date_error_message");
            }
        }
    }
    private function _get_status_id($status = "") {
        if (!$status) {
            return false;
        }

        $existing_status = $this->Task_status_model->get_one_where(array("title" => $status, "deleted" => 0));
        if ($existing_status->id) {
            //status exists, add the status id
            return $existing_status->id;
        } else {
            return false;
        }
    }
    private function _get_priority_id($priority = "") {
        if (!$priority) {
            return false;
        }

        $existing_milestone = $this->Task_priority_model->get_one_where(array("title" => $priority, "deleted" => 0));
        if ($existing_milestone->id) {
            //milestone exists, add the milestone id
            return $existing_milestone->id;
        } else {
            return false;
        }
    }
    function get_existing_dependency_tasks($task_id = 0) {
        if ($task_id) {
            validate_numeric_value($task_id);
            $model_info = $this->Task_libraries_model->get_details(array("id" => $task_id))->getRow();

            if (!$this->can_view_tasks("", 0, $model_info)) {
                app_redirect("forbidden");
            }

            $all_dependency_tasks = $this->_get_all_dependency_for_this_task($task_id);

            //add this task id
            if ($all_dependency_tasks) {
                $all_dependency_tasks .= "," . $task_id;
            } else {
                $all_dependency_tasks = $task_id;
            }

            //make tasks dropdown
            $options = array("exclude_task_ids" => $all_dependency_tasks);

            $context_id_pairs = $this->get_context_id_pairs();

            foreach ($context_id_pairs as $pair) {
                $id_key = get_array_value($pair, "id_key");
                $options[$id_key] = $model_info->$id_key;
            }


            $tasks_dropdown = array();
            $tasks = $this->Task_libraries_model->get_details($options)->getResult();
            foreach ($tasks as $task) {
                $tasks_dropdown[] = array("id" => $task->id, "text" => $task->id . " - " . $task->title);
            }

            echo json_encode(array("success" => true, "tasks_dropdown" => $tasks_dropdown));
        }
    }
    private function _get_existing_custom_field_id($title = "") {
        if (!$title) {
            return false;
        }

        $custom_field_data = array(
            "title" => $title,
            "related_to" => "tasks"
        );

        $existing = $this->Custom_fields_model->get_one_where(array_merge($custom_field_data, array("deleted" => 0)));
        if ($existing->id) {
            return $existing->id;
        }
    }
    function save_task_from_excel_file() {
        $this->access_only_team_members();
        if (!$this->can_create_tasks()) {
            app_redirect("forbidden");
        }

        // if (!$this->validate_import_tasks_file_data(true)) {
        //     echo json_encode(array('success' => false, 'message' => app_lang('error_occurred')));
        // }

        $file_name = $this->request->getPost('file_name');
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");

        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file = $excel_file->getActiveSheet()->toArray();
        $allowed_headers = $this->_get_allowed_headers();
        $now = get_current_utc_time();

        $sort = 100; //random value
        // $project_id = $this->request->getPost("project_id");
        foreach ($excel_file as $key => $value) { //rows
            if ($key === 0) { //first line is headers, modify this for custom fields and continue for the next loop
                $allowed_headers = $this->_prepare_headers_for_submit($value, $allowed_headers);
                continue;
            }

            $task_data_array = $this->_prepare_task_data($value, $allowed_headers);
            $task_data = get_array_value($task_data_array, "task_data");
            $custom_field_values_array = get_array_value($task_data_array, "custom_field_values_array");

            //couldn't prepare valid data
            if (!($task_data && count($task_data))) {
                continue;
            }

            // $task_data["sort"] = $sort;
            // $task_data["project_id"] = $project_id;

            //save task data
            $task_save_id = $this->Task_libraries_model->ci_save($task_data);
            // $sort = $task_save_id;

            if (!$task_save_id) {
                continue;
            }

            //save custom fields
            $this->_save_custom_fields_of_task($task_save_id, $custom_field_values_array);
        }

        delete_file_from_directory($temp_file_path . $file_name); //delete temp file

        echo json_encode(array('success' => true, 'message' => app_lang("record_saved")));
    }
    private function _prepare_headers_for_submit($headers_row, $headers) {
        foreach ($headers_row as $key => $header) {
            if (!((count($headers) - 1) < $key)) { //skip default headers
                continue;
            }

            //so, it's a custom field
            //check if there is any custom field existing with the title
            //add id like cf-3
            $existing_id = $this->_get_existing_custom_field_id($header);
            if ($existing_id) {
                array_push($headers, "cf-$existing_id");
            }
        }

        return $headers;
    }
    private function _prepare_task_data($data_row, $allowed_headers) {
        //prepare task data
        $task_data = array();
        $custom_field_values_array = array();
        foreach ($data_row as $row_data_key => $row_data_value) { //row values
            if (!$row_data_value) {
                continue;
            }
            $header_key_value = get_array_value($allowed_headers, $row_data_key);
            if (strpos($header_key_value, 'cf') !== false) { //custom field
                $explode_header_key_value = explode("-", $header_key_value);
                $custom_field_id = get_array_value($explode_header_key_value, 1);

                //modify date value
                $custom_field_info = $this->Custom_fields_model->get_one($custom_field_id);
                if ($custom_field_info->field_type === "date") {
                    $row_data_value = $this->_check_valid_date($row_data_value);
                }

                $custom_field_values_array[$custom_field_id] = $row_data_value;
            } 
            else if ($header_key_value == "project") {
                $task_data["project_id"] = $this->_get_project_id($row_data_value);
            } 
            else if ($header_key_value == "points") {
                $task_data["points"] = $this->_check_task_points($row_data_value);
            } else if ($header_key_value == "milestone") {
                $task_data["milestone_id"] = $this->_get_milestone_id($row_data_value);
            } else if ($header_key_value == "assigned_to") {
                $task_data["assigned_to"] = $this->_get_assigned_to_id($row_data_value);
            } else if ($header_key_value == "collaborators") {
                $task_data["collaborators"] = $this->_get_collaborators_ids($row_data_value);
            } else if ($header_key_value == "status") {
                $task_data["status_id"] = $this->_get_status_id($row_data_value);
            } else if ($header_key_value == "priority") {
                $task_data["priority_id"] = $this->_get_priority_id($row_data_value);
            } else if ($header_key_value == "category") {
                $task_data["category"] = $row_data_value;
            } else if ($header_key_value == "start_date") {
                $task_data["start_date"] = $this->_check_valid_date($row_data_value);
            } else if ($header_key_value == "deadline") {
                $task_data["deadline"] = $this->_check_valid_date($row_data_value);
            } else {
                $task_data[$header_key_value] = $row_data_value;
            }
        }

        return array(
            "task_data" => $task_data,
            "custom_field_values_array" => $custom_field_values_array
        );
    }
    private function _get_label_ids($labels = "") {
        $explode_labels = explode(", ", $labels);
        if (!($explode_labels && count($explode_labels))) {
            return false;
        }

        $labels_ids = "";

        foreach ($explode_labels as $label) {
            $label = trim($label);
            $labels_id = "";

            $existing_label = $this->Labels_model->get_one_where(array("title" => $label, "context" => "task", "deleted" => 0));
            if ($existing_label->id) {
                //existing label, add the labels id
                $labels_id = $existing_label->id;
            } else {
                //not exists, create new
                $label_data = array("title" => $label, "context" => "task", "color" => "#83c340");
                $labels_id = $this->Labels_model->ci_save($label_data);
            }

            if ($labels_ids) {
                $labels_ids .= ",";
            }
            $labels_ids .= $labels_id;
        }

        return $labels_ids;
    }
    private function _save_custom_fields_of_task($task_id, $custom_field_values_array) {
        if (!$custom_field_values_array) {
            return false;
        }

        foreach ($custom_field_values_array as $key => $custom_field_value) {
            $field_value_data = array(
                "related_to_type" => "tasks",
                "related_to_id" => $task_id,
                "custom_field_id" => $key,
                "value" => $custom_field_value
            );

            $field_value_data = clean_data($field_value_data);

            $this->Custom_field_values_model->ci_save($field_value_data);
        }
    }

}