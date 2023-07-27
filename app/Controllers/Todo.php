<?php

namespace App\Controllers;

class Todo extends Security_Controller {

    protected $Checklist_items_model;
    protected $Task_priority_model;

    function __construct() {
        parent::__construct();

        $this->Checklist_items_model = model('App\Models\Checklist_items_model');
        $this->Task_priority_model = model("App\Models\Task_priority_model");
    }

    protected function validate_access($todo_info) {
        if ($this->login_user->id !== $todo_info->created_by) {
            app_redirect("forbidden");
        }
    }

    //load todo list view
    function index() {
        $this->check_module_availability("module_todo");

        $view_data["vessels_dropdown"] = $this->get_vessels_dropdown(true);
        $view_data["priorities_dropdown"] = $this->_get_priorities_dropdown_list(true);
        return $this->template->rander("todo/index", $view_data);
    }

    // load todo kanban view
    function kanban() {
        return $this->template->rander("todo/kanban/index");
    }

    function modal_form() {
        $view_data['model_info'] = $this->Todo_model->get_one($this->request->getPost('id'));

        //check permission for saved todo list
        if ($view_data['model_info']->id) {
            $this->validate_access($view_data['model_info']);

            //get checklist items
            $checklist_items_array = array();
            $checklist_items = $this->Checklist_items_model->get_details(array("todo_id" => $view_data['model_info']->id))->getResult();
            foreach ($checklist_items as $checklist_item) {
                $checklist_items_array[] = $this->_make_checklist_item_row($checklist_item);
            }
            $view_data["checklist_items"] = json_encode($checklist_items_array);
            $view_data['has_checklist'] = count($checklist_items);
        } else {
            $view_data["checklist_items"] = json_encode(array());
            $view_data['has_checklist'] = 0;
        }

        $view_data['label_column'] = 'col-md-3';
        $view_data['field_column'] = 'col-md-9';
        $view_data['vessels_dropdown'] = $this->get_vessels_dropdown();
        $view_data['priorities_dropdown'] = $this->_get_priorities_dropdown_list();
        $view_data['status_dropdown'] = $this->get_todo_status_dropdown();
        $view_data['label_suggestions'] = $this->make_labels_dropdown("to_do", $view_data['model_info']->labels);
        return $this->template->view('todo/modal_form', $view_data);
    }

    function save() {
        $this->validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required",
            "client_id" => "required"
        ));

        $id = $this->request->getPost('id');

        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description') ? $this->request->getPost('description') : "",
            "client_id" => $this->request->getPost('client_id'),
            "status" => $this->request->getPost('status'),
            "priority_id" => $this->request->getPost('priority_id'),
            "created_by" => $this->login_user->id,
            "labels" => $this->request->getPost('labels') ? $this->request->getPost('labels') : "",
            "start_date" => $this->request->getPost('start_date'),
            "deadline" => $this->request->getPost('deadline'),
        );

        $data = clean_data($data);

        //set null value after cleaning the data
        if (!$data["start_date"]) {
            $data["start_date"] = NULL;
        }
        if (!$data["deadline"]) {
            $data["deadline"] = NULL;
        }

        if ($id) {
            //saving existing todo. check permission
            $todo_info = $this->Todo_model->get_one($id);

            $this->validate_access($todo_info);
        } else {
            $data['created_at'] = get_current_utc_time();
        }

        $save_id = $this->Todo_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* upadate a task status */

    function save_status() {

        $this->validate_submitted_data(array(
            "id" => "numeric|required",
            "status" => "required"
        ));

        $todo_info = $this->Todo_model->get_one($this->request->getPost('id'));
        $this->validate_access($todo_info);

        $data = array(
            "status" => $this->request->getPost('status')
        );

        $save_id = $this->Todo_model->ci_save($data, $this->request->getPost('id'));

        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, "message" => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, app_lang('error_occurred')));
        }
    }

    function delete() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        $todo_info = $this->Todo_model->get_one($id);
        $this->validate_access($todo_info);

        if ($this->request->getPost('undo')) {
            if ($this->Todo_model->delete_todo_and_sub_items($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Todo_model->delete_todo_and_sub_items($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    function list_data() {

        $status = $this->request->getPost('status') ? implode(",", $this->request->getPost('status')) : "";
        $options = array(
            "created_by" => $this->login_user->id,
            "status" => $status,
            "client_id" => $this->request->getPost("client_id"),
            "priority_id" => $this->request->getPost("priority_id")
        );

        $list_data = $this->Todo_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Todo_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    private function _make_row($data) {
        $title = modal_anchor(get_uri("todo/view/" . $data->id), $data->title, array("class" => "edit", "title" => app_lang('todo'), "data-post-id" => $data->id));

        $todo_labels = "";
        $todo_checklist_status = "";
        $checklist_label_color = "#6690F4";

        if ($data->total_checklist_checked <= 0) {
            $checklist_label_color = "#E18A00";
        } else if ($data->total_checklist_checked == $data->total_checklist) {
            $checklist_label_color = "#01B392";
        }

        if ($data->total_checklist) {
            $todo_checklist_status .= "<div class='meta float-start badge rounded-pill mr5' style='background-color:$checklist_label_color'><span data-bs-toggle='tooltip' title='" . app_lang("checklist_status") . "'><i data-feather='check' class='icon-14'></i> $data->total_checklist_checked/$data->total_checklist</span></div>";
        }

        $labels_data = make_labels_view_data($data->labels_list, true);
        if ($labels_data) {
            $todo_labels .= "<div class='meta float-start mt5 mr5'>$labels_data</div>";
        }
        $title .= "<span class='float-end'>" . $todo_labels . $todo_checklist_status . "</span>";


        $status_class = "";
        $checkbox_class = "checkbox-blank";
        if ($data->status === "to_do") {
            $status_class = "b-warning";
        } else {
            $checkbox_class = "checkbox-checked";
            $status_class = "b-success";
        }

        $check_status = js_anchor("<span class='$checkbox_class float-start'></span>", array('title' => "", "class" => "", "data-id" => $data->id, "data-value" => $data->status === "done" ? "to_do" : "done", "data-act" => "update-todo-status-checkbox"));

        $start_date_text = "";
        if (is_date_exists($data->start_date)) {
            $start_date_text = format_to_date($data->start_date, false);
            if (get_my_local_time("Y-m-d") > $data->start_date && $data->status != "done") {
                $start_date_text = "<span class='text-danger'>" . $start_date_text . "</span> ";
            } else if (get_my_local_time("Y-m-d") == $data->start_date && $data->status != "done") {
                $start_date_text = "<span class='text-warning'>" . $start_date_text . "</span> ";
            }
        }

        $deadline_text = "";
        if (is_date_exists($data->deadline)) {
            $deadline_text = format_to_date($data->deadline, false);
            if (get_my_local_time("Y-m-d") > $data->deadline && $data->status != "done") {
                $deadline_text = "<span class='text-danger'>" . $deadline_text . "</span> ";
            } else if (get_my_local_time("Y-m-d") == $data->deadline && $data->status != "done") {
                $deadline_text = "<span class='text-warning'>" . $deadline_text . "</span> ";
            }
        }

        $priority = "";
        if ($data->priority_id) {
            $priority = "<span title='" . app_lang('priority') . "'>
                            <span class='sub-task-icon priority-badge' style='background: $data->priority_color'><i data-feather='$data->priority_icon' class='icon-14'></i></span><span class='small'> $data->priority_title</span>
                      </span>";
        }

        return array(
            $status_class,
            "<i class='hide'>" . $data->id . "</i>" . $check_status,
            $title,
            $data->vessel,
            $priority,
            $data->start_date,
            $start_date_text,
            $data->deadline,
            $deadline_text,
            modal_anchor(get_uri("todo/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit'), "data-post-id" => $data->id))
            . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("todo/delete"), "data-action" => "delete"))
        );
    }

    function kanban_data() {
        $options = array("created_by" => $this->login_user->id);
        $view_data["data"] = $this->Todo_model->get_kanban_details($options)->getResult();

        $statuses = $this->Todo_status_model->get_details(array("hide_from_kanban" => 0));

        $view_data["total_columns"] = $statuses->resultID->num_rows;
        $view_data["columns"] = $statuses->getResult();

        return $this->template->view('todo/kanban/kanban_view', $view_data);
    }

    function save_todo_sort_and_status() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        $todo_info = $this->Todo_model->get_one($id);
        $this->validate_access($todo_info);

        $data = array(
            "sort" => $this->request->getPost('sort')
        );

        $status = $this->request->getPost('status');
        if ($status) {
            $data["status"] = $status;
        }

        $save_id = $this->Todo_model->ci_save($data, $id);

        if ($save_id) {
            echo json_encode(array("success" => true, "message" => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, app_lang('error_occurred')));
        }
    }

    function view() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $model_info = $this->Todo_model->get_details(array("id" => $this->request->getPost('id')))->getRow();

        $this->validate_access($model_info);

        $view_data['model_info'] = $model_info;
        return $this->template->view('todo/view', $view_data);
    }

    private function _make_checklist_item_row($data, $return_type = "row") {
        $checkbox_class = "checkbox-blank";
        $title_class = "";
        $is_checked_value = 1;
        $title_value = link_it($data->title);

        if ($data->is_checked == 1) {
            $is_checked_value = 0;
            $checkbox_class = "checkbox-checked";
            $title_class = "text-line-through text-off";
            $title_value = $data->title;
        }

        $status = js_anchor("<span class='$checkbox_class mr15 float-start'></span>", array('title' => "", "data-id" => $data->id, "data-value" => $is_checked_value, "data-act" => "update-checklist-item-status-checkbox"));
        if (!$this->can_edit_tasks()) {
            $status = "";
        }

        $title = "<span class='font-13 $title_class'>" . $title_value . "</span>";

        $delete = ajax_anchor(get_uri("todo/delete_checklist_item/$data->id"), "<div class='float-end'><i data-feather='x' class='icon-16'></i></div>", array("class" => "delete-checklist-item", "title" => app_lang("delete_checklist_item"), "data-fade-out-on-success" => "#checklist-item-row-$data->id"));
        if (!$this->can_edit_tasks()) {
            $delete = "";
        }

        if ($return_type == "data") {
            return $status . $delete . $title;
        }

        return "<div id='checklist-item-row-$data->id' class='list-group-item mb5 checklist-item-row b-a rounded text-break' data-id='$data->id'>" . $status . $delete . $title . "</div>";
    }

    function save_checklist_item() {
        $todo_id = $this->request->getPost("todo_id");
        $is_checklist_group = $this->request->getPost("is_checklist_group");

        $this->validate_submitted_data(array(
            "todo_id" => "required|numeric"
        ));

        $todo_info = $this->Todo_model->get_details(array("id" => $todo_id))->getRow();
        $this->validate_access($todo_info);

        $success_data = "";
        if ($is_checklist_group) {
            $checklist_group_id = $this->request->getPost("checklist-add-item");
            $checklists = $this->Checklist_template_model->get_details(array("group_id" => $checklist_group_id))->getResult();
            foreach ($checklists as $checklist) {
                $data = array(
                    "todo_id" => $todo_id,
                    "title" => $checklist->title
                );
                $save_id = $this->Checklist_items_model->ci_save($data);
                if ($save_id) {
                    $item_info = $this->Checklist_items_model->get_one($save_id);
                    $success_data .= $this->_make_checklist_item_row($item_info);
                }
            }
        } else {
            $data = array(
                "todo_id" => $todo_id,
                "title" => $this->request->getPost("checklist-add-item")
            );
            $save_id = $this->Checklist_items_model->ci_save($data);
            if ($save_id) {
                $item_info = $this->Checklist_items_model->get_one($save_id);
                $success_data = $this->_make_checklist_item_row($item_info);
            }
        }

        if ($success_data) {
            echo json_encode(array("success" => true, "data" => $success_data, 'id' => $save_id));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    function save_checklist_item_status($id = 0) {
        $todo_id = $this->Checklist_items_model->get_one($id)->todo_id;

        $todo_info = $this->Todo_model->get_details(array("id" => $todo_id))->getRow();
        $this->validate_access($todo_info);

        $data = array(
            "is_checked" => $this->request->getPost('value')
        );

        $save_id = $this->Checklist_items_model->ci_save($data, $id);

        if ($save_id) {
            $item_info = $this->Checklist_items_model->get_one($save_id);
            echo json_encode(array("success" => true, "data" => $this->_make_checklist_item_row($item_info, "data"), 'id' => $save_id));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    function save_checklist_items_sort() {
        $sort_values = $this->request->getPost("sort_values");
        if ($sort_values) {
            //extract the values from the comma separated string
            $sort_array = explode(",", $sort_values);

            //update the value in db
            foreach ($sort_array as $value) {
                $sort_item = explode("-", $value); //extract id and sort value

                $id = get_array_value($sort_item, 0);
                $sort = get_array_value($sort_item, 1);

                validate_numeric_value($id);

                $data = array("sort" => $sort);
                $this->Checklist_items_model->ci_save($data, $id);
            }
        }
    }

    function delete_checklist_item($id) {
        $todo_id = $this->Checklist_items_model->get_one($id)->todo_id;
        $todo_info = $this->Todo_model->get_details(array("id" => $todo_id))->getRow();
        $this->validate_access($todo_info);

        if ($this->Checklist_items_model->delete($id)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    private function _get_priorities_dropdown_list($show_header = false) {
        $priorities = $this->Task_priority_model->get_details()->getResult();
        $priorities_dropdown = array();
        if ($show_header) {
            $priorities_dropdown[] = array("id" => "", "text" => "- " . app_lang("priority") . " -");
        }

        //if there is any specific priority selected, select only the priority.
        $selected_status = false;
        foreach ($priorities as $priority) {
            $priorities_dropdown[] = array("id" => $priority->id, "text" => $priority->title, "isSelected" => $selected_status);
        }
        return json_encode($priorities_dropdown);
    }

}

/* End of file todo.php */
/* Location: ./app/controllers/todo.php */