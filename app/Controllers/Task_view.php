<?php

namespace App\Controllers;

class Task_view extends App_Controller {

    protected $Checklist_items_model;

    function __construct() {
        parent::__construct();

        $this->Checklist_items_model = model('App\Models\Checklist_items_model');
    }

    function index($task_id=0) {
        validate_numeric_value($task_id);
        $model_info = $this->Tasks_model->get_details(array("id" => $task_id))->getRow();
        if (!$model_info->id) {
            show_404();
        }

        $view_data["model_info"] = $model_info;
        $view_data["can_edit_tasks"] = false;
        $view_data['labels'] = make_labels_view_data($model_info->labels_list);
        $view_data['collaborators'] = $this->_get_collaborators($model_info->collaborator_list, false);

        $options = array("task_id" => $task_id);
        $view_data['comments'] = $this->Project_comments_model->get_details($options)->getResult();
        $view_data['task_id'] = $task_id;

        //get checklist items
        $checklist_items_array = array();
        $checklist_items = $this->Checklist_items_model->get_details(array("task_id" => $task_id))->getResult();
        foreach ($checklist_items as $checklist_item) {
            $checklist_items_array[] = $this->_make_checklist_item_row($checklist_item);
        }
        $view_data["checklist_items"] = json_encode($checklist_items_array);

         //get sub tasks
         $sub_tasks_array = array();
         $sub_tasks = $this->Tasks_model->get_details(array("parent_task_id" => $task_id))->getResult();
         foreach ($sub_tasks as $sub_task) {
             $sub_tasks_array[] = $this->_make_sub_task_row($sub_task);
         }
         $view_data["sub_tasks"] = json_encode($sub_tasks_array);
         $view_data["total_sub_tasks"] = $this->Tasks_model->count_sub_task_status(array("parent_task_id" => $task_id));
         $view_data["completed_sub_tasks"] = $this->Tasks_model->count_sub_task_status(array("parent_task_id" => $task_id, "status_id" => 3));

         $view_data['parent_task_title'] = $this->Tasks_model->get_one($model_info->parent_task_id)->title;

         $view_data["project_deadline"] = $this->_get_project_deadline_for_task($model_info->project_id);

        return $this->template->view('task_view/index', $view_data);
    }

    private function _make_checklist_item_row($data) {
        $checkbox_class = "checkbox-blank";
        $title_class = "";
        $title_value = link_it($data->title);

        if ($data->is_checked == 1) {
            $checkbox_class = "checkbox-checked";
            $title_class = "text-line-through text-off";
            $title_value = $data->title;
        }

        $status = "<span class='$checkbox_class mr15 float-start'></span>";
        $title = "<span class='font-13 $title_class'>" . $title_value . "</span>";

        return "<div id='checklist-item-row-$data->id' class='list-group-item mb5 checklist-item-row b-a rounded text-break' data-id='$data->id'>" . $status . $title . "</div>";
    }

    private function _make_sub_task_row($data, $return_type = "row") {
        $checkbox_class = "checkbox-blank";

        if ($data->status_key_name == "done") {
            $checkbox_class = "checkbox-checked";
        }

        $status = "<span class='$checkbox_class mr15 float-start'></span>";
        $title = anchor(get_uri("task_view/index/$data->id"), $data->title, array("class" => "font-13", "target" => "_blank"));
        $status_label = "<span class='float-end'><span class='badge mt0' style='background: $data->status_color;'>" . ($data->status_key_name ? app_lang($data->status_key_name) : $data->status_title) . "</span></span>";

        if ($return_type == "data") {
            return $status . $title . $status_label;
        }

        return "<div class='list-group-item mb5 b-a rounded sub-task-row' data-id='$data->id'>" . $status . $title . $status_label . "</div>";
    }

    private function _get_project_deadline_for_task($project_id) {
        $project_deadline_date = "";
        $project_deadline = $this->Projects_model->get_one($project_id)->deadline;
        if (get_setting("task_deadline_should_be_before_project_deadline") && is_date_exists($project_deadline)) {
            $project_deadline_date = format_to_date($project_deadline, false);
        }

        return $project_deadline_date;
    }

    private function _get_collaborators($collaborator_list) {
        $collaborators = "";
        if ($collaborator_list) {

            $collaborators_array = explode(",", $collaborator_list);
            foreach ($collaborators_array as $collaborator) {
                $collaborator_parts = explode("--::--", $collaborator);

                $collaborator_name = get_array_value($collaborator_parts, 1);

                $image_url = get_avatar(get_array_value($collaborator_parts, 2));

                $collaboratr_image = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span>";

                $collaborators .= "<span title='$collaborator_name'>$collaboratr_image</span>";
            }
        }
        return $collaborators;
    }
}