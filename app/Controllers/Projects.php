<?php

namespace App\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options;


class Projects extends Security_Controller {

    protected $Project_settings_model;
    protected $Checklist_items_model;
    protected $Likes_model;
    protected $Pin_comments_model;
    protected $File_category_model;
    protected $Task_priority_model;

    public function __construct() {
        parent::__construct();
        if ($this->has_all_projects_restricted_role()) {
            app_redirect("forbidden");
        }

        $this->Project_settings_model = model('App\Models\Project_settings_model');
        $this->Checklist_items_model = model('App\Models\Checklist_items_model');
        $this->Likes_model = model('App\Models\Likes_model');
        $this->Tasks_model = model('App\Models\Tasks_model');
        $this->Pin_comments_model = model('App\Models\Pin_comments_model');
        $this->File_category_model = model('App\Models\File_category_model');
        $this->Task_priority_model = model("App\Models\Task_priority_model");
        $this->Project_yards_model = model("App\Models\Project_yards_model");
        $this->Shipyard_cost_items_model = model("App\Models\Shipyard_cost_items_model");
        $this->Task_cost_items_model = model("App\Models\Task_cost_items_model");
        $this->Task_variation_orders_model = model("App\Models\Task_variation_orders_model");
        $this->Task_owner_supplies_model = model("App\Models\Task_owner_supplies_model");
        $this->Project_currency_rates_model = model("App\Models\Project_currency_rates_model");
        $this->Task_comments_model = model("App\Models\Task_comments_model");
        $this->Clients_model = model('App\Models\Clients_model');
        $this->Vessel_types_model=model('App\Models\Vessel_types_model');
        $this->Report_documents_model=model('App\Models\Report_documents_model');
        $this->Report_templates_model=model('App\Models\Report_templates_model');
        $this->Projects_model->auto_update();

    }

    private function can_delete_projects($project_id = 0) {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            }

            $can_delete_projects = get_array_value($this->login_user->permissions, "can_delete_projects");
            $can_delete_only_own_created_projects = get_array_value($this->login_user->permissions, "can_delete_only_own_created_projects");

            if ($can_delete_projects) {
                return true;
            }

            if ($project_id) {
                $project_info = $this->Projects_model->get_one($project_id);
                if ($can_delete_only_own_created_projects && $project_info->created_by === $this->login_user->id) {
                    return true;
                }
            } else if ($can_delete_only_own_created_projects) { //no project given and the user has partial access
                return true;
            }
        }
    }

    private function can_add_remove_project_members() {
        if ($this->login_user->user_type == "staff") {
            if ($this->login_user->is_admin) {
                return true;
            } else {
                if (get_array_value($this->login_user->permissions, "show_assigned_tasks_only") !== "1") {
                    if ($this->can_manage_all_projects()) {
                        return true;
                    } else if (get_array_value($this->login_user->permissions, "can_add_remove_project_members") == "1") {
                        return true;
                    }
                }
            }
        }
    }

    private function can_create_milestones() {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            } else if (get_array_value($this->login_user->permissions, "can_create_milestones") == "1") {
                //check is user a project member
                return $this->is_user_a_project_member;
            }
        }
    }

    private function can_edit_milestones() {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            } else if (get_array_value($this->login_user->permissions, "can_edit_milestones") == "1") {
                //check is user a project member
                return $this->is_user_a_project_member;
            }
        }
    }

    private function can_delete_milestones() {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            } else if (get_array_value($this->login_user->permissions, "can_delete_milestones") == "1") {
                //check is user a project member
                return $this->is_user_a_project_member;
            }
        }
    }

    private function can_delete_files($uploaded_by = 0) {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            } else if (get_array_value($this->login_user->permissions, "can_delete_files") == "1") {
                //check is user a project member
                return $this->is_user_a_project_member;
            }
        } else {
            if (get_setting("client_can_delete_own_files_in_project") && $this->login_user->id == $uploaded_by) {
                return true;
            }
        }
    }

    private function can_view_files() {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            } else {
                //check is user a project member
                return $this->is_user_a_project_member;
            }
        } else {
            //check settings for client's project permission
            if (get_setting("client_can_view_project_files")) {
                return $this->is_clients_project;
            }
        }
    }

    private function can_add_files() {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            } else {
                //check is user a project member
                return $this->is_user_a_project_member;
            }
        } else {
            //check settings for client's project permission
            if (get_setting("client_can_add_project_files")) {
                return $this->is_clients_project;
            }
        }
    }

    private function can_comment_on_files() {
        if ($this->login_user->user_type == "staff") {
            if ($this->can_manage_all_projects()) {
                return true;
            } else {
                //check is user a project member
                return $this->is_user_a_project_member;
            }
        } else {
            //check settings for client's project permission
            if (get_setting("client_can_comment_on_files")) {
                //even the settings allow to create/edit task, the client can only comment on their own project's files
                return $this->is_clients_project;
            }
        }
    }

    private function can_view_gantt() {
        //check gantt module
        if (get_setting("module_gantt")) {
            if ($this->login_user->user_type == "staff") {
                if ($this->can_manage_all_projects()) {
                    return true;
                } else {
                    //check is user a project member
                    return $this->is_user_a_project_member;
                }
            } else {
                //check settings for client's project permission
                if (get_setting("client_can_view_gantt")) {
                    //even the settings allow to view gantt, the client can only view on their own project's gantt
                    return $this->is_clients_project;
                }
            }
        }
    }

    /* load project view */

    function index() {
        app_redirect("projects/all_projects");
    }

    function all_projects($status_id = 0) {
        validate_numeric_value($status_id);
        $view_data['project_labels_dropdown'] = json_encode($this->make_labels_dropdown("project", "", true));

        $view_data["can_create_projects"] = $this->can_create_projects();

        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("projects", $this->login_user->is_admin, $this->login_user->user_type);
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("projects", $this->login_user->is_admin, $this->login_user->user_type);

        $view_data["selected_status_id"] = $status_id;
        $view_data['project_statuses'] = $this->Project_status_model->get_details()->getResult();

        if ($this->login_user->user_type === "staff") {
            $view_data["can_edit_projects"] = $this->can_edit_projects();
            $view_data["can_delete_projects"] = $this->can_delete_projects();

            return $this->template->rander("projects/index", $view_data);
        } else {
            $view_data['client_id'] = $this->login_user->client_id;
            $view_data['page_type'] = "full";
            return $this->template->rander("clients/projects/index", $view_data);
        }
    }

    /* load project  add/edit modal */

    function modal_form() {
        $project_id = $this->request->getPost('id');
        $client_id = $this->request->getPost('client_id');

        if ($project_id) {
            if (!$this->can_edit_projects($project_id)) {
                app_redirect("forbidden");
            }
        } else {
            if (!$this->can_create_projects()) {
                app_redirect("forbidden");
            }
        }


        $view_data["client_id"] = $client_id;
        $view_data['model_info'] = $this->Projects_model->get_one($project_id);
        if ($client_id) {
            $view_data['model_info']->client_id = $client_id;
        }

        //check if it's from estimate. if so, then prepare for project
        $estimate_id = $this->request->getPost('estimate_id');
        if ($estimate_id) {
            $view_data['model_info']->estimate_id = $estimate_id;
        }

        //check if it's from order. If so, then prepare for project
        $order_id = $this->request->getPost('order_id');
        if ($order_id) {
            $view_data['model_info']->order_id = $order_id;
        }

        $view_data["custom_fields"] = $this->Custom_fields_model->get_combined_details("projects", $view_data['model_info']->id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();

        $view_data['hide_clients_dropdown'] = false;

        if (!$this->login_user->is_admin && !get_array_value($this->login_user->permissions, "client") && !get_array_value($this->login_user->permissions, "client_specific")) {
            //user can't access clients. don't show clients dropdown
            $view_data['clients_dropdown'] = array();
            $view_data['hide_clients_dropdown'] = true;
        } else {
            $view_data['clients_dropdown'] = $this->_get_clients_dropdown_with_permission();
        }

        $view_data['label_suggestions'] = $this->make_labels_dropdown("project", $view_data['model_info']->labels);
        $view_data['statuses'] = $this->Project_status_model->get_details()->getResult();
        $view_data["can_edit_projects"] = $this->can_edit_projects();
        /////////////////////////////
        $view_data['categories']=$this->Labels_model->get_details(array("context"=>"project"))->getResult();
        /////////////////////////////

        return $this->template->view('projects/modal_form', $view_data);
    }

    //get clients dropdown
    private function _get_clients_dropdown_with_permission() {
        $clients_dropdown = array();

        if ($this->login_user->is_admin || get_array_value($this->login_user->permissions, "client")) {
            $access_client = $this->get_access_info("client");
            $clients = $this->Clients_model->get_details(array("show_own_clients_only_user_id" => $this->show_own_clients_only_user_id(), "client_groups" => $access_client->allowed_client_groups))->getResult();
            foreach ($clients as $client) {
                $clients_dropdown[$client->id] = $client->charter_name;
            }
        }

        return $clients_dropdown;
    }

    /* insert or update a project */

    function save() {

        $id = $this->request->getPost('id');

        if ($id) {
            if (!$this->can_edit_projects($id)) {
                app_redirect("forbidden");
            }
        } else {
            if (!$this->can_create_projects()) {
                app_redirect("forbidden");
            }
        }

        $this->validate_submitted_data(array(
            "title" => "required"
        ));

        $estimate_id = $this->request->getPost('estimate_id');
        $status_id = $this->request->getPost('status_id');
        $order_id = $this->request->getPost('order_id');
        $project_type = $this->request->getPost('project_type');

        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description'),
            "client_id" => ($project_type === "internal_project") ? 0 : $this->request->getPost('client_id'),
            "start_date" => $this->request->getPost('start_date'),
            "deadline" => $this->request->getPost('deadline'),
            "project_type" => $project_type,
            "price" => unformat_currency($this->request->getPost('price')),
            "labels" => $this->request->getPost('category'),
            "status_id" => $status_id ? $status_id : 1,
            "estimate_id" => $estimate_id,
            "order_id" => $order_id,
            "category"=>$this->request->getPost('category'),
            "currency"=>$this->request->getPost('currency'),
        );
        $now = get_my_local_time("Y-m-d");
        if(strtotime($now)<strtotime($data['deadline'])) $data['status_id']=1;
        

        if (!$id) {
            $data["created_date"] = get_current_utc_time();
            $data["created_by"] = $this->login_user->id;
        }


        //created by client? overwrite the client id for safety
        if ($this->login_user->user_type === "clinet") {
            $data["client_id"] = $this->login_user->client_id;
        }


        $data = clean_data($data);

        //set null value after cleaning the data
        if (!$data["start_date"]) {
            $data["start_date"] = NULL;
        }

        if (!$data["deadline"]) {
            $data["deadline"] = NULL;
        }

        $save_id = $this->Projects_model->ci_save($data, $id);
        if ($save_id) {

            save_custom_fields("projects", $save_id, $this->login_user->is_admin, $this->login_user->user_type);

            //send notification
            if ($status_id == 2) {
                log_notification("project_completed", array("project_id" => $save_id));
            }

            if (!$id) {

                if ($this->login_user->user_type === "staff") {
                    //this is a new project and created by team members
                    //add default project member after project creation
                    $data = array(
                        "project_id" => $save_id,
                        "user_id" => $this->login_user->id,
                        "is_leader" => 1
                    );
                    $this->Project_members_model->save_member($data);
                }

                //created from estimate? save the project id
                if ($estimate_id) {
                    $data = array("project_id" => $save_id);
                    $this->Estimates_model->ci_save($data, $estimate_id);
                }

                //created from order? save the project id
                if ($order_id) {
                    $data = array("project_id" => $save_id);
                    $this->Orders_model->ci_save($data, $order_id);
                }

                log_notification("project_created", array("project_id" => $save_id));
            }
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* Show a modal to clone a project */

    function clone_project_modal_form() {

        $project_id = $this->request->getPost('id');

        if (!$this->can_create_projects()) {
            app_redirect("forbidden");
        }


        $view_data['model_info'] = $this->Projects_model->get_one($project_id);

        $view_data['clients_dropdown'] = $this->Clients_model->get_dropdown_list(array("charter_name"), "id", array("is_lead" => 0));

        $view_data['label_suggestions'] = $this->make_labels_dropdown("project", $view_data['model_info']->labels);

        $view_data["custom_fields"] = $this->Custom_fields_model->get_combined_details("projects", $view_data['model_info']->id, 1, "staff")->getResult(); //we have to keep this regarding as an admin user because non-admin user also can acquire the access to clone a project

        return $this->template->view('projects/clone_project_modal_form', $view_data);
    }

    /* create a new project from another project */

    function save_cloned_project() {

        ini_set('max_execution_time', 300); //300 seconds 

        $project_id = $this->request->getPost('project_id');
        $project_start_date = $this->request->getPost('start_date');

        if (!$this->can_create_projects()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "title" => "required"
        ));

        $copy_same_assignee_and_collaborators = $this->request->getPost("copy_same_assignee_and_collaborators");
        $copy_milestones = $this->request->getPost("copy_milestones");
        $change_the_milestone_dates_based_on_project_start_date = $this->request->getPost("change_the_milestone_dates_based_on_project_start_date");
        $move_all_tasks_to_to_do = $this->request->getPost("move_all_tasks_to_to_do");
        $copy_tasks_start_date_and_deadline = $this->request->getPost("copy_tasks_start_date_and_deadline");
        $change_the_tasks_start_date_and_deadline_based_on_project_start_date = $this->request->getPost("change_the_tasks_start_date_and_deadline_based_on_project_start_date");
        $project_type = $this->request->getPost('project_type');

        //prepare new project data
        $now = get_current_utc_time();
        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description'),
            "client_id" => ($project_type === "internal_project") ? 0 : $this->request->getPost('client_id'),
            "start_date" => $project_start_date,
            "deadline" => $this->request->getPost('deadline'),
            "project_type" => $project_type,
            "price" => unformat_currency($this->request->getPost('price')),
            "created_date" => $now,
            "created_by" => $this->login_user->id,
            "labels" => $this->request->getPost('labels'),
            "status_id" => 1,
        );

        if (!$data["start_date"]) {
            $data["start_date"] = NULL;
        }

        if (!$data["deadline"]) {
            $data["deadline"] = NULL;
        }


        //add new project
        $new_project_id = $this->Projects_model->ci_save($data);

        //old project info
        $old_project_info = $this->Projects_model->get_one($project_id);

        //add milestones
        //when the new milestones will be created the ids will be different. so, we have to convert the milestone ids. 
        $milestones_array = array();

        if ($copy_milestones) {
            $milestones = $this->Milestones_model->get_all_where(array("project_id" => $project_id, "deleted" => 0))->getResult();
            foreach ($milestones as $milestone) {
                $old_milestone_id = $milestone->id;

                //prepare new milestone data. remove id from existing data
                $milestone->project_id = $new_project_id;
                $milestone_data = (array) $milestone;
                unset($milestone_data["id"]);

                //add new milestone and keep a relation with new id and old id
                $milestones_array[$old_milestone_id] = $this->Milestones_model->ci_save($milestone_data);
            }
        } else if ($change_the_milestone_dates_based_on_project_start_date && $old_project_info->start_date && $project_start_date) {
            $milestones = $this->Milestones_model->get_all_where(array("project_id" => $project_id, "deleted" => 0))->getResult();
            foreach ($milestones as $milestone) {
                $old_milestone_id = $milestone->id;

                //prepare new milestone data. remove id from existing data
                $milestone->project_id = $new_project_id;

                $old_project_start_date = $old_project_info->start_date;
                $old_milestone_due_date = $milestone->due_date;

                $milestone_due_date_day_diff = get_date_difference_in_days($old_milestone_due_date, $old_project_start_date);
                $milestone->due_date = add_period_to_date($project_start_date, $milestone_due_date_day_diff, "days");

                $milestone_data = (array) $milestone;
                unset($milestone_data["id"]);

                //add new milestone and keep a relation with new id and old id
                $milestones_array[$old_milestone_id] = $this->Milestones_model->ci_save($milestone_data);
            }
        }

        //we'll keep all new task ids vs old task ids. by this way, we'll add the checklist easily 
        $task_ids = array();

        //add tasks
        //first, save tasks whose are not sub tasks 
        $tasks = $this->Tasks_model->get_all_where(array("project_id" => $project_id, "deleted" => 0, "parent_task_id" => 0))->getResult();
        foreach ($tasks as $task) {
            $task_data = $this->_prepare_new_task_data_on_cloning_project($new_project_id, $milestones_array, $task, $copy_same_assignee_and_collaborators, $copy_tasks_start_date_and_deadline, $move_all_tasks_to_to_do, $change_the_tasks_start_date_and_deadline_based_on_project_start_date, $old_project_info, $project_start_date);

            //add new task
            $new_taks_id = $this->Tasks_model->ci_save($task_data);

            //bind old id with new
            $task_ids[$task->id] = $new_taks_id;

            //save custom fields of task
            $this->_save_custom_fields_on_cloning_project($task, $new_taks_id);
        }

        //secondly, save sub tasks
        $tasks = $this->Tasks_model->get_all_where(array("project_id" => $project_id, "deleted" => 0, "parent_task_id !=" => 0))->getResult();
        foreach ($tasks as $task) {
            $task_data = $this->_prepare_new_task_data_on_cloning_project($new_project_id, $milestones_array, $task, $copy_same_assignee_and_collaborators, $copy_tasks_start_date_and_deadline, $move_all_tasks_to_to_do, $change_the_tasks_start_date_and_deadline_based_on_project_start_date, $old_project_info, $project_start_date);
            //add parent task
            $task_data["parent_task_id"] = $task_ids[$task->parent_task_id];

            //add new task
            $new_taks_id = $this->Tasks_model->ci_save($task_data);

            //bind old id with new
            $task_ids[$task->id] = $new_taks_id;

            //save custom fields of task
            $this->_save_custom_fields_on_cloning_project($task, $new_taks_id);
        }

        //save task dependencies
        $tasks = $this->Tasks_model->get_all_tasks_where_have_dependency($project_id)->getResult();
        foreach ($tasks as $task) {
            if (array_key_exists($task->id, $task_ids)) {
                //save blocked by tasks 
                if ($task->blocked_by) {
                    //find the newly created tasks
                    $new_blocked_by_tasks = "";
                    $blocked_by_tasks_array = explode(',', $task->blocked_by);
                    foreach ($blocked_by_tasks_array as $blocked_by_task) {
                        if (array_key_exists($blocked_by_task, $task_ids)) {
                            if ($new_blocked_by_tasks) {
                                $new_blocked_by_tasks .= "," . $task_ids[$blocked_by_task];
                            } else {
                                $new_blocked_by_tasks = $task_ids[$blocked_by_task];
                            }
                        }
                    }

                    //update newly created task
                    if ($new_blocked_by_tasks) {
                        $blocked_by_task_data = array("blocked_by" => $new_blocked_by_tasks);
                        $this->Tasks_model->ci_save($blocked_by_task_data, $task_ids[$task->id]);
                    }
                }

                //save blocking tasks 
                if ($task->blocking) {
                    //find the newly created tasks
                    $new_blocking_tasks = "";
                    $blocking_tasks_array = explode(',', $task->blocking);
                    foreach ($blocking_tasks_array as $blocking_task) {
                        if (array_key_exists($blocking_task, $task_ids)) {
                            if ($new_blocking_tasks) {
                                $new_blocking_tasks .= "," . $task_ids[$blocking_task];
                            } else {
                                $new_blocking_tasks = $task_ids[$blocking_task];
                            }
                        }
                    }

                    //update newly created task
                    if ($new_blocking_tasks) {
                        $blocking_task_data = array("blocking" => $new_blocking_tasks);
                        $this->Tasks_model->ci_save($blocking_task_data, $task_ids[$task->id]);
                    }
                }
            }
        }

        //add project members
        $project_members = $this->Project_members_model->get_all_where(array("project_id" => $project_id, "deleted" => 0))->getResult();

        foreach ($project_members as $project_member) {
            //prepare new project member data. remove id from existing data
            $project_member->project_id = $new_project_id;
            $project_member_data = (array) $project_member;
            unset($project_member_data["id"]);

            $project_member_data["user_id"] = $project_member->user_id;

            $this->Project_members_model->save_member($project_member_data);
        }

        //add check lists
        $check_lists = $this->Checklist_items_model->get_all_checklist_of_project($project_id)->getResult();
        foreach ($check_lists as $list) {
            if (array_key_exists($list->task_id, $task_ids)) {
                $checklist_data = array(
                    "title" => $list->title,
                    "task_id" => $task_ids[$list->task_id],
                    "is_checked" => 0
                );

                $this->Checklist_items_model->ci_save($checklist_data);
            }
        }

        $project_settings = $this->Project_settings_model->get_details(array("project_id" => $project_id))->getResult();
        foreach ($project_settings as $project_setting) {
            $setting = $project_setting->setting_name;
            $value = $project_setting->setting_value;
            if (!$value) {
                $value = "";
            }

            $this->Project_settings_model->save_setting($new_project_id, $setting, $value);
        }

        if ($new_project_id) {
            //save custom fields of project
            save_custom_fields("projects", $new_project_id, 1, "staff"); //we have to keep this regarding as an admin user because non-admin user also can acquire the access to clone a project

            log_notification("project_created", array("project_id" => $new_project_id));

            echo json_encode(array("success" => true, 'id' => $new_project_id, 'message' => app_lang('project_cloned_successfully')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    private function _prepare_new_task_data_on_cloning_project($new_project_id, $milestones_array, $task, $copy_same_assignee_and_collaborators, $copy_tasks_start_date_and_deadline, $move_all_tasks_to_to_do, $change_the_tasks_start_date_and_deadline_based_on_project_start_date, $old_project_info, $project_start_date) {
        //prepare new task data. 
        $task->project_id = $new_project_id;
        $milestone_id = get_array_value($milestones_array, $task->milestone_id);
        $task->milestone_id = $milestone_id ? $milestone_id : "";
        $task->status = "to_do";

        if (!$copy_same_assignee_and_collaborators) {
            $task->assigned_to = "";
            $task->collaborators = "";
        }

        $task_data = (array) $task;
        unset($task_data["id"]); //remove id from existing data

        if ($move_all_tasks_to_to_do) {
            $task_data["status"] = "to_do";
            $task_data["status_id"] = 1;
        }

        if (!$copy_tasks_start_date_and_deadline && !$change_the_tasks_start_date_and_deadline_based_on_project_start_date) {
            $task->start_date = NULL;
            $task->deadline = NULL;
        } else if ($change_the_tasks_start_date_and_deadline_based_on_project_start_date && $old_project_info->start_date && $project_start_date) {
            $old_project_start_date = $old_project_info->start_date;
            $old_task_start_date = $task->start_date;
            $old_task_end_date = $task->deadline;

            if ($old_task_start_date) {
                $start_date_day_diff = get_date_difference_in_days($old_task_start_date, $old_project_start_date);
                $task_data["start_date"] = add_period_to_date($project_start_date, $start_date_day_diff, "days");
            } else {
                $task_data["start_date"] = NULL;
            }

            if ($old_task_end_date) {
                $end_date_day_diff = get_date_difference_in_days($old_task_end_date, $old_project_start_date);
                $task_data["deadline"] = add_period_to_date($project_start_date, $end_date_day_diff, "days");
            } else {
                $task_data["deadline"] = NULL;
            }
        }

        return $task_data;
    }

    private function _save_custom_fields_on_cloning_project($task, $new_taks_id) {
        $old_custom_fields = $this->Custom_field_values_model->get_all_where(array("related_to_type" => "tasks", "related_to_id" => $task->id, "deleted" => 0))->getResult();

        //prepare new custom fields data
        foreach ($old_custom_fields as $field) {
            $field->related_to_id = $new_taks_id;

            $fields_data = (array) $field;
            unset($fields_data["id"]); //remove id from existing data
            //save custom field
            $this->Custom_field_values_model->ci_save($fields_data);
        }
    }

    /* delete a project */

    function delete() {
        $id = $this->request->getPost('id');

        if (!$this->can_delete_projects($id)) {
            app_redirect("forbidden");
        }

        if ($this->Projects_model->delete_project_and_sub_items($id)) {
            log_notification("project_deleted", array("project_id" => $id));

            try {
                app_hooks()->do_action("app_hook_data_delete", array(
                    "id" => $id,
                    "table" => get_db_prefix() . "projects",
                    "table_without_prefix" => "projects",
                ));
            } catch (\Exception $ex) {
                log_message('error', '[ERROR] {exception}', ['exception' => $ex]);
            }

            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    /* list of projcts, prepared for datatable  */

    function list_data() {
        $this->access_only_team_members();

        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("projects", $this->login_user->is_admin, $this->login_user->user_type);

        $status_ids = $this->request->getPost('status_id') ? implode(",", $this->request->getPost('status_id')) : "";

        $options = array(
            "status_ids" => $status_ids,
            "project_label" => $this->request->getPost("project_label"),
            "custom_fields" => $custom_fields,
            "start_date_from" => $this->request->getPost("start_date_from"),
            "start_date_to" => $this->request->getPost("start_date_to"),
            "deadline" => $this->request->getPost('deadline'),
            "custom_field_filter" => $this->prepare_custom_field_filter_values("projects", $this->login_user->is_admin, $this->login_user->user_type)
        );

        //only admin/ the user has permission to manage all projects, can see all projects, other team mebers can see only their own projects.
        if (!$this->can_manage_all_projects()) {
            $options["user_id"] = $this->login_user->id;
        }

        $list_data = $this->Projects_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data, $custom_fields);
        }
        echo json_encode(array("data" => $result));
    }

    /* list of projcts, prepared for datatable  */

    function projects_list_data_of_team_member($team_member_id = 0) {
        validate_numeric_value($team_member_id);
        $this->access_only_team_members();

        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("projects", $this->login_user->is_admin, $this->login_user->user_type);

        $status_ids = $this->request->getPost('status_id') ? implode(",", $this->request->getPost('status_id')) : "";

        $options = array(
            "status_ids" => $status_ids,
            "custom_fields" => $custom_fields,
            "custom_field_filter" => $this->prepare_custom_field_filter_values("projects", $this->login_user->is_admin, $this->login_user->user_type)
        );

        //add can see all members projects but team members can see only ther own projects
        if (!$this->can_manage_all_projects() && $team_member_id != $this->login_user->id) {
            app_redirect("forbidden");
        }

        $options["user_id"] = $team_member_id;

        $list_data = $this->Projects_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data, $custom_fields);
        }
        echo json_encode(array("data" => $result));
    }

    function projects_list_data_of_client($client_id = 0) {
        validate_numeric_value($client_id);

        $this->access_only_team_members_or_client_contact($client_id);

        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("projects", $this->login_user->is_admin, $this->login_user->user_type);

        $status_ids = $this->request->getPost('status_id') ? implode(",", $this->request->getPost('status_id')) : "";

        $options = array(
            "client_id" => $client_id,
            "status_ids" => $status_ids,
            "project_label" => $this->request->getPost("project_label"),
            "custom_fields" => $custom_fields,
            "custom_field_filter" => $this->prepare_custom_field_filter_values("projects", $this->login_user->is_admin, $this->login_user->user_type)
        );

        $list_data = $this->Projects_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data, $custom_fields);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of project list  table */

    private function _row_data($id) {
        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("projects", $this->login_user->is_admin, $this->login_user->user_type);

        $options = array(
            "id" => $id,
            "custom_fields" => $custom_fields
        );

        $data = $this->Projects_model->get_details($options)->getRow();
        return $this->_make_row($data, $custom_fields);
    }

    /* prepare a row of project list table */

    private function _make_row($data, $custom_fields) {

        $progress = $data->total_points ? round(($data->completed_points / $data->total_points) * 100) : 0;

        $class = "bg-primary";
        if ($progress == 100) {
            $class = "progress-bar-success";
        }

        $progress_bar = "<div class='progress' title='$progress%'>
            <div  class='progress-bar $class' role='progressbar' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100' style='width: $progress%'>
            </div>
        </div>";
        $start_date = is_date_exists($data->start_date) ? format_to_date($data->start_date, false) : "-";
        $dateline = is_date_exists($data->deadline) ? format_to_date($data->deadline, false) : "-";
        $price = $data->price ? to_currency($data->price, $data->currency_symbol) : "-";

        //has deadline? change the color of date based on status
        if (is_date_exists($data->deadline)) {
            if ($progress !== 100 && $data->status_id == 1 && get_my_local_time("Y-m-d") > $data->deadline) {
                $dateline = "<span class='text-danger mr5'>" . $dateline . "</span> ";
            } else if ($progress !== 100 && $data->status_id == 1 && get_my_local_time("Y-m-d") == $data->deadline) {
                $dateline = "<span class='text-warning mr5'>" . $dateline . "</span> ";
            }
        }

        $title = anchor(get_uri("projects/view/" . $data->id), $data->title);
        if ($data->labels_list) {
            $project_labels = make_labels_view_data($data->labels_list, true);
            $title .= "<br />" . $project_labels;
        }

        $optoins = "";
        if ($this->can_edit_projects($data->id)) {
            $optoins .= modal_anchor(get_uri("projects/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_project'), "data-post-id" => $data->id));
        }

        if ($this->can_delete_projects($data->id)) {
            $optoins .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_project'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete"), "data-action" => "delete-confirmation"));
        }

        //show the project price to them who has permission to create projects
        if ($this->login_user->user_type == "staff" && !$this->can_create_projects()) {
            $price = "-";
        }

        $client_name = "-";
        if ($data->charter_name) {
            $client_name = anchor(get_uri("clients/view/" . $data->client_id), $data->charter_name);
        }

        $row_data = array(
            anchor(get_uri("projects/view/" . $data->id), $data->id),
            $title,
            $client_name,
            // $price,
            $data->start_date,
            $start_date,
            $data->deadline,
            $dateline,
            $progress_bar,
            $data->title_language_key ? app_lang($data->title_language_key) : $data->status_title
        );

        foreach ($custom_fields as $field) {
            $cf_id = "cfv_" . $field->id;
            $row_data[] = $this->template->view("custom_fields/output_" . $field->field_type, array("value" => $data->$cf_id));
        }

        $row_data[] = $optoins;

        return $row_data;
    }

    /* load project details view */

    function view($project_id = 0, $tab = "") {
        validate_numeric_value($project_id);
        $this->init_project_permission_checker($project_id);

        $view_data = $this->_get_project_info_data($project_id);

        $access_info = $this->get_access_info("invoice");
        $view_data["show_invoice_info"] = (get_setting("module_invoice") && $this->can_view_invoices()) ? true : false;

        $expense_access_info = $this->get_access_info("expense");
        $view_data["show_expense_info"] = (get_setting("module_expense") && $expense_access_info->access_type == "all") ? true : false;

        $access_contract = $this->get_access_info("contract");
        $view_data["show_contract_info"] = (get_setting("module_contract") && $access_contract->access_type == "all") ? true : false;

        $view_data["show_note_info"] = (get_setting("module_note")) ? true : false;

        $view_data["show_timmer"] = get_setting("module_project_timesheet") ? true : false;

        $this->init_project_settings($project_id);
        $view_data["show_timesheet_info"] = $this->can_view_timesheet($project_id);

        $view_data["show_tasks"] = true;

        $view_data["show_gantt_info"] = $this->can_view_gantt();
        $view_data["show_milestone_info"] = $this->can_view_milestones();

        if ($this->login_user->user_type === "client") {
            $view_data["show_timmer"] = false;
            $view_data["show_tasks"] = $this->client_can_view_tasks();

            if (!get_setting("client_can_edit_projects")) {
                $view_data["show_actions_dropdown"] = false;
            }
        }

        $view_data["show_files"] = $this->can_view_files();

        $view_data["tab"] = clean_data($tab);

        $view_data["is_starred"] = strpos($view_data['project_info']->starred_by, ":" . $this->login_user->id . ":") ? true : false;

        $view_data['can_edit_timesheet_settings'] = $this->can_edit_timesheet_settings($project_id);
        $view_data['can_edit_slack_settings'] = $this->can_edit_slack_settings();
        $view_data["can_create_projects"] = $this->can_create_projects();
        $view_data["can_edit_projects"] = $this->can_edit_projects($project_id);

        $view_data["show_actions_dropdown"] = $view_data["can_create_projects"] || $view_data["can_edit_projects"];

        $ticket_access_info = $this->get_access_info("ticket");
        $view_data["show_ticket_info"] = (get_setting("module_ticket") && get_setting("project_reference_in_tickets") && $ticket_access_info->access_type == "all") ? true : false;

        $view_data["project_statuses"] = $this->Project_status_model->get_details()->getResult();
        $view_data["show_customer_feedback"] = $this->has_client_feedback_access_permission();

        return $this->template->rander("projects/details_view", $view_data);
    }

    private function _make_checklist_item_row($data = array(), $flag_add, $task_title) {
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
        
        $title = "<span class='font-13 $title_class'>" . $title_value . "</span>";

        $delete = ajax_anchor(get_uri("tasks/delete_checklist_item/$data->id"), "<div class='float-end'><i data-feather='x' class='icon-16'></i></div>", array("class" => "delete-checklist-item", "title" => app_lang("delete_checklist_item"), "data-fade-out-on-success" => "#checklist-item-row-$data->id"));
        
        $row_data = "<div id='checklist-item-row-$data->id' class='list-group-item mb5 checklist-item-row b-a rounded text-break' data-id='$data->id'>" . $status . $delete . $title . "</div>";
        if ($flag_add) {
            $row_data = "<div class='task-item mt10'>" . $task_title . "</div>" . $row_data;
        }

        return $row_data;
    }

    private function can_edit_timesheet_settings($project_id) {
        $this->init_project_permission_checker($project_id);
        if ($project_id && $this->login_user->user_type === "staff" && $this->can_view_timesheet($project_id)) {
            return true;
        }
    }

    private function can_edit_slack_settings() {
        if ($this->login_user->user_type === "staff" && $this->can_create_projects()) {
            return true;
        }
    }

    /* prepare project info data for reuse */

    private function _get_project_info_data($project_id) {
        $options = array(
            "id" => $project_id,
            "client_id" => $this->login_user->client_id,
        );

        if (!$this->can_manage_all_projects()) {
            $options["user_id"] = $this->login_user->id;
        }

        $project_info = $this->Projects_model->get_details($options)->getRow();
        $view_data['project_info'] = $project_info;

        if ($project_info) {
            $view_data['project_info'] = $project_info;
            $timer = $this->Timesheets_model->get_timer_info($project_id, $this->login_user->id)->getRow();
            $user_has_any_timer_except_this_project = $this->Timesheets_model->user_has_any_timer_except_this_project($project_id, $this->login_user->id);

            //disable the start timer button if the setting is disabled
            $view_data["disable_timer"] = false;
            if ($user_has_any_timer_except_this_project && !get_setting("users_can_start_multiple_timers_at_a_time")) {
                $view_data["disable_timer"] = true;
            }

            if ($timer) {
                $view_data['timer_status'] = "open";
            } else {
                $view_data['timer_status'] = "";
            }

            $view_data['project_progress'] = $project_info->total_points ? round(($project_info->completed_points / $project_info->total_points) * 100) : 0;

            return $view_data;
        } else {
            show_404();
        }
    }

    function show_my_starred_projects() {
        $view_data["projects"] = $this->Projects_model->get_starred_projects($this->login_user->id)->getResult();
        return $this->template->view('projects/star/projects_list', $view_data);
    }

    /* load project overview section */

    function overview($project_id) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        $this->init_project_permission_checker($project_id);

        $view_data = $this->_get_project_info_data($project_id);
        $view_data["task_statuses"] = $this->Tasks_model->get_task_statistics(array("project_id" => $project_id))->task_statuses;

        $view_data['project_id'] = $project_id;
        ///////
        $view_data['status_info']=$this->Project_status_model->get_one($view_data['project_info']->status_id);
        /////
        $offset = 0;
        $view_data['offset'] = $offset;
        $view_data['activity_logs_params'] = array("log_for" => "project", "log_for_id" => $project_id, "limit" => 20, "offset" => $offset);

        $view_data["can_add_remove_project_members"] = $this->can_add_remove_project_members();
        $view_data["can_access_clients"] = $this->can_access_clients(true);

        $view_data['custom_fields_list'] = $this->Custom_fields_model->get_combined_details("projects", $project_id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();

        //count total worked hours
        $options = array("project_id" => $project_id);

        //get allowed member ids
        $members = $this->_get_members_to_manage_timesheet();
        if ($members != "all") {
            //if user has permission to access all members, query param is not required
            $options["allowed_members"] = $members;
        }

        $info = $this->Timesheets_model->count_total_time($options);
        $view_data["total_project_hours"] = to_decimal_format($info->timesheet_total / 60 / 60);

        //get checklist items
        $checklist_items_array = array();
        $checklist_items = $this->Checklist_items_model->get_all_checklist_of_project($project_id)->getResult();
        $task_title = '';
        $flag_add = false;
        foreach ($checklist_items as $checklist_item) {
            if ($task_title != $checklist_item->task_title) {
                $task_title = $checklist_item->task_title;
                $flag_add = true;
            } else {
                $flag_add = false;
            }
            $checklist_items_array[] = $this->_make_checklist_item_row($checklist_item, $flag_add, $task_title);
        }
        $view_data["checklist_items"] = json_encode($checklist_items_array);
        // $tasks = $this->Tasks_model->get_all_where(array("project_id" => $project_id, "deleted" => 0, "parent_task_id" => 0))->getResult();
        // $view_data["tasks"] = json_encode($tasks);

        return $this->template->view('projects/overview', $view_data);
    }

    /* add-remove start mark from project */

    function add_remove_star($project_id, $type = "add") {
        if ($project_id) {
            validate_numeric_value($project_id);

            if (get_setting("disable_access_favorite_project_option_for_clients") && $this->login_user->user_type == "client") {
                app_redirect("forbidden");
            }

            $view_data["project_id"] = $project_id;

            if ($type === "add") {
                $this->Projects_model->add_remove_star($project_id, $this->login_user->id, $type = "add");
                return $this->template->view('projects/star/starred', $view_data);
            } else {
                $this->Projects_model->add_remove_star($project_id, $this->login_user->id, $type = "remove");
                return $this->template->view('projects/star/not_starred', $view_data);
            }
        }
    }

    /* load project overview section */

    function overview_for_client($project_id) {
        validate_numeric_value($project_id);
        if ($this->login_user->user_type === "client") {
            $view_data = $this->_get_project_info_data($project_id);

            $view_data['project_id'] = $project_id;

            $offset = 0;
            $view_data['offset'] = $offset;
            $view_data['show_activity'] = false;
            $view_data['show_overview'] = false;
            $view_data['activity_logs_params'] = array();

            $this->init_project_permission_checker($project_id);
            $this->init_project_settings($project_id);
            $view_data["show_timesheet_info"] = $this->can_view_timesheet($project_id);

            $options = array("project_id" => $project_id);
            $timesheet_info = $this->Timesheets_model->count_total_time($options);
            $view_data["total_project_hours"] = to_decimal_format($timesheet_info->timesheet_total / 60 / 60);

            if (get_setting("client_can_view_overview")) {
                $view_data['show_overview'] = true;
                $view_data["task_statuses"] = $this->Tasks_model->get_task_statistics(array("project_id" => $project_id))->task_statuses;

                if (get_setting("client_can_view_activity")) {
                    $view_data['show_activity'] = true;
                    $view_data['activity_logs_params'] = array("log_for" => "project", "log_for_id" => $project_id, "limit" => 20, "offset" => $offset);
                }
            }

            $view_data['custom_fields_list'] = $this->Custom_fields_model->get_combined_details("projects", $project_id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();

            return $this->template->view('projects/overview_for_client', $view_data);
        }
    }

    /* load project members add/edit modal */

    function project_member_modal_form() {
        $view_data['model_info'] = $this->Project_members_model->get_one($this->request->getPost('id'));
        $project_id = $this->request->getPost('project_id') ? $this->request->getPost('project_id') : $view_data['model_info']->project_id;
        $this->init_project_permission_checker($project_id);

        if (!$this->can_add_remove_project_members()) {
            app_redirect("forbidden");
        }

        $view_data['project_id'] = $project_id;

        $view_data["view_type"] = $this->request->getPost("view_type");

        $add_user_type = $this->request->getPost("add_user_type");

        $users_dropdown = array();
        if ($add_user_type == "client_contacts") {
            if (!$this->can_access_clients(true)) {
                app_redirect("forbidden");
            }

            $users = $this->Project_members_model->get_client_contacts_of_the_project_client($project_id)->getResult();
            foreach ($users as $user) {
                $users_dropdown[$user->id] = $user->member_name;
            }
        } else {
            $users = $this->Project_members_model->get_rest_team_members_for_a_project($project_id)->getResult();
            foreach ($users as $user) {
                $users_dropdown[$user->id] = $user->member_name;
            }
        }

        $view_data["users_dropdown"] = $users_dropdown;
        $view_data["add_user_type"] = $add_user_type;

        return $this->template->view('projects/project_members/modal_form', $view_data);
    }

    /* add a project members  */

    function save_project_member() {
        $project_id = $this->request->getPost('project_id');

        $this->init_project_permission_checker($project_id);

        if (!$this->can_add_remove_project_members()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "user_id.*" => "required"
        ));

        $user_ids = $this->request->getPost('user_id');

        $save_ids = array();
        $already_exists = false;

        if ($user_ids) {
            foreach ($user_ids as $user_id) {
                if ($user_id) {
                    $data = array(
                        "project_id" => $project_id,
                        "user_id" => $user_id
                    );

                    $save_id = $this->Project_members_model->save_member($data);
                    if ($save_id && $save_id != "exists") {
                        $save_ids[] = $save_id;
                        log_notification("project_member_added", array("project_id" => $project_id, "to_user_id" => $user_id));
                    } else if ($save_id === "exists") {
                        $already_exists = true;
                    }
                }
            }
        }


        if (!count($save_ids) && $already_exists) {
            //this member already exists.
            echo json_encode(array("success" => true, 'id' => "exists"));
        } else if (count($save_ids)) {
            $project_member_row = array();
            foreach ($save_ids as $id) {
                $project_member_row[] = $this->_project_member_row_data($id);
            }
            echo json_encode(array("success" => true, "data" => $project_member_row, 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete/undo a project members  */

    function delete_project_member() {
        $id = $this->request->getPost('id');
        $project_member_info = $this->Project_members_model->get_one($id);

        $this->init_project_permission_checker($project_member_info->project_id);
        if (!$this->can_add_remove_project_members()) {
            app_redirect("forbidden");
        }


        if ($this->request->getPost('undo')) {
            if ($this->Project_members_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_project_member_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Project_members_model->delete($id)) {

                $project_member_info = $this->Project_members_model->get_one($id);

                log_notification("project_member_deleted", array("project_id" => $project_member_info->project_id, "to_user_id" => $project_member_info->user_id));
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of project members, prepared for datatable  */

    function project_member_list_data($project_id = 0, $user_type = "") {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        $this->init_project_permission_checker($project_id);

        //show the message icon to client contacts list only if the user can send message to client. 
        $can_send_message_to_client = false;
        $client_message_users = get_setting("client_message_users");
        $client_message_users_array = explode(",", $client_message_users);
        if (in_array($this->login_user->id, $client_message_users_array)) {

            $can_send_message_to_client = true;
        }

        $options = array("project_id" => $project_id, "user_type" => $user_type, "show_user_wise" => true);
        $list_data = $this->Project_members_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_project_member_row($data, $can_send_message_to_client);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of project member list */

    private function _project_member_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Project_members_model->get_details($options)->getRow();
        return $this->_make_project_member_row($data);
    }

    /* prepare a row of project member list */

    private function _make_project_member_row($data, $can_send_message_to_client = false) {
        $member_image = "<span class='avatar avatar-sm'><img src='" . get_avatar($data->member_image) . "' alt='...'></span> ";

        if ($data->user_type == "staff") {
            $member = get_team_member_profile_link($data->user_id, $member_image);
            $member_name = get_team_member_profile_link($data->user_id, $data->member_name, array("class" => "dark strong"));
        } else {
            $member = get_client_contact_profile_link($data->user_id, $member_image);
            $member_name = get_client_contact_profile_link($data->user_id, $data->charter_name, array("class" => "dark strong"));
        }

        $link = "";

        //check message module availability and show message button
        if (get_setting("module_message") && ($this->login_user->id != $data->user_id)) {
            $link = modal_anchor(get_uri("messages/modal_form/" . $data->user_id), "<i data-feather='mail' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('send_message')));
        }

        //check message icon permission for client contacts
        if (!$can_send_message_to_client && $data->user_type === "client") {
            $link = "";
        }


        if ($this->can_add_remove_project_members()) {
            $delete_link = js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_member'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete_project_member"), "data-action" => "delete"));

            if (!$this->can_manage_all_projects() && ($this->login_user->id === $data->user_id)) {
                $delete_link = "";
            }
            $link .= $delete_link;
        }

        $member = '<div class="d-flex"><div class="p-2 flex-shrink-1">' . $member . '</div><div class="p-2 w-100"><div>' . $member_name . '</div><label class="text-off">' . $data->job_title . '</label></div></div>';

        return array($member, $link);
    }

    //stop timer note modal
    function stop_timer_modal_form($project_id) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();

        if ($project_id) {
            $view_data["project_id"] = $project_id;
            $view_data["tasks_dropdown"] = $this->_get_timesheet_tasks_dropdown($project_id);

            $options = array(
                "project_id" => $project_id,
                "task_status_id" => 2,
                "assigned_to" => $this->login_user->id
            );

            $task_info = $this->Tasks_model->get_details($options)->getRow();

            $open_task_id = $this->request->getPost("task_id");

            $task_id = "";
            if ($open_task_id) {
                $task_id = $open_task_id;
            } else if ($task_info) {
                $task_id = $task_info->id;
            }

            $view_data["open_task_id"] = $open_task_id;
            $view_data["task_id"] = $task_id;

            return $this->template->view('projects/timesheets/stop_timer_modal_form', $view_data);
        }
    }

    private function _get_timesheet_tasks_dropdown($project_id, $return_json = false) {
        $tasks_dropdown = array("" => "-");
        $tasks_dropdown_json = array(array("id" => "", "text" => "- " . app_lang("task") . " -"));

        $show_assigned_tasks_only_user_id = $this->show_assigned_tasks_only_user_id();
        if (!$show_assigned_tasks_only_user_id) {
            $timesheet_manage_permission = get_array_value($this->login_user->permissions, "timesheet_manage_permission");
            if (!$timesheet_manage_permission || $timesheet_manage_permission === "own") {
                //show only own tasks when the permission is no/own
                $show_assigned_tasks_only_user_id = $this->login_user->id;
            }
        }

        $options = array(
            "project_id" => $project_id,
            "show_assigned_tasks_only_user_id" => $show_assigned_tasks_only_user_id
        );

        $tasks = $this->Tasks_model->get_details($options)->getResult();

        foreach ($tasks as $task) {
            $tasks_dropdown_json[] = array("id" => $task->id, "text" => $task->id . " - " . $task->title);
            $tasks_dropdown[$task->id] = $task->id . " - " . $task->title;
        }

        if ($return_json) {
            return json_encode($tasks_dropdown_json);
        } else {
            return $tasks_dropdown;
        }
    }

    /* start/stop project timer */

    function timer($project_id, $timer_status = "start") {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        $note = $this->request->getPost("note");
        $task_id = $this->request->getPost("task_id");

        $data = array(
            "project_id" => $project_id,
            "user_id" => $this->login_user->id,
            "status" => $timer_status,
            "note" => $note ? $note : "",
            "task_id" => $task_id ? $task_id : 0,
        );

        $user_has_any_timer_except_this_project = $this->Timesheets_model->user_has_any_timer_except_this_project($project_id, $this->login_user->id);

        $user_has_any_open_timer_on_this_task = false;

        if ($task_id) {
            $user_has_any_open_timer_on_this_task = $this->Timesheets_model->user_has_any_open_timer_on_this_task($task_id, $this->login_user->id);
        }

        if ($timer_status == "start" && $user_has_any_timer_except_this_project && !get_setting("users_can_start_multiple_timers_at_a_time")) {
            app_redirect("forbidden");
        } else if ($timer_status == "start" && $user_has_any_open_timer_on_this_task) {
            app_redirect("forbidden");
        }

        $this->Timesheets_model->process_timer($data);
        if ($timer_status === "start") {
            if ($this->request->getPost("task_timer")) {
                echo modal_anchor(get_uri("projects/stop_timer_modal_form/" . $project_id), "<i data-feather='clock' class='icon-16'></i> " . app_lang('stop_timer'), array("class" => "btn btn-danger", "title" => app_lang('stop_timer'), "data-post-task_id" => $task_id));
            } else {
                $view_data = $this->_get_project_info_data($project_id);
                return $this->template->view('projects/project_timer', $view_data);
            }
        } else {
            echo json_encode(array("success" => true));
        }
    }

    /* load timesheets view for a project */

    function timesheets($project_id) {
        validate_numeric_value($project_id);

        $this->init_project_permission_checker($project_id);
        $this->init_project_settings($project_id); //since we'll check this permission project wise


        if (!$this->can_view_timesheet($project_id)) {
            app_redirect("forbidden");
        }

        $view_data['project_id'] = $project_id;

        //client can't add log or update settings
        $view_data['can_add_log'] = false;

        if ($this->login_user->user_type === "staff") {
            $view_data['can_add_log'] = true;
        }

        $view_data['project_members_dropdown'] = json_encode($this->_get_project_members_dropdown_list_for_filter($project_id));
        $view_data['tasks_dropdown'] = $this->_get_timesheet_tasks_dropdown($project_id, true);

        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("timesheets", $this->login_user->is_admin, $this->login_user->user_type);
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("timesheets", $this->login_user->is_admin, $this->login_user->user_type);

        $view_data["show_members_dropdown"] = true;
        $timesheet_access_info = $this->get_access_info("timesheet_manage_permission");
        $timesheet_access_type = $timesheet_access_info->access_type;

        if (!$timesheet_access_type || $timesheet_access_type === "own") {
            $view_data["show_members_dropdown"] = false;
        }

        return $this->template->view("projects/timesheets/index", $view_data);
    }

    /* prepare project members dropdown */

    private function _get_project_members_dropdown_list_for_filter($project_id) {

        $project_members = $this->Project_members_model->get_project_members_dropdown_list($project_id)->getResult();
        $project_members_dropdown = array(array("id" => "", "text" => "- " . app_lang("member") . " -"));
        foreach ($project_members as $member) {
            $project_members_dropdown[] = array("id" => $member->user_id, "text" => $member->member_name);
        }
        return $project_members_dropdown;
    }

    /* load timelog add/edit modal */

    function timelog_modal_form() {
        $this->access_only_team_members();
        $view_data['time_format_24_hours'] = get_setting("time_format") == "24_hours" ? true : false;
        $model_info = $this->Timesheets_model->get_one($this->request->getPost('id'));
        $project_id = $this->request->getPost('project_id') ? $this->request->getPost('project_id') : $model_info->project_id;

        //set the login user as a default selected member
        if (!$model_info->user_id) {
            $model_info->user_id = $this->login_user->id;
        }

        //get related data
        $related_data = $this->_prepare_all_related_data_for_timelog($project_id);
        $show_porject_members_dropdown = get_array_value($related_data, "show_porject_members_dropdown");
        $view_data["tasks_dropdown"] = get_array_value($related_data, "tasks_dropdown");
        $view_data["project_members_dropdown"] = get_array_value($related_data, "project_members_dropdown");

        $view_data["model_info"] = $model_info;

        if ($model_info->id) {
            $show_porject_members_dropdown = false; //don't allow to edit the user on update.
        }

        $view_data["project_id"] = $project_id;
        $view_data['show_porject_members_dropdown'] = $show_porject_members_dropdown;
        $view_data["projects_dropdown"] = $this->_get_projects_dropdown();

        $view_data["custom_fields"] = $this->Custom_fields_model->get_combined_details("timesheets", $view_data['model_info']->id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();

        return $this->template->view('projects/timesheets/modal_form', $view_data);
    }

    private function _prepare_all_related_data_for_timelog($project_id = 0) {
        //we have to check if any defined project exists, then go through with the project id
        $show_porject_members_dropdown = false;
        if ($project_id) {
            $tasks_dropdown = $this->_get_timesheet_tasks_dropdown($project_id, true);

            //prepare members dropdown list
            $allowed_members = $this->_get_members_to_manage_timesheet();
            $project_members = "";

            if ($allowed_members === "all") {
                $project_members = $this->Project_members_model->get_project_members_dropdown_list($project_id)->getResult(); //get all members of this project
            } else {
                $project_members = $this->Project_members_model->get_project_members_dropdown_list($project_id, $allowed_members)->getResult();
            }

            $project_members_dropdown = array();
            if ($project_members) {
                foreach ($project_members as $member) {

                    if ($member->user_id !== $this->login_user->id) {
                        $show_porject_members_dropdown = true; //user can manage other users time.
                    }

                    $project_members_dropdown[] = array("id" => $member->user_id, "text" => $member->member_name);
                }
            }
        } else {
            //we have show an empty dropdown when there is no project_id defined
            $tasks_dropdown = json_encode(array(array("id" => "", "text" => "-")));
            $project_members_dropdown = array(array("id" => "", "text" => "-"));
            $show_porject_members_dropdown = true;
        }

        return array(
            "project_members_dropdown" => $project_members_dropdown,
            "tasks_dropdown" => $tasks_dropdown,
            "show_porject_members_dropdown" => $show_porject_members_dropdown
        );
    }

    function get_all_related_data_of_selected_project_for_timelog($project_id = "") {
        validate_numeric_value($project_id);
        if ($project_id) {
            $related_data = $this->_prepare_all_related_data_for_timelog($project_id);

            echo json_encode(array(
                "project_members_dropdown" => get_array_value($related_data, "project_members_dropdown"),
                "tasks_dropdown" => json_decode(get_array_value($related_data, "tasks_dropdown"))
            ));
        }
    }

    /* insert/update a timelog */

    function save_timelog() {
        $this->access_only_team_members();
        $id = $this->request->getPost('id');

        $start_date_time = "";
        $end_date_time = "";
        $hours = "";

        $start_time = $this->request->getPost('start_time');
        $end_time = $this->request->getPost('end_time');
        $note = $this->request->getPost("note");
        $task_id = $this->request->getPost("task_id");

        if ($start_time) {
            //start time and end time mode
            //convert to 24hrs time format
            if (get_setting("time_format") != "24_hours") {
                $start_time = convert_time_to_24hours_format($start_time);
                $end_time = convert_time_to_24hours_format($end_time);
            }

            //join date with time
            $start_date_time = $this->request->getPost('start_date') . " " . $start_time;
            $end_date_time = $this->request->getPost('end_date') . " " . $end_time;

            //add time offset
            $start_date_time = convert_date_local_to_utc($start_date_time);
            $end_date_time = convert_date_local_to_utc($end_date_time);
        } else {
            //date and hour mode
            $date = $this->request->getPost("date");
            $start_date_time = $date . " 00:00:00";
            $end_date_time = $date . " 00:00:00";

            //prepare hours
            $hours = convert_humanize_data_to_hours($this->request->getPost("hours"));
            if (!$hours) {
                echo json_encode(array("success" => false, 'message' => app_lang("hour_log_time_error_message")));
                return false;
            }
        }

        $project_id = $this->request->getPost('project_id');
        $data = array(
            "project_id" => $project_id,
            "start_time" => $start_date_time,
            "end_time" => $end_date_time,
            "note" => $note ? $note : "",
            "task_id" => $task_id ? $task_id : 0,
            "hours" => $hours
        );

        //save user_id only on insert and it will not be editable
        if (!$id) {
            //insert mode
            $data["user_id"] = $this->request->getPost('user_id') ? $this->request->getPost('user_id') : $this->login_user->id;
        }

        $this->check_timelog_update_permission($id, $project_id, get_array_value($data, "user_id"));

        $save_id = $this->Timesheets_model->ci_save($data, $id);
        if ($save_id) {

            save_custom_fields("timesheets", $save_id, $this->login_user->is_admin, $this->login_user->user_type);

            echo json_encode(array("success" => true, "data" => $this->_timesheet_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete/undo a timelog */

    function delete_timelog() {
        $this->access_only_team_members();

        $id = $this->request->getPost('id');

        $this->check_timelog_update_permission($id);

        if ($this->request->getPost('undo')) {
            if ($this->Timesheets_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_timesheet_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Timesheets_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    private function check_timelog_update_permission($log_id = null, $project_id = null, $user_id = null) {
        if ($log_id) {
            $info = $this->Timesheets_model->get_one($log_id);
            $user_id = $info->user_id;
        }

        if (!$log_id && $user_id === $this->login_user->id) { //adding own timelogs
            return true;
        }

        $members = $this->_get_members_to_manage_timesheet();

        if ($members === "all") {
            return true;
        } else if (is_array($members) && count($members) && in_array($user_id, $members)) {
            //permission: no / own / specific / specific_excluding_own
            $timesheet_manage_permission = get_array_value($this->login_user->permissions, "timesheet_manage_permission");

            if (!$timesheet_manage_permission && $log_id) { //permission: no
                app_redirect("forbidden");
            }

            if ($timesheet_manage_permission === "specific_excluding_own" && $log_id && $user_id === $this->login_user->id) { //permission: specific_excluding_own
                app_redirect("forbidden");
            }

            //permission: own / specific
            return true;
        } else if ($members === "own_project_members" || $members === "own_project_members_excluding_own") {
            if (!$project_id) { //there has $log_id or $project_id
                $project_id = $info->project_id;
            }

            if ($this->Project_members_model->is_user_a_project_member($project_id, $user_id) || $this->Project_members_model->is_user_a_project_member($project_id, $this->login_user->id)) { //check if the login user and timelog user is both on same project
                if ($members === "own_project_members") {
                    return true;
                } else if ($this->login_user->id !== $user_id) {
                    //can't edit own but can edit other user's of project
                    //no need to check own condition here for new timelogs since it's already checked before
                    return true;
                }
            }
        }

        app_redirect("forbidden");
    }

    /* list of timesheets, prepared for datatable  */

    function timesheet_list_data() {

        $project_id = $this->request->getPost("project_id");

        $this->init_project_permission_checker($project_id);
        $this->init_project_settings($project_id); //since we'll check this permission project wise


        if (!$this->can_view_timesheet($project_id, true)) {
            app_redirect("forbidden");
        }

        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("timesheets", $this->login_user->is_admin, $this->login_user->user_type);

        $options = array(
            "project_id" => $project_id,
            "status" => "none_open",
            "user_id" => $this->request->getPost("user_id"),
            "start_date" => $this->request->getPost("start_date"),
            "end_date" => $this->request->getPost("end_date"),
            "task_id" => $this->request->getPost("task_id"),
            "client_id" => $this->request->getPost("client_id"),
            "custom_fields" => $custom_fields,
            "custom_field_filter" => $this->prepare_custom_field_filter_values("timesheets", $this->login_user->is_admin, $this->login_user->user_type)
        );

        //get allowed member ids
        $members = $this->_get_members_to_manage_timesheet();
        if ($members != "all" && $this->login_user->user_type == "staff") {
            //if user has permission to access all members, query param is not required
            //client can view all timesheet
            $options["allowed_members"] = $members;
        }

        $all_options = append_server_side_filtering_commmon_params($options);

        $result = $this->Timesheets_model->get_details($all_options);

        //by this, we can handel the server side or client side from the app table prams.
        if (get_array_value($all_options, "server_side")) {
            $list_data = get_array_value($result, "data");
        } else {
            $list_data = $result->getResult();
            $result = array();
        }

        $result_data = array();
        foreach ($list_data as $data) {
            $result_data[] = $this->_make_timesheet_row($data, $custom_fields);
        }

        $result["data"] = $result_data;

        echo json_encode($result);
    }

    /* return a row of timesheet list  table */

    private function _timesheet_row_data($id) {
        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("timesheets", $this->login_user->is_admin, $this->login_user->user_type);

        $options = array("id" => $id, "custom_fields" => $custom_fields);
        $data = $this->Timesheets_model->get_details($options)->getRow();
        return $this->_make_timesheet_row($data, $custom_fields);
    }

    /* prepare a row of timesheet list table */

    private function _make_timesheet_row($data, $custom_fields) {
        $image_url = get_avatar($data->logged_by_avatar);
        $user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $data->logged_by_user";

        $start_time = $data->start_time;
        $end_time = $data->end_time;
        $project_title = anchor(get_uri("projects/view/" . $data->project_id), $data->project_title);
        $task_title = modal_anchor(get_uri("tasks/view"), $data->task_title, array("title" => app_lang('task_info') . " #$data->task_id", "data-post-id" => $data->task_id, "data-modal-lg" => "1"));

        $client_name = "-";
        if ($data->timesheet_client_charter_name) {
            $client_name = anchor(get_uri("clients/view/" . $data->timesheet_client_id), $data->timesheet_client_charter_name);
        }

        $duration = convert_seconds_to_time_format($data->hours ? (round(($data->hours * 60), 0) * 60) : (abs(strtotime($end_time) - strtotime($start_time))));

        $row_data = array(
            get_team_member_profile_link($data->user_id, $user),
            $project_title,
            $client_name,
            $task_title,
            $data->start_time,
            ($data->hours || get_setting("users_can_input_only_total_hours_instead_of_period")) ? format_to_date($data->start_time) : format_to_datetime($data->start_time),
            $data->end_time,
            $data->hours ? format_to_date($data->end_time) : format_to_datetime($data->end_time),
            $duration,
            to_decimal_format(convert_time_string_to_decimal($duration)),
            $data->note
        );

        foreach ($custom_fields as $field) {
            $cf_id = "cfv_" . $field->id;
            $row_data[] = $this->template->view("custom_fields/output_" . $field->field_type, array("value" => $data->$cf_id));
        }

        $options = modal_anchor(get_uri("projects/timelog_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_timelog'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_timelog'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete_timelog"), "data-action" => "delete"));

        $timesheet_manage_permission = get_array_value($this->login_user->permissions, "timesheet_manage_permission");
        if ($data->user_id === $this->login_user->id && ($timesheet_manage_permission === "own_project_members_excluding_own" || $timesheet_manage_permission === "specific_excluding_own")) {
            $options = "";
        }

        $row_data[] = $options;

        return $row_data;
    }

    /* load timesheets summary view for a project */

    function timesheet_summary($project_id) {
        validate_numeric_value($project_id);

        $this->init_project_permission_checker($project_id);
        $this->init_project_settings($project_id); //since we'll check this permission project wise

        if (!$this->can_view_timesheet($project_id)) {
            app_redirect("forbidden");
        }



        $view_data['project_id'] = $project_id;

        $view_data['group_by_dropdown'] = json_encode(
                array(
                    array("id" => "", "text" => "- " . app_lang("group_by") . " -"),
                    array("id" => "member", "text" => app_lang("member")),
                    array("id" => "task", "text" => app_lang("task"))
        ));

        $view_data['project_members_dropdown'] = json_encode($this->_get_project_members_dropdown_list_for_filter($project_id));
        $view_data['tasks_dropdown'] = $this->_get_timesheet_tasks_dropdown($project_id, true);
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("timesheets", $this->login_user->is_admin, $this->login_user->user_type);

        $view_data["show_members_dropdown"] = true;
        $timesheet_access_info = $this->get_access_info("timesheet_manage_permission");
        $timesheet_access_type = $timesheet_access_info->access_type;

        if (!$timesheet_access_type || $timesheet_access_type === "own") {
            $view_data["show_members_dropdown"] = false;
        }

        return $this->template->view("projects/timesheets/summary_list", $view_data);
    }

    /* list of timesheets summary, prepared for datatable  */

    function timesheet_summary_list_data() {

        $project_id = $this->request->getPost("project_id");

        //client can't view all projects timesheet. project id is required.
        if (!$project_id) {
            $this->access_only_team_members();
        }

        if ($project_id) {
            $this->init_project_permission_checker($project_id);
            $this->init_project_settings($project_id); //since we'll check this permission project wise

            if (!$this->can_view_timesheet($project_id, true)) {
                app_redirect("forbidden");
            }
        }


        $group_by = $this->request->getPost("group_by");

        $options = array(
            "project_id" => $project_id,
            "status" => "none_open",
            "user_id" => $this->request->getPost("user_id"),
            "start_date" => $this->request->getPost("start_date"),
            "end_date" => $this->request->getPost("end_date"),
            "task_id" => $this->request->getPost("task_id"),
            "group_by" => $group_by,
            "client_id" => $this->request->getPost("client_id"),
            "custom_field_filter" => $this->prepare_custom_field_filter_values("timesheets", $this->login_user->is_admin, $this->login_user->user_type)
        );

        //get allowed member ids
        $members = $this->_get_members_to_manage_timesheet();
        if ($members != "all" && $this->login_user->user_type == "staff") {
            //if user has permission to access all members, query param is not required
            //client can view all timesheet
            $options["allowed_members"] = $members;
        }

        $list_data = $this->Timesheets_model->get_summary_details($options)->getResult();

        $result = array();
        foreach ($list_data as $data) {


            $member = "-";
            $task_title = "-";

            if ($group_by != "task") {
                $image_url = get_avatar($data->logged_by_avatar);
                $user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $data->logged_by_user";

                $member = get_team_member_profile_link($data->user_id, $user);
            }

            $project_title = anchor(get_uri("projects/view/" . $data->project_id), $data->project_title);

            if ($group_by != "member") {
                $task_title = modal_anchor(get_uri("tasks/view"), $data->task_title, array("title" => app_lang('task_info') . " #$data->task_id", "data-post-id" => $data->task_id, "data-modal-lg" => "1"));
                if (!$data->task_title) {
                    $task_title = app_lang("not_specified");
                }
            }


            $duration = convert_seconds_to_time_format(abs($data->total_duration));

            $client_name = "-";
            if ($data->timesheet_client_charter_name) {
                $client_name = anchor(get_uri("clients/view/" . $data->timesheet_client_id), $data->timesheet_client_charter_name);
            }

            $result[] = array(
                $project_title,
                $client_name,
                $member,
                $task_title,
                $duration,
                to_decimal_format(convert_time_string_to_decimal($duration))
            );
        }
        echo json_encode(array("data" => $result));
    }

    /* get all projects list */

    private function _get_all_projects_dropdown_list() {
        $projects = $this->Projects_model->get_dropdown_list(array("title"));

        $projects_dropdown = array(array("id" => "", "text" => "- " . app_lang("project") . " -"));
        foreach ($projects as $id => $title) {
            $projects_dropdown[] = array("id" => $id, "text" => $title);
        }
        return $projects_dropdown;
    }

    /* get all projects list according to the login user */

    private function _get_all_projects_dropdown_list_for_timesheets_filter() {
        $options = array();

        if (!$this->can_manage_all_projects()) {
            $options["user_id"] = $this->login_user->id;
        }

        $projects = $this->Projects_model->get_details($options)->getResult();

        $projects_dropdown = array(array("id" => "", "text" => "- " . app_lang("project") . " -"));
        foreach ($projects as $project) {
            $projects_dropdown[] = array("id" => $project->id, "text" => $project->title);
        }

        return $projects_dropdown;
    }

    /* prepare dropdown list */

    private function _prepare_members_dropdown_for_timesheet_filter($members) {
        $where = array("user_type" => "staff");

        if ($members != "all" && is_array($members) && count($members)) {
            $where["where_in"] = array("id" => $members);
        }

        $users = $this->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", $where);

        $members_dropdown = array(array("id" => "", "text" => "- " . app_lang("member") . " -"));
        foreach ($users as $id => $name) {
            $members_dropdown[] = array("id" => $id, "text" => $name);
        }
        return $members_dropdown;
    }

    /* load all time sheets view  */

    function all_timesheets() {
        $this->access_only_team_members();
        $members = $this->_get_members_to_manage_timesheet();

        $view_data['members_dropdown'] = json_encode($this->_prepare_members_dropdown_for_timesheet_filter($members));
        $view_data['projects_dropdown'] = json_encode($this->_get_all_projects_dropdown_list_for_timesheets_filter());
        $view_data['clients_dropdown'] = json_encode($this->_get_clients_dropdown());

        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("timesheets", $this->login_user->is_admin, $this->login_user->user_type);
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("timesheets", $this->login_user->is_admin, $this->login_user->user_type);

        return $this->template->rander("projects/timesheets/all_timesheets", $view_data);
    }

    /* load all timesheets summary view */

    function all_timesheet_summary() {
        $this->access_only_team_members();

        $members = $this->_get_members_to_manage_timesheet();

        $view_data['group_by_dropdown'] = json_encode(
                array(
                    array("id" => "", "text" => "- " . app_lang("group_by") . " -"),
                    array("id" => "member", "text" => app_lang("member")),
                    array("id" => "project", "text" => app_lang("project")),
                    array("id" => "task", "text" => app_lang("task"))
        ));

        $view_data['members_dropdown'] = json_encode($this->_prepare_members_dropdown_for_timesheet_filter($members));
        $view_data['projects_dropdown'] = json_encode($this->_get_all_projects_dropdown_list_for_timesheets_filter());
        $view_data['clients_dropdown'] = json_encode($this->_get_clients_dropdown());
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("timesheets", $this->login_user->is_admin, $this->login_user->user_type);

        return $this->template->view("projects/timesheets/all_summary_list", $view_data);
    }

    /* load milestones view */

    function milestones($project_id) {
        validate_numeric_value($project_id);
        $this->init_project_permission_checker($project_id);

        if (!$this->can_view_milestones()) {
            app_redirect("forbidden");
        }

        $view_data['project_id'] = $project_id;

        $view_data["can_create_milestones"] = $this->can_create_milestones();
        $view_data["can_edit_milestones"] = $this->can_edit_milestones();
        $view_data["can_delete_milestones"] = $this->can_delete_milestones();

        return $this->template->view("projects/milestones/index", $view_data);
    }

    /* load milestone add/edit modal */

    function milestone_modal_form() {
        $id = $this->request->getPost('id');
        $view_data['model_info'] = $this->Milestones_model->get_one($this->request->getPost('id'));
        $project_id = $this->request->getPost('project_id') ? $this->request->getPost('project_id') : $view_data['model_info']->project_id;

        $this->init_project_permission_checker($project_id);

        if ($id) {
            if (!$this->can_edit_milestones()) {
                app_redirect("forbidden");
            }
        } else {
            if (!$this->can_create_milestones()) {
                app_redirect("forbidden");
            }
        }

        $view_data['project_id'] = $project_id;

        return $this->template->view('projects/milestones/modal_form', $view_data);
    }

    /* insert/update a milestone */

    function save_milestone() {

        $id = $this->request->getPost('id');
        $project_id = $this->request->getPost('project_id');

        $this->init_project_permission_checker($project_id);

        if ($id) {
            if (!$this->can_edit_milestones()) {
                app_redirect("forbidden");
            }
        } else {
            if (!$this->can_create_milestones()) {
                app_redirect("forbidden");
            }
        }

        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description'),
            "project_id" => $this->request->getPost('project_id'),
            "due_date" => $this->request->getPost('due_date')
        );
        $save_id = $this->Milestones_model->ci_save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_milestone_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete/undo a milestone */

    function delete_milestone() {

        $id = $this->request->getPost('id');
        $info = $this->Milestones_model->get_one($id);
        $this->init_project_permission_checker($info->project_id);

        if (!$this->can_delete_milestones()) {
            app_redirect("forbidden");
        }

        if ($this->request->getPost('undo')) {
            if ($this->Milestones_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_milestone_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Milestones_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of milestones, prepared for datatable  */

    function milestones_list_data($project_id = 0) {
        validate_numeric_value($project_id);
        $this->init_project_permission_checker($project_id);

        $options = array("project_id" => $project_id);
        $list_data = $this->Milestones_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_milestone_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of milestone list  table */

    private function _milestone_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Milestones_model->get_details($options)->getRow();
        $this->init_project_permission_checker($data->project_id);

        return $this->_make_milestone_row($data);
    }

    /* prepare a row of milestone list table */

    private function _make_milestone_row($data) {

        //calculate milestone progress
        $progress = $data->total_points ? round(($data->completed_points / $data->total_points) * 100) : 0;
        $class = "bg-primary";
        if ($progress == 100) {
            $class = "progress-bar-success";
        }

        $total_tasks = $data->total_tasks ? $data->total_tasks : 0;
        $completed_tasks = $data->completed_tasks ? $data->completed_tasks : 0;

        $progress_bar = "<div class='ml10 mr10 clearfix'><span class='float-start'>$completed_tasks/$total_tasks</span><span class='float-end'>$progress%</span></div><div class='progress mt0' title='$progress%'>
            <div  class='progress-bar $class' role='progressbar' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100' style='width: $progress%'>
            </div>
        </div>";

        //define milesone color based on due date
        $due_date = date("L", strtotime($data->due_date));
        $label_class = "";
        if ($progress == 100) {
            $label_class = "bg-success";
        } else if ($progress !== 100 && get_my_local_time("Y-m-d") > $data->due_date) {
            $label_class = "bg-danger";
        } else if ($progress !== 100 && get_my_local_time("Y-m-d") == $data->due_date) {
            $label_class = "bg-warning";
        } else {
            $label_class = "bg-primary";
        }

        $day_or_year_name = "";
        if (date("Y", strtotime(get_current_utc_time())) === date("Y", strtotime($data->due_date))) {
            $day_or_year_name = app_lang(strtolower(date("l", strtotime($data->due_date)))); //get day name from language
        } else {
            $day_or_year_name = date("Y", strtotime($data->due_date)); //get current year
        }

        $month_name = app_lang(strtolower(date("F", strtotime($data->due_date)))); //get month name from language

        $due_date = "<div class='milestone float-start' title='" . format_to_date($data->due_date) . "'>
            <span class='badge $label_class'>" . $month_name . "</span>
            <h1>" . date("d", strtotime($data->due_date)) . "</h1>
            <span>" . $day_or_year_name . "</span>
            </div>
            "
        ;

        $optoins = "";
        if ($this->can_edit_milestones()) {
            $optoins .= modal_anchor(get_uri("projects/milestone_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_milestone'), "data-post-id" => $data->id));
        }

        if ($this->can_delete_milestones()) {
            $optoins .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_milestone'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete_milestone"), "data-action" => "delete"));
        }


        $title = "<div><b>" . $data->title . "</b></div>";
        if ($data->description) {
            $title .= "<div>" . nl2br($data->description) . "<div>";
        }

        return array(
            $data->due_date,
            $due_date,
            $title,
            $progress_bar,
            $optoins
        );
    }

    /* load comments view */

    function comments($project_id) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();

        $options = array("project_id" => $project_id, "task_id" => 0 , "login_user_id" => $this->login_user->id);
        $view_data['comments'] = $this->Project_comments_model->get_details($options)->getResult();
        $view_data['project_id'] = $project_id;
        return $this->template->view("projects/comments/index", $view_data);
    }

    /* load comments view */

    function customer_feedback($project_id) {
        if ($this->login_user->user_type == "staff") {
            if (!$this->has_client_feedback_access_permission()) {
                app_redirect("forbidden");
            }
        }

        validate_numeric_value($project_id);
        $options = array("customer_feedback_id" => $project_id, "login_user_id" => $this->login_user->id); //customer feedback id and project id is same
        $view_data['comments'] = $this->Project_comments_model->get_details($options)->getResult();
        $view_data['customer_feedback_id'] = $project_id;
        $view_data['project_id'] = $project_id;
        return $this->template->view("projects/comments/index", $view_data);
    }

    /* save project comments */

    function save_comment() {
        $id = $this->request->getPost('id');

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "project_comment");

        $project_id = $this->request->getPost('project_id');
        $file_id = $this->request->getPost('file_id');
        $customer_feedback_id = $this->request->getPost('customer_feedback_id');
        $comment_id = $this->request->getPost('comment_id');
        $description = $this->request->getPost('description');

        if ($customer_feedback_id && $this->login_user->user_type == "staff") {
            if (!$this->has_client_feedback_access_permission()) {
                app_redirect("forbidden");
            }
        }

        $data = array(
            "created_by" => $this->login_user->id,
            "created_at" => get_current_utc_time(),
            "project_id" => $project_id,
            "file_id" => $file_id ? $file_id : 0,
            "task_id" => 0,
            "customer_feedback_id" => $customer_feedback_id ? $customer_feedback_id : 0,
            "comment_id" => $comment_id ? $comment_id : 0,
            "description" => $description
        );

        $data = clean_data($data);

        $data["files"] = $files_data; //don't clean serilized data

        $save_id = $this->Project_comments_model->save_comment($data, $id);
        if ($save_id) {
            $response_data = "";
            $options = array("id" => $save_id, "login_user_id" => $this->login_user->id);

            if ($this->request->getPost("reload_list")) {
                $view_data['comments'] = $this->Project_comments_model->get_details($options)->getResult();
                $response_data = $this->template->view("projects/comments/comment_list", $view_data);
            }
            echo json_encode(array("success" => true, "data" => $response_data, 'message' => app_lang('comment_submited')));

            $comment_info = $this->Project_comments_model->get_one($save_id);

            $notification_options = array("project_id" => $comment_info->project_id, "project_comment_id" => $save_id);

            if ($comment_info->file_id) { //file comment
                $notification_options["project_file_id"] = $comment_info->file_id;
                log_notification("project_file_commented", $notification_options);
            } else if ($comment_info->customer_feedback_id) {  //customer feedback comment
                if ($comment_id) {
                    log_notification("project_customer_feedback_replied", $notification_options);
                } else {
                    log_notification("project_customer_feedback_added", $notification_options);
                }
            } else {  //project comment
                if ($comment_id) {
                    log_notification("project_comment_replied", $notification_options);
                } else {
                    log_notification("project_comment_added", $notification_options);
                }
            }
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_comment($id = 0) {

        if (!$id) {
            exit();
        }

        $comment_info = $this->Project_comments_model->get_one($id);

        //only admin and creator can delete the comment
        if (!($this->login_user->is_admin || $comment_info->created_by == $this->login_user->id)) {
            app_redirect("forbidden");
        }


        //delete the comment and files
        if ($this->Project_comments_model->delete($id) && $comment_info->files) {

            //delete the files
            $file_path = get_setting("timeline_file_path");
            $files = unserialize($comment_info->files);

            foreach ($files as $file) {
                delete_app_files($file_path, array($file));
            }
        }
    }

    /* load all replies of a comment */

    function view_comment_replies($comment_id) {
        validate_numeric_value($comment_id);
        $view_data['reply_list'] = $this->Project_comments_model->get_details(array("comment_id" => $comment_id))->getResult();
        return $this->template->view("projects/comments/reply_list", $view_data);
    }

    /* show comment reply form */

    function comment_reply_form($comment_id, $type = "project", $type_id = 0) {
        validate_numeric_value($comment_id);
        validate_numeric_value($type_id);

        $view_data['comment_id'] = $comment_id;

        if ($type === "project") {
            $view_data['project_id'] = $type_id;
        } else if ($type === "task") {
            $view_data['task_id'] = $type_id;
        } else if ($type === "file") {
            $view_data['file_id'] = $type_id;
        } else if ($type == "customer_feedback") {
            $view_data['project_id'] = $type_id;
        }
        return $this->template->view("projects/comments/reply_form", $view_data);
    }

    /* load checklist view */

    function checklist($project_id) {
        validate_numeric_value($project_id);

        $this->init_project_permission_checker($project_id);

        if (!$this->can_view_files()) {
            app_redirect("forbidden");
        }

        $view_data['can_add_files'] = $this->can_add_files();
        $options = array("project_id" => $project_id);
        $view_data['files'] = $this->Project_files_model->get_details($options)->getResult();
        $view_data['project_id'] = $project_id;

        $file_categories = $this->File_category_model->get_details()->getResult();
        $file_categories_dropdown = array(array("id" => "", "text" => "- " . app_lang("category") . " -"));

        if ($file_categories) {
            foreach ($file_categories as $file_category) {
                $file_categories_dropdown[] = array("id" => $file_category->id, "text" => $file_category->name);
            }
        }

        $view_data["file_categories_dropdown"] = json_encode($file_categories_dropdown);

        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("project_files", $this->login_user->is_admin, $this->login_user->user_type);
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("project_files", $this->login_user->is_admin, $this->login_user->user_type);

        return $this->template->view("projects/checklist/index", $view_data);
    }
    /* load files view */

    function files($project_id) {
        validate_numeric_value($project_id);

        $this->init_project_permission_checker($project_id);

        if (!$this->can_view_files()) {
            app_redirect("forbidden");
        }

        $view_data['can_add_files'] = $this->can_add_files();
        $options = array("project_id" => $project_id);
        $view_data['files'] = $this->Project_files_model->get_details($options)->getResult();
        $view_data['project_id'] = $project_id;

        $file_categories = $this->File_category_model->get_details()->getResult();
        $file_categories_dropdown = array(array("id" => "", "text" => "- " . app_lang("category") . " -"));

        if ($file_categories) {
            foreach ($file_categories as $file_category) {
                $file_categories_dropdown[] = array("id" => $file_category->id, "text" => $file_category->name);
            }
        }

        $view_data["file_categories_dropdown"] = json_encode($file_categories_dropdown);

        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("project_files", $this->login_user->is_admin, $this->login_user->user_type);
        $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("project_files", $this->login_user->is_admin, $this->login_user->user_type);

        return $this->template->view("projects/files/index", $view_data);
    }

    function view_file($file_id = 0) {
        validate_numeric_value($file_id);
        $file_info = $this->Project_files_model->get_details(array("id" => $file_id))->getRow();

        if ($file_info) {

            $this->init_project_permission_checker($file_info->project_id);

            if (!$this->can_view_files()) {
                app_redirect("forbidden");
            }

            $view_data['can_comment_on_files'] = $this->can_comment_on_files();

            $file_url = get_source_url_of_file(make_array_of_file($file_info), get_setting("project_file_path") . $file_info->project_id . "/");

            $view_data["file_url"] = $file_url;
            $view_data["is_image_file"] = is_image_file($file_info->file_name);
            $view_data["is_iframe_preview_available"] = is_iframe_preview_available($file_info->file_name);
            $view_data["is_google_preview_available"] = is_google_preview_available($file_info->file_name);
            $view_data["is_viewable_video_file"] = is_viewable_video_file($file_info->file_name);
            $view_data["is_google_drive_file"] = ($file_info->file_id && $file_info->service_type == "google") ? true : false;

            $view_data["file_info"] = $file_info;
            $options = array("file_id" => $file_id, "login_user_id" => $this->login_user->id);
            $view_data['comments'] = $this->Project_comments_model->get_details($options)->getResult();
            $view_data['file_id'] = $file_id;
            $view_data['project_id'] = $file_info->project_id;
            $view_data['current_url'] = get_uri("projects/view_file/" . $file_id);
            return $this->template->view("projects/files/view", $view_data);
        } else {
            show_404();
        }
    }

    /* file upload modal */

    function file_modal_form() {
        $view_data['model_info'] = $this->Project_files_model->get_one($this->request->getPost('id'));
        $project_id = $this->request->getPost('project_id') ? $this->request->getPost('project_id') : $view_data['model_info']->project_id;

        $view_data["custom_fields"] = $this->Custom_fields_model->get_combined_details("project_files", $view_data['model_info']->id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();

        $this->init_project_permission_checker($project_id);

        if (!$this->can_add_files()) {
            app_redirect("forbidden");
        }

        $view_data['project_id'] = $project_id;

        $file_categories = $this->File_category_model->get_details()->getResult();
        $file_categories_dropdown = array("" => "-");

        if ($file_categories) {
            foreach ($file_categories as $file_category) {
                $file_categories_dropdown[$file_category->id] = $file_category->name;
            }
        }

        $view_data["file_categories_dropdown"] = $file_categories_dropdown;

        return $this->template->view('projects/files/modal_form', $view_data);
    }

    /* save project file data and move temp file to parmanent file directory */

    function save_file() {

        $project_id = $this->request->getPost('project_id');
        $category_id = $this->request->getPost('category_id');

        $this->init_project_permission_checker($project_id);

        if (!$this->can_add_files()) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost('id');

        $files = $this->request->getPost("files");
        $success = false;
        $now = get_current_utc_time();

        $target_path = getcwd() . "/" . get_setting("project_file_path") . $project_id . "/";

        if ($id) {
            $data = array(
                "description" => $this->request->getPost('description'),
                "category_id" => $category_id ? $category_id : 0
            );

            $success = $this->Project_files_model->ci_save($data, $id);
            save_custom_fields("project_files", $success, $this->login_user->is_admin, $this->login_user->user_type);
        } else {
            //process the fiiles which has been uploaded by dropzone
            if ($files && get_array_value($files, 0)) {
                foreach ($files as $file) {
                    $file_name = $this->request->getPost('file_name_' . $file);
                    $file_info = move_temp_file($file_name, $target_path, "");
                    if ($file_info) {
                        $data = array(
                            "project_id" => $project_id,
                            "file_name" => get_array_value($file_info, 'file_name'),
                            "file_id" => get_array_value($file_info, 'file_id'),
                            "service_type" => get_array_value($file_info, 'service_type'),
                            "description" => $this->request->getPost('description_' . $file),
                            "file_size" => $this->request->getPost('file_size_' . $file),
                            "created_at" => $now,
                            "uploaded_by" => $this->login_user->id,
                            "category_id" => $category_id ? $category_id : 0
                        );

                        $data = clean_data($data);

                        $success = $this->Project_files_model->ci_save($data);
                        save_custom_fields("project_files", $success, $this->login_user->is_admin, $this->login_user->user_type);
                        log_notification("project_file_added", array("project_id" => $project_id, "project_file_id" => $success));
                    } else {
                        $success = false;
                    }
                }
            }
            //process the files which has been submitted manually
            if ($_FILES) {
                $files = $_FILES['manualFiles'];
                if ($files && count($files) > 0) {
                    $description = $this->request->getPost('description');
                    foreach ($files["tmp_name"] as $key => $file) {
                        $temp_file = $file;
                        $file_name = $files["name"][$key];
                        $file_size = $files["size"][$key];

                        $file_info = move_temp_file($file_name, $target_path, "", $temp_file);
                        if ($file_info) {
                            $data = array(
                                "project_id" => $project_id,
                                "file_name" => get_array_value($file_info, 'file_name'),
                                "file_id" => get_array_value($file_info, 'file_id'),
                                "service_type" => get_array_value($file_info, 'service_type'),
                                "description" => get_array_value($description, $key),
                                "file_size" => $file_size,
                                "created_at" => $now,
                                "uploaded_by" => $this->login_user->id
                            );
                            $success = $this->Project_files_model->ci_save($data);
                            save_custom_fields("project_files", $success, $this->login_user->is_admin, $this->login_user->user_type);
                            log_notification("project_file_added", array("project_id" => $project_id, "project_file_id" => $success));
                        }
                    }
                }
            }
        }

        if ($success) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* upload a post file */

    function upload_file() {
        upload_file_to_temp();
    }

    /* check valid file for project */

    function validate_project_file() {
        return validate_post_file($this->request->getPost("file_name"));
    }

    /* delete a file */

    function delete_file() {

        $id = $this->request->getPost('id');
        $info = $this->Project_files_model->get_one($id);

        $this->init_project_permission_checker($info->project_id);

        if (!$this->can_delete_files($info->uploaded_by)) {
            app_redirect("forbidden");
        }

        if ($this->Project_files_model->delete($id)) {

            //delete the files
            $file_path = get_setting("project_file_path");
            delete_app_files($file_path . $info->project_id . "/", array(make_array_of_file($info)));

            log_notification("project_file_deleted", array("project_id" => $info->project_id, "project_file_id" => $id));
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    /* download all project files */
    function download_project_file($project_id) {
        $files_info = $this->Project_files_model->get_all_where(array("project_id" => $project_id, "deleted" => 0))->getResult();

        if (count($files_info) > 0) {
            $project_id = 0;
            $file_path_array = array();
            foreach ($files_info as $file_info) {
                //we have to check the permission for each file
                //initialize the permission check only if the project id is different
    
                if ($project_id != $file_info->project_id) {
                    $this->init_project_permission_checker($file_info->project_id);
                    $project_id = $file_info->project_id;
                }
    
                if (!$this->can_view_files()) {
                    app_redirect("forbidden");
                }
    
                $file_path_array[] = array("file_name" => $file_info->project_id . "/" . $file_info->file_name, "file_id" => $file_info->file_id, "service_type" => $file_info->service_type);
    
            }
            
            $serialized_file_data = serialize($file_path_array);
    
            return $this->download_app_files(get_setting("project_file_path"), $serialized_file_data);
        }
        return '<script>window.close();</script>';
        // app_redirect("projects/view/" . $project_id);
    }
    /* download a file */

    function download_file($id) {

        $file_info = $this->Project_files_model->get_one($id);

        $this->init_project_permission_checker($file_info->project_id);
        if (!$this->can_view_files()) {
            app_redirect("forbidden");
        }

        //serilize the path
        $file_data = serialize(array(array("file_name" => $file_info->project_id . "/" . $file_info->file_name, "file_id" => $file_info->file_id, "service_type" => $file_info->service_type)));

        //delete the file
        return $this->download_app_files(get_setting("project_file_path"), $file_data);
    }

    /* download multiple files as zip */

    function download_multiple_files($files_ids = "") {

        if ($files_ids) {


            $files_ids_array = explode('-', $files_ids);

            $files = $this->Project_files_model->get_files($files_ids_array);

            if ($files) {
                $file_path_array = array();
                $project_id = 0;

                foreach ($files->getResult() as $file_info) {

                    //we have to check the permission for each file
                    //initialize the permission check only if the project id is different

                    if ($project_id != $file_info->project_id) {
                        $this->init_project_permission_checker($file_info->project_id);
                        $project_id = $file_info->project_id;
                    }

                    if (!$this->can_view_files()) {
                        app_redirect("forbidden");
                    }

                    $file_path_array[] = array("file_name" => $file_info->project_id . "/" . $file_info->file_name, "file_id" => $file_info->file_id, "service_type" => $file_info->service_type);
                }

                $serialized_file_data = serialize($file_path_array);

                return $this->download_app_files(get_setting("project_file_path"), $serialized_file_data);
            }
        }
    }

    /* download files by zip */

    function download_comment_files($id) {

        $info = $this->Project_comments_model->get_one($id);

        $this->init_project_permission_checker($info->project_id);
        if ($this->login_user->user_type == "client" && !$this->is_clients_project) {
            app_redirect("forbidden");
        } else if ($this->login_user->user_type == "user" && !$this->is_user_a_project_member) {
            app_redirect("forbidden");
        }

        return $this->download_app_files(get_setting("timeline_file_path"), $info->files);
    }

    /* list of files, prepared for datatable  */

    function files_list_data($project_id = 0) {
        validate_numeric_value($project_id);
        $this->init_project_permission_checker($project_id);

        if (!$this->can_view_files()) {
            app_redirect("forbidden");
        }

        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("project_files", $this->login_user->is_admin, $this->login_user->user_type);

        $options = array(
            "project_id" => $project_id,
            "category_id" => $this->request->getPost("category_id"),
            "custom_fields" => $custom_fields,
            "custom_field_filter" => $this->prepare_custom_field_filter_values("project_files", $this->login_user->is_admin, $this->login_user->user_type)
        );

        $list_data = $this->Project_files_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_file_row($data, $custom_fields);
        }
        echo json_encode(array("data" => $result));
    }

    /* prepare a row of file list table */

    private function _make_file_row($data, $custom_fields) {
        $file_icon = get_file_icon(strtolower(pathinfo($data->file_name, PATHINFO_EXTENSION)));

        $image_url = get_avatar($data->uploaded_by_user_image);
        $uploaded_by = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $data->uploaded_by_user_name";

        if ($data->uploaded_by_user_type == "staff") {
            $uploaded_by = get_team_member_profile_link($data->uploaded_by, $uploaded_by);
        } else {
            $uploaded_by = get_client_contact_profile_link($data->uploaded_by, $uploaded_by);
        }

        $description = "<div class='float-start text-wrap'>" .
                js_anchor(remove_file_prefix($data->file_name), array('title' => "", "data-toggle" => "app-modal", "data-sidebar" => "1", "data-url" => get_uri("projects/view_file/" . $data->id)));

        if ($data->description) {
            $description .= "<br /><span class='text-wrap'>" . $data->description . "</span></div>";
        } else {
            $description .= "</div>";
        }

        //show checkmark to download multiple files
        $checkmark = js_anchor("<span class='checkbox-blank mr15 float-start'></span>", array('title' => "", "class" => "", "data-id" => $data->id, "data-act" => "download-multiple-file-checkbox")) . $data->id;

        $row_data = array(
            $checkmark,
            "<div data-feather='$file_icon' class='mr10 float-start'></div>" . $description,
            $data->category_name ? $data->category_name : "-",
            convert_file_size($data->file_size),
            $uploaded_by,
            format_to_datetime($data->created_at)
        );

        foreach ($custom_fields as $field) {
            $cf_id = "cfv_" . $field->id;
            $row_data[] = $this->template->view("custom_fields/output_" . $field->field_type, array("value" => $data->$cf_id));
        }

        $options = anchor(get_uri("projects/download_file/" . $data->id), "<i data-feather='download-cloud' class='icon-16'></i>", array("title" => app_lang("download")));
        if ($this->can_add_files()) {
            $options .= modal_anchor(get_uri("projects/file_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_files'), "data-post-id" => $data->id));
        }
        if ($this->can_delete_files($data->uploaded_by)) {
            $options .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_file'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete_file"), "data-action" => "delete-confirmation"));
        }

        $row_data[] = $options;

        return $row_data;
    }

    /* load notes view */

    function notes($project_id) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        $view_data['project_id'] = $project_id;
        return $this->template->view("projects/notes/index", $view_data);
    }

    /* load history view */

    function history($offset = 0, $log_for = "", $log_for_id = "", $log_type = "", $log_type_id = "") {
        if ($this->login_user->user_type !== "staff" && ($this->login_user->user_type == "client" && get_setting("client_can_view_activity") !== "1")) {
            app_redirect("forbidden");
        }

        $view_data['offset'] = $offset;
        $view_data['activity_logs_params'] = array("log_for" => $log_for, "log_for_id" => $log_for_id, "log_type" => $log_type, "log_type_id" => $log_type_id, "limit" => 20, "offset" => $offset);
        return $this->template->view("projects/history/index", $view_data);
    }

    /* load project members view */

    function members($project_id = 0) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        $view_data['project_id'] = $project_id;
        return $this->template->view("projects/project_members/index", $view_data);
    }

    /* load payments tab  */

    function payments($project_id) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        if ($project_id) {
            $view_data['project_info'] = $this->Projects_model->get_details(array("id" => $project_id))->getRow();
            $view_data['project_id'] = $project_id;
            return $this->template->view("projects/payments/index", $view_data);
        }
    }

    /* load invoices tab  */

    function invoices($project_id, $client_id = 0) {
        $this->access_only_team_members_or_client_contact($client_id);
        validate_numeric_value($project_id);
        if ($project_id) {
            $view_data['project_id'] = $project_id;
            $view_data['project_info'] = $this->Projects_model->get_details(array("id" => $project_id))->getRow();

            $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("invoices", $this->login_user->is_admin, $this->login_user->user_type);
            $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("invoices", $this->login_user->is_admin, $this->login_user->user_type);

            $view_data["can_edit_invoices"] = $this->can_edit_invoices();

            return $this->template->view("projects/invoices/index", $view_data);
        }
    }

    /* load expenses tab  */

    function expenses($project_id) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        if ($project_id) {
            $view_data['project_id'] = $project_id;

            $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("expenses", $this->login_user->is_admin, $this->login_user->user_type);
            $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("expenses", $this->login_user->is_admin, $this->login_user->user_type);

            return $this->template->view("projects/expenses/index", $view_data);
        }
    }

    //save project status
    function change_status($project_id, $status_id) {
        if ($project_id && $this->can_edit_projects() && $status_id) {
            validate_numeric_value($project_id);
            validate_numeric_value($status_id);
            $status_data = array("status_id" => $status_id);
            $save_id = $this->Projects_model->ci_save($status_data, $project_id);

            //send notification
            if ($status_id == 2) {
                log_notification("project_completed", array("project_id" => $save_id));
            }
        }
    }

    /* load project settings modal */

    function settings_modal_form() {
        $project_id = $this->request->getPost('project_id');

        $can_edit_timesheet_settings = $this->can_edit_timesheet_settings($project_id);
        $can_edit_slack_settings = $this->can_edit_slack_settings();
        $can_create_projects = $this->can_create_projects();

        if (!$project_id || !($can_edit_timesheet_settings || $can_edit_slack_settings || $can_create_projects)) {
            app_redirect("forbidden");
        }


        $this->init_project_settings($project_id);

        $view_data['project_id'] = $project_id;
        $view_data['can_edit_timesheet_settings'] = $can_edit_timesheet_settings;
        $view_data['can_edit_slack_settings'] = $can_edit_slack_settings;
        $view_data["can_create_projects"] = $this->can_create_projects();

        $task_statuses_dropdown = array();
        $task_statuses = $this->Task_status_model->get_details()->getResult();
        foreach ($task_statuses as $task_status) {
            $task_statuses_dropdown[] = array("id" => $task_status->id, "text" => $task_status->key_name ? app_lang($task_status->key_name) : $task_status->title);
        }

        $view_data["task_statuses_dropdown"] = json_encode($task_statuses_dropdown);
        $view_data["project_info"] = $this->Projects_model->get_one($project_id);

        return $this->template->view('projects/settings/modal_form', $view_data);
    }

    /* save project settings */

    function save_settings() {
        $project_id = $this->request->getPost('project_id');

        $can_edit_timesheet_settings = $this->can_edit_timesheet_settings($project_id);
        $can_edit_slack_settings = $this->can_edit_slack_settings();
        $can_create_projects = $this->can_create_projects();

        if (!$project_id || !($can_edit_timesheet_settings || $can_edit_slack_settings || $can_create_projects)) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "project_id" => "required|numeric"
        ));

        $settings = array();
        if ($can_edit_timesheet_settings) {
            $settings[] = "client_can_view_timesheet";
        }

        if ($can_edit_slack_settings) {
            $settings[] = "project_enable_slack";
            $settings[] = "project_slack_webhook_url";
        }

        if ($can_create_projects) {
            $settings[] = "remove_task_statuses";
        }

        foreach ($settings as $setting) {
            $value = $this->request->getPost($setting);
            if (!$value) {
                $value = "";
            }

            $this->Project_settings_model->save_setting($project_id, $setting, $value);
        }

        //send test message
        if ($can_edit_slack_settings && $this->request->getPost("send_a_test_message")) {
            helper('notifications');
            if (send_slack_notification("test_slack_notification", $this->login_user->id, 0, $this->request->getPost("project_slack_webhook_url"))) {
                echo json_encode(array("success" => true, 'message' => app_lang('settings_updated')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('slack_notification_error_message')));
            }
        } else {
            echo json_encode(array("success" => true, 'message' => app_lang('settings_updated')));
        }
    }

    /* get member suggestion with start typing '@' */

    function get_member_suggestion_to_mention() {

        $this->validate_submitted_data(array(
            "project_id" => "required|numeric"
        ));

        $project_id = $this->request->getPost("project_id");

        $project_members = $this->Project_members_model->get_project_members_dropdown_list($project_id, "", $this->can_access_clients(true))->getResult();
        $project_members_dropdown = array();
        foreach ($project_members as $member) {
            $project_members_dropdown[] = array("name" => $member->member_name, "content" => "@[" . $member->member_name . " :" . $member->user_id . "]");
        }

        if ($project_members_dropdown) {
            echo json_encode(array("success" => TRUE, "data" => $project_members_dropdown));
        } else {
            echo json_encode(array("success" => FALSE));
        }
    }

    //reset projects dropdown on changing of client 
    function get_projects_of_selected_client_for_filter() {
        $this->access_only_team_members();
        $client_id = $this->request->getPost("client_id");
        if ($client_id) {
            $projects = $this->Projects_model->get_all_where(array("client_id" => $client_id, "deleted" => 0), 0, 0, "title")->getResult();
            $projects_dropdown = array(array("id" => "", "text" => "- " . app_lang("project") . " -"));
            foreach ($projects as $project) {
                $projects_dropdown[] = array("id" => $project->id, "text" => $project->title);
            }
            echo json_encode($projects_dropdown);
        } else {
            //we have show all projects by de-selecting client
            echo json_encode($this->_get_all_projects_dropdown_list());
        }
    }

    //get clients dropdown
    private function _get_clients_dropdown() {
        $clients_dropdown = array(array("id" => "", "text" => "- " . app_lang("client") . " -"));
        $clients = $this->Clients_model->get_dropdown_list(array("charter_name"), "id", array("is_lead" => 0));
        foreach ($clients as $key => $value) {
            $clients_dropdown[] = array("id" => $key, "text" => $value);
        }
        return $clients_dropdown;
    }

    //show timesheets chart
    function timesheet_chart($project_id = 0) {
        validate_numeric_value($project_id);
        $members = $this->_get_members_to_manage_timesheet();

        $view_data['members_dropdown'] = json_encode($this->_prepare_members_dropdown_for_timesheet_filter($members));
        $view_data['projects_dropdown'] = json_encode($this->_get_all_projects_dropdown_list_for_timesheets_filter());
        $view_data["project_id"] = $project_id;

        return $this->template->view("projects/timesheets/timesheet_chart", $view_data);
    }

    //timesheets chart data
    function timesheet_chart_data($project_id = 0) {
        if (!$project_id) {
            $project_id = $this->request->getPost("project_id");
        }

        validate_numeric_value($project_id);

        $this->init_project_permission_checker($project_id);
        $this->init_project_settings($project_id); //since we'll check this permission project wise

        if (!$this->can_view_timesheet($project_id, true)) {
            app_redirect("forbidden");
        }

        $timesheets = array();
        $timesheets_array = array();
        $ticks = array();

        $start_date = $this->request->getPost("start_date");
        $end_date = $this->request->getPost("end_date");
        $user_id = $this->request->getPost("user_id");

        $options = array(
            "start_date" => $start_date,
            "end_date" => $end_date,
            "user_id" => $user_id,
            "project_id" => $project_id
        );

        //get allowed member ids
        $members = $this->_get_members_to_manage_timesheet();
        if ($members != "all" && $this->login_user->user_type == "staff") {
            //if user has permission to access all members, query param is not required
            //client can view all timesheet
            $options["allowed_members"] = $members;
        }

        $timesheets_result = $this->Timesheets_model->get_timesheet_statistics($options)->timesheets_data;
        $timesheet_users_result = $this->Timesheets_model->get_timesheet_statistics($options)->timesheet_users_data;

        $user_result = array();
        foreach ($timesheet_users_result AS $user) {
            $time = convert_seconds_to_time_format($user->total_sec);
            $user_result[] = "<div class='user-avatar avatar-30 avatar-circle' data-bs-toggle='tooltip' title='" . $user->user_name . " - " . $time . "'><img alt='' src='" . get_avatar($user->user_avatar) . "'></div>";
        }

        $days_of_month = date("t", strtotime($start_date));

        for ($i = 1; $i <= $days_of_month; $i++) {
            $timesheets[$i] = 0;
        }

        foreach ($timesheets_result as $value) {
            $timesheets[$value->day * 1] = $value->total_sec / 60 / 60;
        }

        foreach ($timesheets as $value) {
            $timesheets_array[] = $value;
        }

        for ($i = 1; $i <= $days_of_month; $i++) {
            $ticks[] = $i;
        }

        echo json_encode(array("timesheets" => $timesheets_array, "ticks" => $ticks, "timesheet_users_result" => $user_result));
    }

    function like_comment($comment_id = 0) {
        if ($comment_id) {
            validate_numeric_value($comment_id);
            $data = array(
                "project_comment_id" => $comment_id,
                "created_by" => $this->login_user->id
            );

            $existing = $this->Likes_model->get_one_where(array_merge($data, array("deleted" => 0)));
            if ($existing->id) {
                //liked already, unlike now
                $this->Likes_model->delete($existing->id);
            } else {
                //not liked, like now
                $data["created_at"] = get_current_utc_time();
                $this->Likes_model->ci_save($data);
            }

            $options = array("id" => $comment_id, "login_user_id" => $this->login_user->id);
            $comment = $this->Project_comments_model->get_details($options)->getRow();

            return $this->template->view("projects/comments/like_comment", array("comment" => $comment));
        }
    }

    /* load contracts tab  */

    function contracts($project_id) {
        $this->access_only_team_members();
        if ($project_id) {
            $view_data['project_id'] = $project_id;
            $view_data['project_info'] = $this->Projects_model->get_details(array("id" => $project_id))->getRow();

            $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("contracts", $this->login_user->is_admin, $this->login_user->user_type);
            $view_data["custom_field_filters"] = $this->Custom_fields_model->get_custom_field_filters("contracts", $this->login_user->is_admin, $this->login_user->user_type);

            return $this->template->view("projects/contracts/index", $view_data);
        }
    }

    // pin/unpin comments
    function pin_comment($comment_id = 0) {
        if ($comment_id) {
            $data = array(
                "project_comment_id" => $comment_id,
                "pinned_by" => $this->login_user->id
            );

            $existing = $this->Pin_comments_model->get_one_where(array_merge($data, array("deleted" => 0)));

            $save_id = "";
            if ($existing->id) {
                //pinned already, unpin now
                $save_id = $this->Pin_comments_model->delete($existing->id);
            } else {
                //not pinned, pin now
                $data["created_at"] = get_current_utc_time();
                $save_id = $this->Pin_comments_model->ci_save($data);
            }

            if ($save_id) {
                $options = array("id" => $save_id);
                $pinned_comments = $this->Pin_comments_model->get_details($options)->getResult();

                $status = "pinned";

                $save_data = $this->template->view("projects/comments/pinned_comments", array("pinned_comments" => $pinned_comments));
                echo json_encode(array("success" => true, "data" => $save_data, "status" => $status));
            } else {
                echo json_encode(array("success" => false));
            }
        }
    }

    /* load tickets tab  */

    function tickets($project_id) {
        $this->access_only_team_members();
        if ($project_id) {
            validate_numeric_value($project_id);
            $view_data['project_id'] = $project_id;

            $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("tickets", $this->login_user->is_admin, $this->login_user->user_type);

            return $this->template->view("projects/tickets/index", $view_data);
        }
    }

    function file_category($project_id = 0) {
        $this->access_only_team_members();
        validate_numeric_value($project_id);
        $this->init_project_permission_checker($project_id);
        if (!$this->can_view_files()) {
            app_redirect("forbidden");
        }

        $view_data["project_id"] = $project_id;
        $view_data['can_add_files'] = $this->can_add_files();
        return $this->template->view("projects/files/category/index", $view_data);
    }

    function file_category_list_data($project_id = 0) {
        $this->access_only_team_members();
        validate_numeric_value($project_id);
        $this->init_project_permission_checker($project_id);
        if (!$this->can_view_files()) {
            app_redirect("forbidden");
        }

        $options = array("type" => "project");
        $list_data = $this->File_category_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_file_category_row($data, $project_id);
        }

        echo json_encode(array("data" => $result));
    }

    private function _file_category_row_data($id, $project_id = 0) {
        $options = array("id" => $id);
        $data = $this->File_category_model->get_details($options)->getRow();

        return $this->_make_file_category_row($data, $project_id);
    }

    private function _make_file_category_row($data, $project_id = 0) {
        $options = "";
        if ($this->can_add_files()) {
            $options .= modal_anchor(get_uri("projects/file_category_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_category'), "data-post-id" => $data->id, "data-post-project_id" => $project_id));
        }

        if ($this->can_delete_files()) {
            $options .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_category'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete_file_category"), "data-action" => "delete", "data-post-project_id" => $project_id));
        }

        return array(
            $data->name,
            $options
        );
    }

    function file_category_modal_form() {
        $this->access_only_team_members();
        $project_id = $this->request->getPost('project_id');
        $this->init_project_permission_checker($project_id);
        if (!$this->can_add_files()) {
            app_redirect("forbidden");
        }

        $view_data['model_info'] = $this->File_category_model->get_one($this->request->getPost('id'));
        $view_data['project_id'] = $project_id;
        return $this->template->view('projects/files/category/modal_form', $view_data);
    }

    function save_file_category() {
        $this->access_only_team_members();
        $project_id = $this->request->getPost('project_id');
        $this->init_project_permission_checker($project_id);
        if (!$this->can_add_files()) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost("id");

        $data = array(
            "name" => $this->request->getPost('name'),
            "type" => "project"
        );

        $save_id = $this->File_category_model->ci_save($data, $id);

        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_file_category_row_data($save_id, $project_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {

            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    function delete_file_category() {
        $this->access_only_team_members();
        $project_id = $this->request->getPost('project_id');
        $this->init_project_permission_checker($project_id);
        if (!$this->can_delete_files()) {
            app_redirect("forbidden");
        }

        $id = $this->request->getPost('id');

        if ($this->request->getPost('undo')) {
            if ($this->File_category_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_file_category_row_data($id, $project_id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->File_category_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* delete multiple files */

    function delete_multiple_files($files_ids = "") {

        if ($files_ids) {

            $files_ids_array = explode('-', $files_ids);
            $files = $this->Project_files_model->get_files($files_ids_array)->getResult();
            $is_success = true;
            $is_permission_success = true;
            $project_id = get_array_value($files, 0)->project_id;
            $this->init_project_permission_checker($project_id);

            foreach ($files as $file) {

                if (!$this->can_delete_files($file->uploaded_by)) {
                    $is_permission_success = false;
                    continue; //continue to the next file
                }

                if ($this->Project_files_model->delete($file->id)) {

                    //delete the files
                    $file_path = get_setting("project_file_path");
                    delete_app_files($file_path . $file->project_id . "/", array(make_array_of_file($file)));

                    log_notification("project_file_deleted", array("project_id" => $file->project_id, "project_file_id" => $file->id));
                } else {
                    $is_success = false;
                }
            }

            if ($is_success && $is_permission_success) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                if (!$is_permission_success) {
                    echo json_encode(array("success" => false, 'message' => app_lang('file_delete_permission_error_message')));
                } else {
                    echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
                }
            }
        }
    }

    private function has_client_feedback_access_permission() {
        if ($this->login_user->user_type != "client") {
            if ($this->login_user->is_admin || get_array_value($this->login_user->permissions, "client_feedback_access_permission") || $this->can_manage_all_projects()) {
                return true;
            }
        }
    }

    function show_my_open_timers() {
        $timers = $this->Timesheets_model->get_open_timers($this->login_user->id);
        $view_data["timers"] = $timers->getResult();
        return $this->template->view("projects/open_timers", $view_data);
    }

    function task_timesheet($task_id, $project_id) {
        validate_numeric_value($task_id);
        validate_numeric_value($project_id);

        $this->init_project_permission_checker($project_id);
        $this->init_project_settings($project_id);

        if (!$this->can_view_timesheet($project_id, true)) {
            app_redirect("forbidden");
        }
        $options = array(
            "project_id" => $project_id,
            "status" => "none_open",
            "task_id" => $task_id,
        );

        //get allowed member ids
        $members = $this->_get_members_to_manage_timesheet();
        if ($members != "all" && $this->login_user->user_type == "staff") {
            //if user has permission to access all members, query param is not required
            //client can view all timesheet
            $options["allowed_members"] = $members;
        }

        $view_data['task_timesheet'] = $this->Timesheets_model->get_details($options)->getResult();
        return $this->template->view("tasks/task_timesheet", $view_data);
    }

    //for old notifications, redirect to tasks/view

    function task_view($task_id = 0) {
        if ($task_id) {
            app_redirect("tasks/view/" . $task_id);
        }
    }

    function team_members_summary() {
        if (!$this->can_manage_all_projects()) {
            app_redirect("forbidden");
        }

        $view_data["project_status_text_info"] = get_project_status_text_info();
        $view_data["show_time_logged_data"] = get_setting("module_project_timesheet") ? 1 : 0;

        return $this->template->rander("projects/reports/team_members_summary", $view_data);
    }

    function team_members_summary_data() {
        if (!$this->can_manage_all_projects()) {
            app_redirect("forbidden");
        }
        $options = array(
            "start_date_from" => $this->request->getPost("start_date_from"),
            "start_date_to" => $this->request->getPost("start_date_to")
        );

        $list_data = $this->Projects_model->get_team_members_summary($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_team_members_summary_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _make_team_members_summary_row($data) {
        $image_url = get_avatar($data->image);
        $member = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $data->team_member_name";

        $duration = convert_seconds_to_time_format($data->total_secconds_worked);

        $row_data = array(
            get_team_member_profile_link($data->team_member_id, $member),
            $data->open_projects,
            $data->completed_projects,
            $data->hold_projects,
            $data->open_tasks,
            $data->completed_tasks,
            $duration,
            to_decimal_format(convert_time_string_to_decimal($duration)),
        );

        return $row_data;
    }

    function clients_summary() {
        if (!$this->can_manage_all_projects()) {
            app_redirect("forbidden");
        }
        $view_data["project_status_text_info"] = get_project_status_text_info();
        $view_data["show_time_logged_data"] = get_setting("module_project_timesheet") ? 1 : 0;

        return $this->template->view("projects/reports/clints_summary", $view_data);
    }

    function clients_summary_data() {
        if (!$this->can_manage_all_projects()) {
            app_redirect("forbidden");
        }
        $options = array(
            "start_date_from" => $this->request->getPost("start_date_from"),
            "start_date_to" => $this->request->getPost("start_date_to")
        );

        $list_data = $this->Projects_model->get_clients_summary($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_clients_summary_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _make_clients_summary_row($data) {


        $client_name = anchor(get_uri("clients/view/" . $data->client_id), $data->client_name);

        $duration = convert_seconds_to_time_format($data->total_secconds_worked);

        $row_data = array(
            $client_name,
            $data->open_projects ? $data->open_projects : 0,
            $data->completed_projects ? $data->completed_projects : 0,
            $data->hold_projects ? $data->hold_projects : 0,
            $data->open_tasks ? $data->open_tasks : 0,
            $data->completed_tasks ? $data->completed_tasks : 0,
            $duration,
            to_decimal_format(convert_time_string_to_decimal($duration)),
        );

        return $row_data;
    }

    private function client_can_view_tasks() {
        if ($this->login_user->user_type != "staff") {
            //check settings for client's project permission
            if (get_setting("client_can_view_tasks")) {
                //even the settings allow to create/edit task, the client can only create their own project's tasks
                return $this->is_clients_project;
            }
        }
    }

    /** project supplier */
    /* load project members add/edit modal */

    function project_supplier_modal_form() {
        $view_data['model_info'] = $this->Project_supplier_model->get_one($this->request->getPost('id'));
        $project_id = $this->request->getPost('project_id') ? $this->request->getPost('project_id') : $view_data['model_info']->project_id;
        $this->init_project_permission_checker($project_id);

        $view_data['project_id'] = $project_id;

        return $this->template->view('projects/supplier_contacts/modal_form', $view_data);
    }

    /* add a project members  */

    function save_project_supplier() {
        $project_id = $this->request->getPost('project_id');

        $this->init_project_permission_checker($project_id);

        if (!$this->can_add_remove_project_members()) {
            app_redirect("forbidden");
        }

        $this->validate_submitted_data(array(
            "supplier" => "required",
            "contact_person" => "required",
        ));

        $id = $this->request->getPost('id');
        $data = array(
            "project_id" => $project_id,
            "supplier" => $this->request->getPost('supplier'),
            "contact_person" => $this->request->getPost('contact_person'),
            "email" => $this->request->getPost('email'),
            "phone" => $this->request->getPost('phone'),
            "mobile" => $this->request->getPost('mobile'),
            "description" => $this->request->getPost('description')
        );

        $save_id = $this->Project_supplier_model->ci_save($data, $id);
        
        if ($save_id) {
            echo json_encode(array("success" => true, 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete/undo a project members  */

    function delete_project_supplier() {
        $id = $this->request->getPost('id');
        $project_supplier_info = $this->Project_supplier_model->get_one($id);

        $this->init_project_permission_checker($project_supplier_info->project_id);
        if (!$this->can_add_remove_project_members()) {
            app_redirect("forbidden");
        }


        if ($this->request->getPost('undo')) {
            if ($this->Project_supplier_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_project_supplier_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Project_supplier_model->delete($id)) {

                $project_supplier_info = $this->Project_supplier_model->get_one($id);

                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of project members, prepared for datatable  */

    function project_supplier_list_data($project_id = 0) {
        validate_numeric_value($project_id);
        $this->access_only_team_members();
        $this->init_project_permission_checker($project_id);

        $options = array("project_id" => $project_id);
        $list_data = $this->Project_supplier_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_project_supplier_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of project supplier list */

    private function _project_supplier_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Project_supplier_model->get_details($options)->getRow();
        return $this->_make_project_supplier_row($data);
    }

    /* prepare a row of project supplier list */

    private function _make_project_supplier_row($data) {
        $link = '';
        if ($this->can_add_remove_project_members()) {
            $delete_link = modal_anchor(get_uri("projects/project_supplier_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_supplier_contact'), "data-post-id" => $data->id)) 
            . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_member'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete_project_supplier"), "data-action" => "delete"));

            $link .= $delete_link;
        }

        $member = '<div class="p-2 w-100"><div>' . $data->supplier . '</div><div>' . $data->contact_person . '</div><label class="text-off">' . $data->email . '</label></div>';

        return array($member, $link);
    }
    //////////////////////////
    //////////////////////////
    function add_yard($project_id){
        $allYardTitles=$this->Shipyards_model->get_dropdown_list(['name']);
        $allYardIds=$this->Shipyards_model->get_dropdown_list(['id']);
        return $this->template->rander('projects/comparison/add-yard',['project_id'=>$project_id,'allYardTitles'=>$allYardTitles,'allYardIds'=>$allYardIds]);
    }
    function yard_settings($yard_id){
        return $this->template->rander('projects/comparison/settings.php');
    }
    function save_yard(){
        $id=$this->request->getPost('id');
        $selectedYard=$this->Shipyards_model->get_one($this->request->getPost('shipyard_id'))->id;
        $yardcounts=$this->Project_yards_model->getCount("project_id",$this->request->getPost('project_id'));
        $project_info=$this->Projects_model->get_one($this->request->getPost('project_id'));
        // if($yardcounts==0){
            $project_info->status_id=3;
            $this->Projects_model->ci_save($project_info,$project_info->id);
        // }
        $save_data=array(
            "project_id"=>$this->request->getPost('project_id'),
            'shipyard_id'=>$this->request->getPost('shipyard_id'),
            'work_orders'=>'',
            'title'=>$this->request->getPost('title')
        );
        $save_id=$this->Project_yards_model->ci_save($save_data,$id);
        $allCostItemCurrencies=$this->Task_cost_items_model->get_dropdown_list(array("currency"), "currency", array("project_id"=>$this->request->getPost('project_id')));
        if(!isset($project_info->currency)) $project_info->currency="USD";
        foreach($allCostItemCurrencies as $oneCurrency){
            if($oneCurrency==$project_info->currency) continue;
            $newRateData=array(
                "from"=>$oneCurrency,
                "to"=>$project_info->currency,
                "rate"=>1,
                "project_id"=>$project_info->id
            );
            $this->Project_currency_rates_model->ci_save($newRateData);
        }
        if($save_id)
            return json_encode(array("success"=>true,"save_id"=>$save_id));
        else return json_encode(array("success"=>false));

    }
    function comparison_tab($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        $allProjectTasks=$this->Tasks_model->get_all_where(array('project_id'=>$project_id,"deleted"=>0))->getResult();
        $allYards=$this->Project_yards_model->get_all_where(array("project_id"=>$project_id))->getResult();
        // $selectedYards=array_filter($allYards,function($oneYard){
        //     return $oneYard->selected==1;
        // });
        // if(count($selectedYards)>0) $allYards=$selectedYards;
        $allCostItems=$this->Task_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        $allCurrencyRates=$this->Project_currency_rates_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allYardCostItems=$this->Shipyard_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        return $this->template->view("projects/comparison/comparison_view",["allCostItems"=>$allCostItems,"allCurrencyRates"=>$allCurrencyRates,"allYardCostItems"=>$allYardCostItems,"allProjectTasks"=>$allProjectTasks,"project_info"=>$project_info,"allYards"=>$allYards]);
    }
    function modal_yard_cost_items($task_id){
        $project_id=$this->Tasks_model->get_one($task_id)->project_id;
        $project_info=$this->Projects_model->get_one($project_id);
        $allProjectYards=$this->Project_yards_model->get_all_where(array('project_id'=>$project_id))->getResult();
        $allYardCostItems=$this->Shipyard_cost_items_model->get_all_with_costs_where(array('task_id'=>$task_id))->getResult();
        return $this->template->view("projects/comparison/modal_yard_cost_items",["project_info"=>$project_info,'project_id'=>$project_id,'task_id'=>$task_id,'allProjectYards'=>$allProjectYards,'allYardCostItems'=>$allYardCostItems]);
    }
    function save_yard_cost_item(){
        $id=$this->request->getPost('id');
        $task_id=$this->request->getPost('task_id');
        $project_info=$this->Projects_model->get_one($this->request->getPost('project_id'));
        $saveData=array(
            "task_id"=>$this->request->getPost('task_id'),
            "shipyard_id"=>$this->request->getPost('shipyard_id'),
            "project_id"=>$this->request->getPost('project_id'),
            "name"=>$this->request->getPost('name'),
            "description"=>$this->request->getPost('description'),
            "quantity"=>$this->request->getPost('quantity'),
            "measurement"=>$this->request->getPost("measurement"),
            "unit_price"=>$this->request->getPost('unit_price'),
            "currency"=>$project_info->currency,
            "discount"=>$this->request->getPost('discount'),
            "yard_remarks"=>$this->request->getPost('yard_remarks'),
        );
        $saved_id=$this->Shipyard_cost_items_model->ci_save($saveData,$id);
        return json_encode(array("success"=>true,"saved_id"=>$saved_id));
    }
    function download_yard_xlsx($shipyard_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $project_yard=$this->Project_yards_model->get_one($shipyard_id);
        $project_info=$this->Projects_model->get_one($project_yard->project_id);
        $allYardCostItems=$this->Shipyard_cost_items_model->get_all_where(array("shipyard_id"=>$shipyard_id))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Read me');
        $sheet1->setCellValue('A1', 'About the quotation form');
        $sheet1->setCellValue('A3', 'General');
        $sheet1->setCellValue('A4', 'This quotation form is generated via Peerfleet ('.get_uri("").').');
        $sheet1->setCellValue('A5', 'It contains all the necessary functionality required by the shipyard providing a quotation.');
        $sheet1->setCellValue('A7', 'The shipyard understands that this quotation form must be read and understood in connection with the project specification PDF sent along with it.');
        $sheet1->setCellValue('A8', 'The project specification PDF contains all the detailed specifications about the work scope.');
        $sheet1->setCellValue('A10', 'The shipyard also accepts that, if selected, billed and/or final costs should be provided to the owner in this same format.');
        $sheet1->setCellValue('A13', 'How to use');
        $sheet1->setCellValue('A14', 'For a quick and easy intro, please view this video.(ctrl + click to view)');
        $sheet1->setCellValue('A16', 'For additional information, please see this article.(ctrl + click to view)');
        $sheet1->setCellValue('A19', 'Support');
        $sheet1->setCellValue('A20', "If you have any questions at all, please reach out to Maindeck's support team directly.(ctrl + click to view)");
        // $sheet1->setCellValue('A21', '+47 91999771');

        // Add data to the second worksheet
        $sheet1 = $spreadsheet->createSheet();
        $sheet1->setTitle('Cost items');
        $sheet1->setCellValue('A1', 'SFI Code');
        $sheet1->setCellValue('B1', 'WO name');
        $sheet1->setCellValue('C1', 'Group');
        $sheet1->setCellValue('D1', 'Cost item');
        $sheet1->setCellValue('E1', 'Description');
        $sheet1->setCellValue('F1', 'Cost type');
        $sheet1->setCellValue('G1', 'Est. quantity');
        $sheet1->setCellValue('H1', 'Measurement unit');
        $sheet1->setCellValue('I1', 'Unit price');
        $sheet1->setCellValue('J1', 'Unit price currency');
        $sheet1->setCellValue('K1', 'Quote');
        $sheet1->setCellValue('L1', 'Discount (0-100%)');
        $sheet1->setCellValue('M1', 'Discounted quote');
        $sheet1->setCellValue('N1', 'Yard remarks');
        $sheet1->setCellValue('O1', 'Cost ID');
        $sheet1->setCellValue('P1', 'WO ID');
        $rowNumber=2;
        foreach ($allYardCostItems as $oneItem) {
            $task_info=$this->Tasks_model->get_one($oneItem->task_id);
            $sheet1->setCellValue('A'.$rowNumber, '');
            $sheet1->setCellValue('B'.$rowNumber, $task_info->title);
            $sheet1->setCellValue('C'.$rowNumber, $task_info->category);
            $sheet1->setCellValue('D'.$rowNumber, $oneItem->name);
            $sheet1->setCellValue('E'.$rowNumber, $oneItem->description);
            $sheet1->setCellValue('F'.$rowNumber, $oneItem->quote_type);
            $sheet1->setCellValue('G'.$rowNumber, $oneItem->quantity);
            $sheet1->setCellValue('H'.$rowNumber, $oneItem->measurement);
            $sheet1->setCellValue('I'.$rowNumber, $oneItem->unit_price);
            $sheet1->setCellValue('J'.$rowNumber, $oneItem->currency);
            $sheet1->setCellValue('K'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity);
            $sheet1->setCellValue('L'.$rowNumber, $oneItem->discount);
            $sheet1->setCellValue('M'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity*(float)$oneItem->discount/100);
            $sheet1->setCellValue('N'.$rowNumber, $oneItem->yard_remarks);
            $sheet1->setCellValue('O'.$rowNumber, '');
            $sheet1->setCellValue('P'.$rowNumber, '');
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = service('response');

// Set response headers for file download
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="'.$project_info->title.'_cost_sheet_for_'.$project_yard->title.'.xlsx"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // Write the Excel file content to the response body
        $writer->save('php://output');

        // Return the response object
        return $response;
    }
    function modal_import_yard_xlsx($shipyard_id){
        return $this->template->view('projects/comparison/modal_import_shipyard_items',['shipyard_id'=>$shipyard_id]);
    }
    function import_yard_xlsx(){
        upload_file_to_temp(true);
        $file = get_array_value($_FILES, "file");

        // if (!$file) {
        //     die("Invalid file");
        // }
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $temp_file = get_array_value($file, "tmp_name");
        $file_name = get_array_value($file, "name");
        $file_size = get_array_value($file, "size");
        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);
        $excel_file->setActiveSheetIndex(1);
        $worksheet=$excel_file->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g., 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g., 'F'

        // Convert the highest column letter to a numeric index (e.g., 'F' => 6)
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        // Initialize an empty array to store the data
        $data = [];

        // Loop through each row and column to read the data
        for ($row = 1; $row <= $highestRow; ++$row) {
            $rowData = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $rowData[] = $cellValue;
            }
            $data[] = $rowData;
        }
        $shipyard_id=$this->request->getPost('shipyard_id');
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $this->Shipyard_cost_items_model->delete_where(array("shipyard_id"=>$shipyard_id));
        for($count=1;$count<count($data);$count++){
            $task_info=$this->Tasks_model->get_all_where(array("title"=>$data[$count][1]))->getResult()[0];
            $saveData=array(
                "shipyard_id"=>$shipyard_id,
                "task_id"=>$task_info->id,
                "project_id"=>$shipyard_info->project_id,
                "name"=>$data[$count][3],
                "description"=>$data[$count][4],
                "quantity"=>$data[$count][6],
                "measurement"=>$data[$count][7],
                "unit_price"=>$data[$count][8],
                "currency"=>$data[$count][9],
                "discount"=>$data[$count][11],
                "yard_remarks"=>$data[$count][13],
            );
            $this->Shipyard_cost_items_model->ci_save($saveData,null);
        }
        echo json_encode(array("success"=>true));
    }
    function modal_select_yard($shipyard_id){
        $project_yard_info=$this->Project_yards_model->get_one($shipyard_id);
        $shipyard_info=$this->Shipyards_model->get_one($project_yard_info->shipyard_id);
        return $this->template->view("projects/comparison/modal_select_yard",["shipyard_info"=>$shipyard_info,"project_yard_info"=>$project_yard_info]);
    }
    function select_yard($shipyard_id){
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $shipyard_info->selected=1;
        $this->Project_yards_model->ci_save($shipyard_info,$shipyard_id);
        $this->Project_yards_model->delete_where(array("project_id"=>$shipyard_info->project_id,"selected"=>0));
        $shipyard_info->selected=0;
        $this->Project_yards_model->ci_save($shipyard_info,$shipyard_id);
        $project_info=$this->Projects_model->get_one($shipyard_info->project_id);
        $project_info->status_id=4;
        $this->Projects_model->ci_save($project_info,$project_info->id);
        $allShipyardCostItems=$this->Shipyard_cost_items_model->get_all_where(array("shipyard_id"=>$shipyard_id))->getResult();
        $this->Task_cost_items_model->delete_where(array("project_id"=>$shipyard_info->project_id));
        foreach ($allShipyardCostItems as $oneItem) {
            # code...
            
            $newTaskItem=array(
                "task_id"=>$oneItem->task_id,
                "project_id"=>$oneItem->project_id,
                "name"=>$oneItem->name,
                "description"=>$oneItem->description?$oneItem->description:"",
                "quantity"=>$oneItem->quantity,
                "measurement"=>$oneItem->measurement,
                "quote_type"=>$oneItem->quote_type?$oneItem->quote_type:"",
                "unit_price"=>$oneItem->unit_price,
                "currency"=>$oneItem->currency,
                "discount"=>$oneItem->discount?$oneItem->discount:"",
                "yard_remarks"=>$oneItem->yard_remarks?$oneItem->yard_remarks:"",
            );
            $this->Task_cost_items_model->ci_save($newTaskItem,null);
        }
        
        echo json_encode(array("success"=>true));
    }
    function modal_yard_add_files($shipyard_id){
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        return $this->template->view("projects/comparison/modal_yard_add_files",["shipyard_info"=>$shipyard_info]);
    }
    function modal_edit_yards_general($shipyard_id){
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        return $this->template->view('projects/comparison/modal_edit_yards_general',["shipyard_info"=>$shipyard_info]);
    }
    function save_edit_yards_general(){
        $shipyard_info=$this->Project_yards_model->get_one($this->request->getPost('shipyard_id'));
        $shipyard_info->general=json_encode($this->request->getPost('data'));
        $shipyard_info->deviation_cost=$this->request->getPost('deviation_cost');
        $shipyard_info->loss_of_earnings=$this->request->getPost('loss_of_earnings');
        $shipyard_info->bunker_cost=$this->request->getPost('bunker_cost');
        $shipyard_info->additional_expenditures=$this->request->getPost('other_additional_expenditures');
        $shipyard_info->total_offhire_period=$this->request->getPost('total_offhire_period');
        $shipyard_info->total_repair_period=$this->request->getPost('total_repair_period');
        $shipyard_info->days_in_dry_dock=$this->request->getPost('days_in_dry_dock');
        $shipyard_info->days_at_berth=$this->request->getPost('days_at_berth');
        $save_id=$this->Project_yards_model->ci_save($shipyard_info,$shipyard_info->id);
        return json_encode(array("success"=>true,"save_id"=>$save_id));
    }
    function modal_import_task_cost_items($shipyard_id){
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        return $this->template->view("projects/comparison/modal_import_task_cost_items",["shipyard_id"=>$shipyard_id,"shipyard_info"=>$shipyard_info]);

    }
    function import_task_cost_items(){
        upload_file_to_temp(true);
        $file = get_array_value($_FILES, "file");

        // if (!$file) {
        //     die("Invalid file");
        // }
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $temp_file = get_array_value($file, "tmp_name");
        $file_name = get_array_value($file, "name");
        $file_size = get_array_value($file, "size");
        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);

        $shipyard_id=$this->request->getPost('shipyard_id');
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);

        $excel_file->setActiveSheetIndex(0);
        $worksheet=$excel_file->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g., 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g., 'F'
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
        $info_data = [];

        // Loop through each row and column to read the data
        for ($row = 1; $row <= $highestRow; ++$row) {
            $rowData = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $rowData[] = $cellValue;
            }
            $info_data[] = $rowData;
        }
        // return json_encode($info_data);
        $task_id=$info_data[1][1];
        
        $project_id=$info_data[3][1];
        if((string)$shipyard_info->project_id!=(string)$project_id) return json_encode(array("success"=>false));

        $excel_file->setActiveSheetIndex(0);
        $worksheet=$excel_file->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g., 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g., 'F'

        // Convert the highest column letter to a numeric index (e.g., 'F' => 6)
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        // Initialize an empty array to store the data
        $data = [];

        // Loop through each row and column to read the data
        for ($row = 1; $row <= $highestRow; ++$row) {
            $rowData = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $rowData[] = $cellValue;
            }
            $data[] = $rowData;
        }
        // return json_encode($data);
        for($count=1;$count<count($data);$count++){
            // $task_info=$this->Tasks_model->get_one($task_id);
            $saveData=array(
                "shipyard_id"=>$shipyard_id,
                "task_id"=>$task_id,
                "project_id"=>$project_id,
                "name"=>$data[$count][0],
                "description"=>$data[$count][1],
                "quantity"=>$data[$count][3],
                "measurement"=>$data[$count][4],
                "unit_price"=>$data[$count][5],
                "currency"=>$data[$count][6],
                "discount"=>$data[$count][7],
                "yard_remarks"=>$data[$count][8],
            );
            $this->Shipyard_cost_items_model->ci_save($saveData,null);
        }
        echo json_encode(array("success"=>true));
    }
    function delete_yard_cost_item($item_id){
        $this->Shipyard_cost_items_model->delete_permanently($item_id);
        return json_encode(array("success"=>true));
    }
    function modal_edit_payment_terms($shipyard_id){
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $project_info=$this->Projects_model->get_one($shipyard_info->project_id);
        return $this->template->view('projects/comparison/modal_edit_payment_terms',["project_info"=>$project_info,"shipyard_info"=>$shipyard_info]);
    }
    function modal_edit_penalties($shipyard_id){
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $project_info=$this->Projects_model->get_one($shipyard_info->project_id);
        return $this->template->view('projects/comparison/modal_edit_penalties',["project_info"=>$project_info,"shipyard_info"=>$shipyard_info]);
    }
    function save_penalty(){
        $shipyard_id=$this->request->getPost("shipyard_id");
        $price=$this->request->getPost("price");
        $limit=$this->request->getPost("limit");
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $shipyard_info->penalty_per_day=$price;
        $shipyard_info->penalty_limit=$limit;
        $this->Project_yards_model->ci_save($shipyard_info,$shipyard_id);
        return json_encode(array("success"=>true));
    }
    function save_payment_terms(){
        $shipyard_id=$this->request->getPost("shipyard_id");
        $payment_before_departure=$this->request->getPost("payment_before_departure");
        $payment_within_30=$this->request->getPost("payment_within_30");
        $payment_within_60=$this->request->getPost("payment_within_60");
        $payment_within_90=$this->request->getPost("payment_within_90");
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $shipyard_info->payment_before_departure=$payment_before_departure;
        $shipyard_info->payment_within_30=$payment_within_30;
        $shipyard_info->payment_within_60=$payment_within_60;
        $shipyard_info->payment_within_90=$payment_within_90;
        $this->Project_yards_model->ci_save($shipyard_info,$shipyard_id);
        return json_encode(array("success"=>true));

    }
    ///////////////////////////
    /////////////////////////////
    function cost_overview($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        // $allCostItems=$this->Task_cost_items_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allCostItems=$this->Task_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        $allShipyardCostItems=[];
        if($project_info->status_id==4){
            $selected_yards=$this->Project_yards_model->get_all_where(array("project_id"=>$project_id))->getResult();
            if(count($selected_yards)>0)
                $allShipyardCostItems=$this->Shipyard_cost_items_model->get_all_with_costs_where(array("shipyard_id"=>$selected_yards[0]->id))->getResult();
        }
            
        $allTasks=$this->Tasks_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allVariationOrders=$this->Task_variation_orders_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allOwnerSupplies=$this->Task_owner_supplies_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allComments=$this->Task_comments_model->get_all_where(array("project_id"=>$project_id))->getResult();
        
        return $this->template->view('projects/cost_overview/index',["project_id"=>$project_id,"project_info"=>$project_info,"allComments"=>$allComments,"allShipyardCostItems"=>$allShipyardCostItems,"allOwnerSupplies"=>$allOwnerSupplies,"allVariationOrders"=>$allVariationOrders,"allTasks"=>$allTasks,'allCostItems'=>$allCostItems]);
    }

    function modal_import_cost_overview($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        return $this->template->view("projects/comparison/modal_import_items",array("project_info"=>$project_info,"project_id"=>$project_id));
    }
    function modal_export_cost_overview($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        return $this->template->view("projects/cost_overview/modal_export_items",["project_info"=>$project_info,"project_id"=>$project_id]);
    }
    function modal_comments($project_id){
        $options = array("project_id" => $project_id, "login_user_id" => $this->login_user->id);
        $comments=$this->Project_comments_model->get_details($options)->getResult();
        // return json_encode($comments);
        return $this->template->view("projects/cost_overview/modal_comments",["project_id"=>$project_id,"comments"=>$comments,"can_comment_on_tasks"=>true]);
    }
    function modal_task_comments($task_id){
        $task_info=$this->Tasks_model->get_one($task_id);
        $options = array("task_id" => $task_id, "login_user_id" => $this->login_user->id);
        $comments=$this->Project_comments_model->get_details($options)->getResult();
        // return json_encode($comments);
        return $this->template->view("projects/cost_overview/modal_comments",["project_id"=>$task_info->project_id,"task_id"=>$task_id,"comments"=>$comments,"can_comment_on_tasks"=>true]);
    }

    function task_files_list_data($task_id = 0) {
        validate_numeric_value($task_id);
        // $this->init_project_permission_checker($project_id);

        // if (!$this->can_view_files()) {
        //     app_redirect("forbidden");
        // }

        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("task_files", $this->login_user->is_admin, $this->login_user->user_type);

        $options = array(
            "task_id" => $task_id,
            "description"=>""
            // "category_id" => $this->request->getPost("category_id"),
            // "custom_fields" => $custom_fields,
            // "custom_field_filter" => $this->prepare_custom_field_filter_values("task_files", $this->login_user->is_admin, $this->login_user->user_type)
        );

        $list_data = $this->Project_comments_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_file_row($data, $custom_fields);
        }
        echo json_encode(array("data" => $result));
    }
    function currency_rates($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        $allCurrencyRates=$this->Project_currency_rates_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allCostItemCurrencies=$this->Task_cost_items_model->get_dropdown_list(array("currency"), "currency", array("project_id"=>$project_id));
        return $this->template->rander("projects/comparison/currency_rates",["project_info"=>$project_info,"allCostItemCurrencies"=>$allCostItemCurrencies,"project_id"=>$project_id,"allCurrencyRates"=>$allCurrencyRates]);
    }
    function modal_add_currency_rate($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        return $this->template->view("projects/comparison/modal_add_currency_rate",["project_id"=>$project_id,"project_info"=>$project_info]);
    }
    function modal_edit_currency_rate($rate_id){
        $rate_info=$this->Project_currency_rates_model->get_one($rate_id);
        return $this->template->view("projects/comparison/modal_edit_currency_rate",["rate_info"=>$rate_info]);
    }
    function save_currency_rate(){
        $newRateData=array(
            "project_id"=>$this->request->getPost("project_id"),
            "from"=>$this->request->getPost("from"),
            "to"=>$this->request->getPost("to"),
            "rate"=>$this->request->getPost("rate"),
        );
        $save_id=$this->Project_currency_rates_model->ci_save($newRateData);
        return json_encode(array("success"=>true,"save_id"=>$save_id));
    }
    function edit_currency_rate(){
        $rate_info=$this->Project_currency_rates_model->get_one($this->request->getPost("id"));
        $rate_info->rate=$this->request->getPost("rate");
        $save_id=$this->Project_currency_rates_model->ci_save($rate_info,$this->request->getPost("id"));
        return json_encode(array("success"=>true,"save_id"=>$save_id));
    }
    function modal_currency_rates($project_id){
        $allRates=$this->Project_currency_rates_model->get_all_where(array("project_id"=>$project_id))->getResult();
        return $this->template->view('projects/comparison/modal_currency_rates',["project_id"=>$project_id,"allRates"=>$allRates]);
    }
    function task_list_headers(){
        $headers=array(
            "data"=>array(
                array(
                    "","","","","","","","","",""
                )
            )
        );
        return json_encode($headers);
    }

    function download_quotation_form_xlsx($project_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $project_info=$this->Projects_model->get_one($project_id);
        $allProjectCostItems=$this->Task_cost_items_model->get_all_where(array("project_id"=>$project_id,"deleted"=>0))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Cost items');
        $sheet1->setCellValue('A1', 'Project ID');
        $sheet1->setCellValue('B1', 'Project Title');
        $sheet1->setCellValue('C1', 'Task ID');
        $sheet1->setCellValue('D1', 'Task Title');
        $sheet1->setCellValue('E1', 'Group');
        $sheet1->setCellValue('F1', 'Dock List Number');
        $sheet1->setCellValue('G1', 'Cost item');
        $sheet1->setCellValue('H1', 'Description');
        $sheet1->setCellValue('I1', 'Cost type');
        $sheet1->setCellValue('J1', 'Est. quantity');
        $sheet1->setCellValue('K1', 'Measurement unit');
        $sheet1->setCellValue('L1', 'Unit price');
        $sheet1->setCellValue('M1', 'Unit price currency');
        $sheet1->setCellValue('N1', 'Quote');
        $sheet1->setCellValue('O1', 'Discount (0-100%)');
        $sheet1->setCellValue('P1', 'Discounted quote');
        $sheet1->setCellValue('Q1', 'Yard remarks');
        $sheet1->setCellValue('R1', 'Link to Task');
        $rowNumber=2;
        foreach ($allProjectCostItems as $oneItem) {
            $task_info=$this->Tasks_model->get_one($oneItem->task_id);
            $sheet1->setCellValue('A'.$rowNumber, $project_id);
            $sheet1->setCellValue('B'.$rowNumber, $project_info->title);
            $sheet1->setCellValue('C'.$rowNumber, $task_info->id);
            $sheet1->setCellValue('D'.$rowNumber, $task_info->title);
            $sheet1->setCellValue('E'.$rowNumber, $task_info->category);
            $sheet1->setCellValue('F'.$rowNumber, $task_info->dock_list_number);
            $sheet1->setCellValue('G'.$rowNumber, $oneItem->name);
            $sheet1->setCellValue('H'.$rowNumber, $oneItem->description);
            $sheet1->setCellValue('I'.$rowNumber, $oneItem->quote_type);
            $sheet1->setCellValue('J'.$rowNumber, $oneItem->quantity);
            $sheet1->setCellValue('K'.$rowNumber, $oneItem->measurement);
            $sheet1->setCellValue('L'.$rowNumber, $oneItem->unit_price);
            $sheet1->setCellValue('M'.$rowNumber, $oneItem->currency);
            $sheet1->setCellValue('N'.$rowNumber, $oneItem->currency." ".(float)$oneItem->unit_price*(float)$oneItem->quantity);
            $sheet1->setCellValue('O'.$rowNumber, $oneItem->discount." %");
            $sheet1->setCellValue('P'.$rowNumber, $oneItem->currency." ".(float)$oneItem->unit_price*(float)$oneItem->quantity*(float)(100-$oneItem->discount)/100);
            $sheet1->setCellValue('Q'.$rowNumber, $oneItem->yard_remarks);
            $sheet1->setCellValue('R'.$rowNumber, get_uri("task_view/view/").$oneItem->task_id);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = service('response');

// Set response headers for file download
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="'.$project_info->title.'_quotation_form.xlsx"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // Write the Excel file content to the response body
        $writer->save('php://output');

        // Return the response object
        return $response;
    }
    function download_project_form_xlsx($project_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $project_info=$this->Projects_model->get_one($project_id);
        $allProjectCostItems=$this->Task_cost_items_model->get_all_where(array("project_id"=>$project_id,"deleted"=>0))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        // $sheet1->setTitle('About project');
        // $sheet1->setCellValue('A1', $project_info->id);
        // $sheet1->setCellValue('A3', $project_info->title);
        // $sheet1->setCellValue('A14', $project_info->start_date);
        // $sheet1->setCellValue('B14', "~");
        // $sheet1->setCellValue('C14', $project_info->deadline);
        // $sheet1->setCellValue('A19', 'Support');
        // $sheet1->setCellValue('A20', "If you have any questions at all, please reach out to Maindeck's support team directly.(ctrl + click to view)");
        // $sheet1->setCellValue('A21', '+47 91999771');
        // $sheet1 = $spreadsheet->createSheet();
        $sheet1->setTitle('Cost items');
        $sheet1->setCellValue('A1', 'project_id');
        $sheet1->setCellValue('B1', 'project_title');
        $sheet1->setCellValue('C1', 'task_id');
        $sheet1->setCellValue('D1', 'task_title');
        $sheet1->setCellValue('E1', 'Group');
        $sheet1->setCellValue('F1', 'Cost item');
        $sheet1->setCellValue('G1', 'Description');
        $sheet1->setCellValue('H1', 'Cost type');
        $sheet1->setCellValue('I1', 'Est. quantity');
        $sheet1->setCellValue('J1', 'Measurement unit');
        $sheet1->setCellValue('K1', 'Unit price');
        $sheet1->setCellValue('L1', 'Unit price currency');
        $sheet1->setCellValue('M1', 'Quote');
        $sheet1->setCellValue('N1', 'Discount (0-100%)');
        $sheet1->setCellValue('O1', 'Discounted quote');
        $sheet1->setCellValue('P1', 'Yard remarks');
        $rowNumber=2;
        foreach ($allProjectCostItems as $oneItem) {
            $task_info=$this->Tasks_model->get_one($oneItem->task_id);
            $sheet1->setCellValue('A'.$rowNumber, $project_id);
            $sheet1->setCellValue('B'.$rowNumber, $project_info->title);
            $sheet1->setCellValue('C'.$rowNumber, $task_info->id);
            $sheet1->setCellValue('D'.$rowNumber, $task_info->title);
            $sheet1->setCellValue('F'.$rowNumber, $task_info->category);
            $sheet1->setCellValue('F'.$rowNumber, $oneItem->name);
            $sheet1->setCellValue('G'.$rowNumber, $oneItem->description);
            $sheet1->setCellValue('I'.$rowNumber, $oneItem->quantity);
            $sheet1->setCellValue('J'.$rowNumber, $oneItem->measurement);
            $sheet1->setCellValue('K'.$rowNumber, $oneItem->unit_price);
            $sheet1->setCellValue('L'.$rowNumber, $oneItem->currency);
            $sheet1->setCellValue('M'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity);
            $sheet1->setCellValue('N'.$rowNumber, $oneItem->discount);
            $sheet1->setCellValue('O'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity*(float)$oneItem->discount/100);
            $sheet1->setCellValue('P'.$rowNumber, $oneItem->yard_remarks);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = service('response');

// Set response headers for file download
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="'.$project_info->title.'_quotation_form.xlsx"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // Write the Excel file content to the response body
        $writer->save('php://output');

        // Return the response object
        return $response;
    }
    function download_cost_overview_xlsx($project_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $project_info=$this->Projects_model->get_one($project_id);
        $allCostItems=$this->Task_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        $allShipyardCostItems=[];
        if($project_info->status_id==4){
            $selected_yards=$this->Project_yards_model->get_all_where(array("project_id"=>$project_id))->getResult();
            if(count($selected_yards)>0)
                $allShipyardCostItems=$this->Shipyard_cost_items_model->get_all_with_costs_where(array("shipyard_id"=>$selected_yards[0]->id))->getResult();
        }
        $allTasks=$this->Tasks_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allVariationOrders=$this->Task_variation_orders_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allOwnerSupplies=$this->Task_owner_supplies_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allComments=$this->Task_comments_model->get_all_where(array("project_id"=>$project_id))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        // $sheet1->setTitle('About project');
        // $sheet1->setCellValue('A1', $project_info->id);
        // $sheet1->setCellValue('A3', $project_info->title);
        // $sheet1->setCellValue('A14', $project_info->start_date);
        // $sheet1->setCellValue('B14', "~");
        // $sheet1->setCellValue('C14', $project_info->deadline);
        // $sheet1->setCellValue('A19', 'Support');
        // $sheet1->setCellValue('A20', "If you have any questions at all, please reach out to Maindeck's support team directly.(ctrl + click to view)");
        // $sheet1->setCellValue('A21', '+47 91999771');
        // $sheet1 = $spreadsheet->createSheet();
        $sheet1->setTitle('Cost Overview');

        $categorizedTasks=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedOwnerSupplies=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedCostItems=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedShipyardCostItems=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedVariationOrders=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        
        $categorizedComments=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedStats=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        
        foreach ($allTasks as $index => $oneTask) {
            if(isset($categorizedTasks[$oneTask->category]))
                $categorizedTasks[$oneTask->category][]=$oneTask;
            else $categorizedTasks["Others"][]=$oneTask;
        
            if(isset($categorizedOwnerSupplies[$oneTask->category]))
                $categorizedOwnerSupplies[$oneTask->category]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
                    return $oneTask->id==$oneSupply->task_id;
                });
            else $categorizedOwnerSupplies["Others"]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
                return $oneTask->id==$oneSupply->task_id;
            });
        
            if(isset($categorizedCostItems[$oneTask->category]))
                $categorizedCostItems[$oneTask->category]+=array_filter($allCostItems,function($oneItem)use($oneTask){
                    return $oneTask->id==$oneItem->task_id;
                });
            else $categorizedCostItems["Others"]+=array_filter($allCostItems,function($oneItem)use($oneTask){
                return $oneTask->id==$oneItem->task_id;
            });
        
            if(isset($categorizedShipyardCostItems[$oneTask->category]))
                $categorizedShipyardCostItems[$oneTask->category]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
                    return $oneTask->id==$oneItem->task_id;
                });
            else $categorizedShipyardCostItems["Others"]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
                return $oneTask->id==$oneItem->task_id;
            });
        
            if(isset($categorizedVariationOrders[$oneTask->category]))
                $categorizedVariationOrders[$oneTask->category]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
                    return $oneTask->id==$oneOrder->task_id;
                });
            else $categorizedVariationOrders["Others"]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
                return $oneTask->id==$oneOrder->task_id;
            });
        
            if(isset($categorizedComments[$oneTask->category]))
                $categorizedComments[$oneTask->category]+=array_filter($allComments,function($oneComment)use($oneTask){
                    return $oneTask->id==$oneComment->task_id;
                });
            else $categorizedComments["Others"]+=array_filter($allComments,function($oneComment)use($oneTask){
                return $oneTask->id==$oneComment->task_id;
            });
        }
        
        $totalOwnerSupplies=0;
        $totalVariationOrders=0;
        $totalCostItems=0;
        $totalCosts=0;
        $totalShipyardCostItems=0;
        $totalComments=0;
        $sheet1->setCellValue('A1', "Category");
        $sheet1->setCellValue('B1', "Task");
        $sheet1->setCellValue('C1', "Owner's supply");
        $sheet1->setCellValue('D1', "Quoted");
        $sheet1->setCellValue('E1', "Variation orders");
        $sheet1->setCellValue('F1', "Total");
        $sheet1->setCellValue('G1', 'Total yard');
        $sheet1->setCellValue('H1', "Billed yard");
        $sheet1->setCellValue('I1', "Final yard");
        $sheet1->setCellValue('J1', 'Comments');

        $sheet1->setCellValue('B2', "Total:");
        $sheet1->setCellValue('C2', 0);
        $sheet1->setCellValue('D2', 0);
        $sheet1->setCellValue('E2', 0);
        $sheet1->setCellValue('F2', 0);
        $sheet1->setCellValue('G2', 0);
        $sheet1->setCellValue('H2', 0);
        $sheet1->setCellValue('I2', 0);
        $sheet1->setCellValue('J2', 0);

        $rowIndex=3;
        foreach ($categorizedTasks as $category=>$oneList) {
            $categoryOwnerSupply=0;
            $categoryCostItems=0;
            $categoryTotalCosts=0;
            $categoryShipyardCostItems=0;
            $categoryVariationOrder=0;
            $categoryComments=0;
            $sheet1->setCellValue('A'.$rowIndex, $category);
            $sheet1->setCellValue('B'.$rowIndex, 0);
            $sheet1->setCellValue('C'.$rowIndex, 0);
            $sheet1->setCellValue('D'.$rowIndex, 0);
            $sheet1->setCellValue('E'.$rowIndex, 0);
            $sheet1->setCellValue('F'.$rowIndex, 0);
            $sheet1->setCellValue('G'.$rowIndex, 0);
            $sheet1->setCellValue('H'.$rowIndex, 0);
            $sheet1->setCellValue('I'.$rowIndex, 0);
            $sheet1->setCellValue('J'.$rowIndex, 0);
            $category_row=$rowIndex;
            $rowIndex++;
            foreach ($oneList as $key => $oneTask) {
                
                $oneTaskSupplies=array_filter($categorizedOwnerSupplies[$category],function($oneSupply)use($oneTask){
                    return $oneSupply->task_id==$oneTask->id;
                });
                $oneTaskCostItems=array_filter($categorizedCostItems[$category],function($oneItem)use($oneTask){
                    return $oneItem->task_id==$oneTask->id;
                });
                $oneTaskShipyardCostItems=array_filter($categorizedShipyardCostItems[$category],function($oneItem)use($oneTask){
                    return $oneItem->task_id==$oneTask->id;
                });
                $oneTaskVariationOrders=array_filter($categorizedVariationOrders[$category],function($oneOrder)use($oneTask){
                    return $oneOrder->task_id==$oneTask->id;
                });
                $oneTaskComments=array_filter($categorizedComments[$category],function($oneComment)use($oneTask){
                    return $oneComment->task_id==$oneTask->id;
                });
                $oneTaskTotalSupplies=0;
                foreach ($oneTaskSupplies as $oneSupply) {
                    $oneTaskTotalSupplies+=$oneSupply->cost;
                }
                $categoryOwnerSupply+=$oneTaskTotalSupplies;

                $oneTaskTotalCostItems=0;
                foreach ($oneTaskCostItems as $oneItem) {
                    $oneTaskTotalCostItems+=$oneItem->total_cost;
                }
                $categoryCostItems+=$oneTaskTotalCostItems;

                $oneTaskTotalCosts=$oneTaskTotalSupplies+$oneTaskTotalCostItems;
                $categoryTotalCosts+=$oneTaskTotalCosts;

                $oneTaskTotalShipyardCostItems=0;
                foreach ($oneTaskShipyardCostItems as $oneItem) {
                    $oneTaskTotalShipyardCostItems+=$oneItem->total_cost;
                }
                $categoryShipyardCostItems+=$oneTaskTotalShipyardCostItems;

                $oneTaskTotalVariationOrders=0;
                foreach ($oneTaskVariationOrders as $oneOrder) {
                    $oneTaskTotalVariationOrders+=$oneOrder->cost;
                }
                $categoryVariationOrder+=$oneTaskTotalVariationOrders;

                $oneTaskTotalComments=count($oneTaskComments);
                $categoryComments+=$oneTaskTotalComments;

                
                $totalOwnerSupplies+=$oneTaskTotalSupplies;
                $totalCostItems+=$oneTaskTotalCostItems;
                $totalShipyardCostItems+=$oneTaskTotalShipyardCostItems;
                $totalVariationOrders+=$oneTaskTotalVariationOrders;
                $totalComments+=$oneTaskTotalComments;
                $totalCosts+=($oneTaskTotalSupplies+$oneTaskTotalCostItems);

                $sheet1->setCellValue('B'.$rowIndex, $oneTask->title);
                $sheet1->setCellValue('C'.$rowIndex, $oneTaskTotalSupplies);
                $sheet1->setCellValue('D'.$rowIndex, $oneTaskTotalCostItems);
                $sheet1->setCellValue('E'.$rowIndex, $oneTaskTotalVariationOrders);
                $sheet1->setCellValue('F'.$rowIndex, $oneTaskTotalCosts);
                $sheet1->setCellValue('G'.$rowIndex, $oneTaskTotalShipyardCostItems);
                $sheet1->setCellValue('H'.$rowIndex, 0);
                $sheet1->setCellValue('I'.$rowIndex, 0);
                $sheet1->setCellValue('J'.$rowIndex, $oneTaskTotalComments);
                $rowIndex++;
            }
            $categorizedStats[$category]["owner_supplies"]=$categoryOwnerSupply;
            $categorizedStats[$category]["cost_items"]=$categoryCostItems;
            $categorizedStats[$category]["variation_orders"]=$categoryVariationOrder;
            $categorizedStats[$category]["shipyard_cost_items"]=$categoryShipyardCostItems;
            $categorizedStats[$category]["comments"]=$categoryComments;
            $sheet1->setCellValue('B'.$category_row, "");
            $sheet1->setCellValue('C'.$category_row, $categoryOwnerSupply);
            $sheet1->setCellValue('D'.$category_row, $categoryCostItems);
            $sheet1->setCellValue('E'.$category_row, $categoryVariationOrder);
            $sheet1->setCellValue('F'.$category_row, $categoryTotalCosts);
            $sheet1->setCellValue('G'.$category_row, $categoryShipyardCostItems);
            $sheet1->setCellValue('H'.$category_row, 0);
            $sheet1->setCellValue('I'.$category_row, $categoryComments);
        }
        $sheet1->setCellValue('C2', $totalOwnerSupplies);
        $sheet1->setCellValue('D2', $totalCostItems);
        $sheet1->setCellValue('E2', $totalVariationOrders);
        $sheet1->setCellValue('F2', $totalCosts);
        $sheet1->setCellValue('G2', $totalShipyardCostItems);
        $sheet1->setCellValue('H2', 0);
        $sheet1->setCellValue('I2', 0);
        $sheet1->setCellValue('J2', $totalComments);
        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = service('response');

// Set response headers for file download
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="'.$project_info->title.'_cost_overview.xlsx"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // Write the Excel file content to the response body
        $writer->save('php://output');

        // Return the response object
        return $response;
    }
    function download_all_zip($project_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $project_info=$this->Projects_model->get_one($project_id);
        $allProjectCostItems=$this->Task_cost_items_model->get_all_where(array("project_id"=>$project_id))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Cost items');
        $sheet1->setCellValue('A1', 'project_id');
        $sheet1->setCellValue('B1', 'project_title');
        $sheet1->setCellValue('C1', 'task_id');
        $sheet1->setCellValue('D1', 'task_title');
        $sheet1->setCellValue('E1', 'Group');
        $sheet1->setCellValue('F1', 'Cost item');
        $sheet1->setCellValue('G1', 'Description');
        $sheet1->setCellValue('H1', 'Cost type');
        $sheet1->setCellValue('I1', 'Est. quantity');
        $sheet1->setCellValue('J1', 'Measurement unit');
        $sheet1->setCellValue('K1', 'Unit price');
        $sheet1->setCellValue('L1', 'Unit price currency');
        $sheet1->setCellValue('M1', 'Quote');
        $sheet1->setCellValue('N1', 'Discount (0-100%)');
        $sheet1->setCellValue('O1', 'Discounted quote');
        $sheet1->setCellValue('P1', 'Yard remarks');
        $rowNumber=2;
        foreach ($allProjectCostItems as $oneItem) {
            $task_info=$this->Tasks_model->get_one($oneItem->task_id);
            $sheet1->setCellValue('A'.$rowNumber, $project_id);
            $sheet1->setCellValue('B'.$rowNumber, $project_info->title);
            $sheet1->setCellValue('C'.$rowNumber, $task_info->id);
            $sheet1->setCellValue('D'.$rowNumber, $task_info->title);
            $sheet1->setCellValue('F'.$rowNumber, $task_info->category);
            $sheet1->setCellValue('F'.$rowNumber, $oneItem->name);
            $sheet1->setCellValue('G'.$rowNumber, $oneItem->description);
            $sheet1->setCellValue('I'.$rowNumber, $oneItem->quantity);
            $sheet1->setCellValue('J'.$rowNumber, $oneItem->measurement);
            $sheet1->setCellValue('K'.$rowNumber, $oneItem->unit_price);
            $sheet1->setCellValue('L'.$rowNumber, $oneItem->currency);
            $sheet1->setCellValue('M'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity);
            $sheet1->setCellValue('N'.$rowNumber, $oneItem->discount);
            $sheet1->setCellValue('O'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity*(float)$oneItem->discount/100);
            $sheet1->setCellValue('P'.$rowNumber, $oneItem->yard_remarks);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Write the Excel file content to the response body
        $first_temp_file_path = getcwd() . '/' . get_setting("temp_file_path").'/'.$project_id."-quotation-form.xlsx";
        $writer->save($first_temp_file_path);
        $allProjectCostItems=$this->Task_cost_items_model->get_all_where(array("project_id"=>$project_id))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('About project');
        $sheet1->setCellValue('A1', $project_info->id);
        $sheet1->setCellValue('A3', $project_info->title);
        $sheet1->setCellValue('A14', $project_info->start_date);
        $sheet1->setCellValue('B14', "~");
        $sheet1->setCellValue('C14', $project_info->deadline);
        $sheet1->setCellValue('A19', 'Support');
        $sheet1->setCellValue('A20', "If you have any questions at all, please reach out to Maindeck's support team directly.(ctrl + click to view)");
        $sheet1->setCellValue('A21', '+47 91999771');
        $sheet1 = $spreadsheet->createSheet();
        $sheet1->setTitle('Cost items');
        $sheet1->setCellValue('A1', 'project_id');
        $sheet1->setCellValue('B1', 'project_title');
        $sheet1->setCellValue('C1', 'task_id');
        $sheet1->setCellValue('D1', 'task_title');
        $sheet1->setCellValue('E1', 'Group');
        $sheet1->setCellValue('F1', 'Cost item');
        $sheet1->setCellValue('G1', 'Description');
        $sheet1->setCellValue('H1', 'Cost type');
        $sheet1->setCellValue('I1', 'Est. quantity');
        $sheet1->setCellValue('J1', 'Measurement unit');
        $sheet1->setCellValue('K1', 'Unit price');
        $sheet1->setCellValue('L1', 'Unit price currency');
        $sheet1->setCellValue('M1', 'Quote');
        $sheet1->setCellValue('N1', 'Discount (0-100%)');
        $sheet1->setCellValue('O1', 'Discounted quote');
        $sheet1->setCellValue('P1', 'Yard remarks');
        $rowNumber=2;
        foreach ($allProjectCostItems as $oneItem) {
            $task_info=$this->Tasks_model->get_one($oneItem->task_id);
            $sheet1->setCellValue('A'.$rowNumber, $project_id);
            $sheet1->setCellValue('B'.$rowNumber, $project_info->title);
            $sheet1->setCellValue('C'.$rowNumber, $task_info->id);
            $sheet1->setCellValue('D'.$rowNumber, $task_info->title);
            $sheet1->setCellValue('F'.$rowNumber, $task_info->category);
            $sheet1->setCellValue('F'.$rowNumber, $oneItem->name);
            $sheet1->setCellValue('G'.$rowNumber, $oneItem->description);
            $sheet1->setCellValue('I'.$rowNumber, $oneItem->quantity);
            $sheet1->setCellValue('J'.$rowNumber, $oneItem->measurement);
            $sheet1->setCellValue('K'.$rowNumber, $oneItem->unit_price);
            $sheet1->setCellValue('L'.$rowNumber, $oneItem->currency);
            $sheet1->setCellValue('M'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity);
            $sheet1->setCellValue('N'.$rowNumber, $oneItem->discount);
            $sheet1->setCellValue('O'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity*(float)$oneItem->discount/100);
            $sheet1->setCellValue('P'.$rowNumber, $oneItem->yard_remarks);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);


        $second_temp_file_path = getcwd() . '/' . get_setting("temp_file_path").'/'.$project_id."-project-form.xlsx";
        $writer->save($second_temp_file_path);

        // Write the Excel file content to the response body

        // Return the response object
        $allCostItems=$this->Task_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        $allShipyardCostItems=$this->Shipyard_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        $allTasks=$this->Tasks_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allVariationOrders=$this->Task_variation_orders_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allOwnerSupplies=$this->Task_owner_supplies_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allComments=$this->Project_comments_model->get_all_where(array("project_id"=>$project_id))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('About project');
        $sheet1->setCellValue('A1', $project_info->id);
        $sheet1->setCellValue('A3', $project_info->title);
        $sheet1->setCellValue('A14', $project_info->start_date);
        $sheet1->setCellValue('B14', "~");
        $sheet1->setCellValue('C14', $project_info->deadline);
        $sheet1->setCellValue('A19', 'Support');
        $sheet1->setCellValue('A20', "If you have any questions at all, please reach out to Maindeck's support team directly.(ctrl + click to view)");
        $sheet1->setCellValue('A21', '+47 91999771');
        $sheet1 = $spreadsheet->createSheet();
        $sheet1->setTitle('Cost overview');

        $categorizedTasks=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedOwnerSupplies=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedCostItems=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedShipyardCostItems=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedVariationOrders=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        
        $categorizedComments=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedStats=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        
        foreach ($allTasks as $index => $oneTask) {
            if(isset($categorizedTasks[$oneTask->category]))
                $categorizedTasks[$oneTask->category][]=$oneTask;
            else $categorizedTasks["Others"][]=$oneTask;
        
            if(isset($categorizedOwnerSupplies[$oneTask->category]))
                $categorizedOwnerSupplies[$oneTask->category]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
                    return $oneTask->id==$oneSupply->task_id;
                });
            else $categorizedOwnerSupplies["Others"]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
                return $oneTask->id==$oneSupply->task_id;
            });
        
            if(isset($categorizedCostItems[$oneTask->category]))
                $categorizedCostItems[$oneTask->category]+=array_filter($allCostItems,function($oneItem)use($oneTask){
                    return $oneTask->id==$oneItem->task_id;
                });
            else $categorizedCostItems["Others"]+=array_filter($allCostItems,function($oneItem)use($oneTask){
                return $oneTask->id==$oneItem->task_id;
            });
        
            if(isset($categorizedShipyardCostItems[$oneTask->category]))
                $categorizedShipyardCostItems[$oneTask->category]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
                    return $oneTask->id==$oneItem->task_id;
                });
            else $categorizedShipyardCostItems["Others"]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
                return $oneTask->id==$oneItem->task_id;
            });
        
            if(isset($categorizedVariationOrders[$oneTask->category]))
                $categorizedVariationOrders[$oneTask->category]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
                    return $oneTask->id==$oneOrder->task_id;
                });
            else $categorizedVariationOrders["Others"]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
                return $oneTask->id==$oneOrder->task_id;
            });
        
            if(isset($categorizedComments[$oneTask->category]))
                $categorizedComments[$oneTask->category]+=array_filter($allComments,function($oneComment)use($oneTask){
                    return $oneTask->id==$oneComment->task_id;
                });
            else $categorizedComments["Others"]+=array_filter($allComments,function($oneComment)use($oneTask){
                return $oneTask->id==$oneComment->task_id;
            });
        }
        
        $totalOwnerSupplies=0;
        $totalVariationOrders=0;
        $totalCostItems=0;
        $totalShipyardCostItems=0;
        $totalComments=0;

        $sheet1->setCellValue('B1', "Name");
        $sheet1->setCellValue('C1', "Owner's supply");
        $sheet1->setCellValue('D1', "Quoted");
        $sheet1->setCellValue('E1', "Variation orders");
        $sheet1->setCellValue('F1', "Total");
        $sheet1->setCellValue('G1', 'Total yard');
        $sheet1->setCellValue('H1', "Billed yard");
        $sheet1->setCellValue('I1', 'Comment');

        $sheet1->setCellValue('B2', "Total:");
        $sheet1->setCellValue('C2', 0);
        $sheet1->setCellValue('D2', 0);
        $sheet1->setCellValue('E2', 0);
        $sheet1->setCellValue('F2', 0);
        $sheet1->setCellValue('G2', 0);
        $sheet1->setCellValue('H2', 0);
        $sheet1->setCellValue('I2', 0);

        $rowIndex=3;
        foreach ($categorizedTasks as $category=>$oneList) {
            $categoryOwnerSupply=0;
            $categoryCostItems=0;
            $categoryShipyardCostItems=0;
            $categoryVariationOrder=0;
            $categoryComments=0;
            $sheet1->setCellValue('A'.$rowIndex, $category);
            $sheet1->setCellValue('B'.$rowIndex, 0);
            $sheet1->setCellValue('C'.$rowIndex, 0);
            $sheet1->setCellValue('D'.$rowIndex, 0);
            $sheet1->setCellValue('E'.$rowIndex, 0);
            $sheet1->setCellValue('F'.$rowIndex, 0);
            $sheet1->setCellValue('G'.$rowIndex, 0);
            $sheet1->setCellValue('H'.$rowIndex, 0);
            $sheet1->setCellValue('I'.$rowIndex, 0);
            $category_row=$rowIndex;
            $rowIndex++;
            foreach ($oneList as $key => $oneTask) {
                
                $oneTaskSupplies=array_filter($categorizedOwnerSupplies[$category],function($oneSupply)use($oneTask){
                    return $oneSupply->task_id==$oneTask->id;
                });
                $oneTaskCostItems=array_filter($categorizedCostItems[$category],function($oneItem)use($oneTask){
                    return $oneItem->task_id==$oneTask->id;
                });
                $oneTaskShipyardCostItems=array_filter($categorizedShipyardCostItems[$category],function($oneItem)use($oneTask){
                    return $oneItem->task_id==$oneTask->id;
                });
                $oneTaskVariationOrders=array_filter($categorizedVariationOrders[$category],function($oneOrder)use($oneTask){
                    return $oneOrder->task_id==$oneTask->id;
                });
                $oneTaskComments=array_filter($categorizedComments[$category],function($oneComment)use($oneTask){
                    return $oneComment->task_id==$oneTask->id;
                });
                $oneTaskTotalSupplies=0;
                foreach ($oneTaskSupplies as $oneSupply) {
                    $oneTaskTotalSupplies+=$oneSupply->cost;
                }
                $categoryOwnerSupply+=$oneTaskTotalSupplies;

                $oneTaskTotalCostItems=0;
                foreach ($oneTaskCostItems as $oneItem) {
                    $oneTaskTotalCostItems+=$oneItem->total_cost;
                }
                $categoryCostItems+=$oneTaskTotalCostItems;

                $oneTaskTotalShipyardCostItems=0;
                foreach ($oneTaskShipyardCostItems as $oneItem) {
                    $oneTaskTotalShipyardCostItems+=$oneItem->total_cost;
                }
                $categoryShipyardCostItems+=$oneTaskTotalShipyardCostItems;

                $oneTaskTotalVariationOrders=0;
                foreach ($oneTaskVariationOrders as $oneOrder) {
                    $oneTaskTotalVariationOrders+=$oneOrder->cost;
                }
                $categoryVariationOrder+=$oneTaskTotalVariationOrders;

                $oneTaskTotalComments=count($oneTaskComments);
                $categoryComments+=$oneTaskTotalComments;

                
                $totalOwnerSupplies+=$oneTaskTotalSupplies;
                $totalCostItems+=$oneTaskTotalCostItems;
                $totalShipyardCostItems+=$oneTaskTotalShipyardCostItems;
                $totalVariationOrders+=$oneTaskTotalVariationOrders;
                $totalComments+=$oneTaskTotalComments;

                $sheet1->setCellValue('B'.$rowIndex, $oneTask->title);
                $sheet1->setCellValue('C'.$rowIndex, $oneTaskTotalSupplies);
                $sheet1->setCellValue('D'.$rowIndex, $oneTaskTotalCostItems);
                $sheet1->setCellValue('E'.$rowIndex, $oneTaskTotalVariationOrders);
                $sheet1->setCellValue('F'.$rowIndex, 0);
                $sheet1->setCellValue('G'.$rowIndex, $oneTaskTotalShipyardCostItems);
                $sheet1->setCellValue('H'.$rowIndex, 0);
                $sheet1->setCellValue('I'.$rowIndex, 0);
                $rowIndex++;
            }
            $categorizedStats[$category]["owner_supplies"]=$categoryOwnerSupply;
            $categorizedStats[$category]["cost_items"]=$categoryCostItems;
            $categorizedStats[$category]["variation_orders"]=$categoryVariationOrder;
            $categorizedStats[$category]["shipyard_cost_items"]=$categoryShipyardCostItems;
            $categorizedStats[$category]["comments"]=$categoryComments;
            $sheet1->setCellValue('B'.$category_row, "");
            $sheet1->setCellValue('C'.$category_row, $categoryOwnerSupply);
            $sheet1->setCellValue('D'.$category_row, $categoryCostItems);
            $sheet1->setCellValue('E'.$category_row, $categoryVariationOrder);
            $sheet1->setCellValue('F'.$category_row, 0);
            $sheet1->setCellValue('G'.$category_row, $categoryShipyardCostItems);
            $sheet1->setCellValue('H'.$category_row, 0);
            $sheet1->setCellValue('I'.$category_row, 0);
        }
        $sheet1->setCellValue('C2', $totalOwnerSupplies);
        $sheet1->setCellValue('D2', $totalCostItems);
        $sheet1->setCellValue('E2', $totalVariationOrders);
        $sheet1->setCellValue('F2', 0);
        $sheet1->setCellValue('G2', $totalShipyardCostItems);
        $sheet1->setCellValue('H2', 0);
        $sheet1->setCellValue('I2', 0);
        
        

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $third_temp_file_path = getcwd() . '/' . get_setting("temp_file_path").'/'.$project_id."-cost-overview.xlsx";
        $writer->save($third_temp_file_path);
        // Write the Excel file content to the response body
        // return json_encode(array("success"=>true));
        $file_path_array=array();
        $file_path_array[]=array("file_name" => $project_id."-quotation-form.xlsx");
        $file_path_array[]=array("file_name" => $project_id."-project-form.xlsx");
        $file_path_array[]=array("file_name" => $project_id."-cost-overview.xlsx");
        $serialized_file_data = serialize($file_path_array);

        return $this->download_app_files(get_setting("temp_file_path"), $serialized_file_data);
    }
    function modal_import_quotation_file($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        return $this->template->view("projects/comparison/modal_import_items",["project_info"=>$project_info,"project_id"=>$project_id]);
    }
    function import_quotation_file(){
        $project_id=$this->request->getPost("project_id");
        $project_info=$this->Projects_model->get_one($project_id);
        $allShipyards=$this->Project_yards_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $project_info->status_id=5;
        $this->Projects_model->ci_save($project_info,$project_id);
        upload_file_to_temp(true);
        $file = get_array_value($_FILES, "file");

        // if (!$file) {
        //     die("Invalid file");
        // }
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $temp_file = get_array_value($file, "tmp_name");
        $file_name = get_array_value($file, "name");
        $file_size = get_array_value($file, "size");
        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);

        $excel_file->setActiveSheetIndex(0);
        $worksheet=$excel_file->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g., 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g., 'F'

        // Convert the highest column letter to a numeric index (e.g., 'F' => 6)
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        // Initialize an empty array to store the data
        $data = [];

        // Loop through each row and column to read the data
        for ($row = 1; $row <= $highestRow; ++$row) {
            $rowData = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $rowData[] = $cellValue;
            }
            $data[] = $rowData;
        }
        // return json_encode($data);
        $this->Shipyard_cost_items_model->delete_where(array("project_id"=>$project_id));
        $this->Task_cost_items_model->delete_where(array("project_id"=>$project_id));
        for($count=1;$count<count($data);$count++){
            // $task_info=$this->Tasks_model->get_one($task_id);
            foreach ($allShipyards as $oneYard) {
                # code...
                $saveData=array(
                    "shipyard_id"=>$oneYard->id,
                    "task_id"=>$data[$count][2],
                    "project_id"=>$project_id,
                    "name"=>$data[$count][6],
                    "description"=>$data[$count][7],
                    "quantity"=>$data[$count][9],
                    "measurement"=>$data[$count][10],
                    "unit_price"=>$data[$count][11],
                    "currency"=>$project_info->currency,
                    "discount"=>$data[$count][14],
                    "yard_remarks"=>$data[$count][16],
                );
                $this->Shipyard_cost_items_model->ci_save($saveData,null);
            }
            
            $saveCostItem=array(
                "task_id"=>$data[$count][2],
                "project_id"=>$project_id,
                "name"=>$data[$count][6],
                "description"=>$data[$count][7],
                "quantity"=>$data[$count][9],
                "measurement"=>$data[$count][10],
                "unit_price"=>$data[$count][11],
                "currency"=>$project_info->currency,
                "discount"=>$data[$count][14],
                "yard_remarks"=>$data[$count][16],
            );
            $this->Task_cost_items_model->ci_save($saveCostItem,null);
            
        }
        echo json_encode(array("success"=>true));
    }
    function download_project_specification_pdf($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        $project_detail=$this->Projects_model->get_details(array("id"=>$project_id))->getResult()[0];
        // return json_encode($project_detail);
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('enableRemote', true);

        $dompdf = new Dompdf($options);

        // Set document properties
        $dompdf->setPaper('A4', 'portrait');

        // Load HTML content (replace 'sample_html_content' with your HTML content)
        
        $client_info=$this->Clients_model->get_one($project_info->client_id);
        $vessel_info=$this->Vessel_types_model->get_one($client_info->type);
        $members=$this->Project_members_model->get_details(array("project_id"=>$project_id))->getResult();
        $tasks=$this->Tasks_model->get_details(array("project_id"=>$project_id))->getResult();
        $cost_items=$this->Task_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        // return json_encode($tasks);
        $view_data=[
            "tasks"=>$tasks,
            "members"=>$members,
            "vessel_info"=>$vessel_info,
            "project_info"=>$project_detail,
            "client_info"=>$client_info,
            "cost_items"=>$cost_items
        ];
        $first_page = $this->template->view('projects/export_pdf/pages/first_page',$view_data); // Load HTML view file
        // return $first_page;
        $dompdf->loadHtml($first_page);

        $dompdf->render();

        // Output the PDF as a file (example: my_pdf.pdf)
        $this->response->setHeader('Content-Type', 'application/pdf');
        $dompdf->stream('my_pdf.pdf', array('Attachment' => 0));
    }
    function export_project_form($project_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $project_info=$this->Projects_model->get_one($project_id);
        $allTasks=$this->Tasks_model->get_details(array("project_id"=>$project_id,"deleted"=>0))->getResult();
        // return json_encode($allTasks);

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Tasks');
        $sheet1->setCellValue('A1', 'Title');
        $sheet1->setCellValue('B1', 'Category');
        $sheet1->setCellValue('C1', 'Dock List Number');
        $sheet1->setCellValue('D1', 'Start Date');
        $sheet1->setCellValue('E1', 'Deadline');
        $sheet1->setCellValue('F1', 'Description');
        $sheet1->setCellValue('G1', 'Milestone');
        $sheet1->setCellValue('H1', 'Assigned To');
        $sheet1->setCellValue('I1', 'Collaborators');
        $sheet1->setCellValue('J1', 'Status');
        $sheet1->setCellValue('K1', 'Link to Task');
        $sheet1->setCellValue('L1', 'Location');
        $sheet1->setCellValue('M1', 'Specification');
        $sheet1->setCellValue('N1', 'Marker');
        $sheet1->setCellValue('O1', 'Type');
        $sheet1->setCellValue('P1', 'Refernece');
        $rowNumber=2;
        foreach ($allTasks as $oneTask) {
            // $task_info=$this->Tasks_model->get_one($oneTask->id);
            $sheet1->setCellValue('A'.$rowNumber, $oneTask->title);
            $sheet1->setCellValue('B'.$rowNumber, $oneTask->category);
            $sheet1->setCellValue('C'.$rowNumber, $oneTask->dock_list_number);
            $sheet1->setCellValue('D'.$rowNumber, $oneTask->start_date);
            $sheet1->setCellValue('E'.$rowNumber, $oneTask->deadline);
            $sheet1->setCellValue('F'.$rowNumber, $oneTask->description?$oneTask->description:"");
            $sheet1->setCellValue('G'.$rowNumber, $oneTask->milestone_title);
            $sheet1->setCellValue('h'.$rowNumber, $oneTask->assigned_to_user);
            $collaborators=explode(",",$oneTask->collaborator_list);
            $collaborators_names="";
            foreach($collaborators as $counter=>$oneCol){
                $oneColData=explode("--::--",$oneCol);
                if(array_key_exists(1,$oneColData)) $collaborators_names.=$oneColData[1];
                if($counter<count($collaborators)-1) $collaborators_names.=",";

            }
            $sheet1->setCellValue('I'.$rowNumber, $collaborators_names);
            $sheet1->setCellValue('J'.$rowNumber, $oneTask->status_title);
            $sheet1->setCellValue('K'.$rowNumber, get_uri("task_view/view/").$oneTask->id);
            $sheet1->setCellValue('L'.$rowNumber, $oneTask->location);
            $sheet1->setCellValue('M'.$rowNumber, $oneTask->specification);
            $sheet1->setCellValue('N'.$rowNumber, $oneTask->maker);
            $sheet1->setCellValue('O'.$rowNumber, $oneTask->type);
            // $sheet1->setCellValue('P'.$rowNumber, $oneTask->reference);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = service('response');

// Set response headers for file download
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="'.$project_info->title.'_project_form.xlsx"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // Write the Excel file content to the response body
        $writer->save('php://output');

        // Return the response object
        return $response;
    }
    function all_in_one($project_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $project_info=$this->Projects_model->get_one($project_id);
        $allTasks=$this->Tasks_model->get_details(array("project_id"=>$project_id,"deleted"=>0))->getResult();
        // return json_encode($allTasks);

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Tasks');
        $sheet1->setCellValue('A1', 'Title');
        $sheet1->setCellValue('B1', 'Category');
        $sheet1->setCellValue('C1', 'Dock List Number');
        $sheet1->setCellValue('D1', 'Start Date');
        $sheet1->setCellValue('E1', 'Deadline');
        $sheet1->setCellValue('F1', 'Description');
        $sheet1->setCellValue('G1', 'Milestone');
        $sheet1->setCellValue('H1', 'Assigned To');
        $sheet1->setCellValue('I1', 'Collaborators');
        $sheet1->setCellValue('J1', 'Status');
        $sheet1->setCellValue('K1', 'Link to Task');
        $sheet1->setCellValue('L1', 'Location');
        $sheet1->setCellValue('M1', 'Specification');
        $sheet1->setCellValue('N1', 'Marker');
        $sheet1->setCellValue('O1', 'Type');
        $sheet1->setCellValue('P1', 'Refernece');
        $rowNumber=2;
        foreach ($allTasks as $oneTask) {
            // $task_info=$this->Tasks_model->get_one($oneTask->id);
            $sheet1->setCellValue('A'.$rowNumber, $oneTask->title);
            $sheet1->setCellValue('B'.$rowNumber, $oneTask->category);
            $sheet1->setCellValue('C'.$rowNumber, $oneTask->dock_list_number);
            $sheet1->setCellValue('D'.$rowNumber, $oneTask->start_date);
            $sheet1->setCellValue('E'.$rowNumber, $oneTask->deadline);
            $sheet1->setCellValue('F'.$rowNumber, $oneTask->description?$oneTask->description:"");
            $sheet1->setCellValue('G'.$rowNumber, $oneTask->milestone_title);
            $sheet1->setCellValue('h'.$rowNumber, $oneTask->assigned_to_user);
            $collaborators=explode(",",$oneTask->collaborator_list);
            $collaborators_names="";
            foreach($collaborators as $counter=>$oneCol){
                $oneColData=explode("--::--",$oneCol);
                if(array_key_exists(1,$oneColData)) $collaborators_names.=$oneColData[1];
                if($counter<count($collaborators)-1) $collaborators_names.=",";

            }
            $sheet1->setCellValue('I'.$rowNumber, $collaborators_names);
            $sheet1->setCellValue('J'.$rowNumber, $oneTask->status_title);
            $sheet1->setCellValue('K'.$rowNumber, get_uri("task_view/view/").$oneTask->id);
            $sheet1->setCellValue('L'.$rowNumber, $oneTask->location);
            $sheet1->setCellValue('M'.$rowNumber, $oneTask->specification);
            $sheet1->setCellValue('N'.$rowNumber, $oneTask->maker);
            $sheet1->setCellValue('O'.$rowNumber, $oneTask->type);
            // $sheet1->setCellValue('P'.$rowNumber, $oneTask->reference);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $project_form_file_path = getcwd() . '/' . get_setting("project_file_path").'/'.$project_id."/project_form.xlsx";
        if(file_exists($project_form_file_path)) unlink($project_form_file_path);
        $writer->save($project_form_file_path);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        ////////////
        $allProjectCostItems=$this->Task_cost_items_model->get_all_where(array("project_id"=>$project_id,"deleted"=>0))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Cost items');
        $sheet1->setCellValue('A1', 'project_id');
        $sheet1->setCellValue('B1', 'project_title');
        $sheet1->setCellValue('C1', 'task_id');
        $sheet1->setCellValue('D1', 'task_title');
        $sheet1->setCellValue('E1', 'Group');
        $sheet1->setCellValue('F1', 'Cost item');
        $sheet1->setCellValue('G1', 'Description');
        $sheet1->setCellValue('H1', 'Cost type');
        $sheet1->setCellValue('I1', 'Est. quantity');
        $sheet1->setCellValue('J1', 'Measurement unit');
        $sheet1->setCellValue('K1', 'Unit price');
        $sheet1->setCellValue('L1', 'Unit price currency');
        $sheet1->setCellValue('M1', 'Quote');
        $sheet1->setCellValue('N1', 'Discount (0-100%)');
        $sheet1->setCellValue('O1', 'Discounted quote');
        $sheet1->setCellValue('P1', 'Yard remarks');
        $sheet1->setCellValue('Q1', 'Link to Task');
        $rowNumber=2;
        foreach ($allProjectCostItems as $oneItem) {
            $task_info=$this->Tasks_model->get_one($oneItem->task_id);
            $sheet1->setCellValue('A'.$rowNumber, $project_id);
            $sheet1->setCellValue('B'.$rowNumber, $project_info->title);
            $sheet1->setCellValue('C'.$rowNumber, $task_info->id);
            $sheet1->setCellValue('D'.$rowNumber, $task_info->title);
            $sheet1->setCellValue('E'.$rowNumber, $task_info->category);
            $sheet1->setCellValue('F'.$rowNumber, $oneItem->name);
            $sheet1->setCellValue('G'.$rowNumber, $oneItem->description);
            $sheet1->setCellValue('I'.$rowNumber, $oneItem->quantity);
            $sheet1->setCellValue('J'.$rowNumber, $oneItem->measurement);
            $sheet1->setCellValue('K'.$rowNumber, $oneItem->unit_price);
            $sheet1->setCellValue('L'.$rowNumber, $oneItem->currency);
            $sheet1->setCellValue('M'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity);
            $sheet1->setCellValue('N'.$rowNumber, $oneItem->discount);
            $sheet1->setCellValue('O'.$rowNumber, (float)$oneItem->unit_price*(float)$oneItem->quantity*(float)$oneItem->discount/100);
            $sheet1->setCellValue('P'.$rowNumber, $oneItem->yard_remarks);
            $sheet1->setCellValue('Q'.$rowNumber, get_uri("task_view/view/").$oneItem->task_id);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Write the Excel file content to the response body
        $quotation_form_file_path = getcwd() . '/' . get_setting("project_file_path").'/'.$project_id."/quotation_form.xlsx";
        if(file_exists($quotation_form_file_path)) unlink($quotation_form_file_path);
        $writer->save($quotation_form_file_path);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Return the response object
        // return $response;
        ////////////////////////////////

        $allCostItems=$this->Task_cost_items_model->get_all_with_costs_where(array("project_id"=>$project_id))->getResult();
        $allShipyardCostItems=[];
        if($project_info->status_id==4){
            $selected_yards=$this->Project_yards_model->get_all_where(array("project_id"=>$project_id))->getResult();
            if(count($selected_yards)>0)
                $allShipyardCostItems=$this->Shipyard_cost_items_model->get_all_with_costs_where(array("shipyard_id"=>$selected_yards[0]->id))->getResult();
        }
        $allTasks=$this->Tasks_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allVariationOrders=$this->Task_variation_orders_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allOwnerSupplies=$this->Task_owner_supplies_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $allComments=$this->Task_comments_model->get_all_where(array("project_id"=>$project_id))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Cost Overview');

        $categorizedTasks=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedOwnerSupplies=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedCostItems=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedShipyardCostItems=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedVariationOrders=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        
        $categorizedComments=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        $categorizedStats=array(
            "General & Docking"=>array(),
            "Hull"=>array(),
            "Equipment for Cargo"=>array(),
            "Ship Equipment"=>array(),
            "Safety & Crew Equipment"=>array(),
            "Machinery Main Components"=>array(),
            "System Machinery Main Components"=>array(),
            "Common systems"=>array(),
            "Others"=>array(),
        );
        
        foreach ($allTasks as $index => $oneTask) {
            if(isset($categorizedTasks[$oneTask->category]))
                $categorizedTasks[$oneTask->category][]=$oneTask;
            else $categorizedTasks["Others"][]=$oneTask;
        
            if(isset($categorizedOwnerSupplies[$oneTask->category]))
                $categorizedOwnerSupplies[$oneTask->category]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
                    return $oneTask->id==$oneSupply->task_id;
                });
            else $categorizedOwnerSupplies["Others"]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
                return $oneTask->id==$oneSupply->task_id;
            });
        
            if(isset($categorizedCostItems[$oneTask->category]))
                $categorizedCostItems[$oneTask->category]+=array_filter($allCostItems,function($oneItem)use($oneTask){
                    return $oneTask->id==$oneItem->task_id;
                });
            else $categorizedCostItems["Others"]+=array_filter($allCostItems,function($oneItem)use($oneTask){
                return $oneTask->id==$oneItem->task_id;
            });
        
            if(isset($categorizedShipyardCostItems[$oneTask->category]))
                $categorizedShipyardCostItems[$oneTask->category]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
                    return $oneTask->id==$oneItem->task_id;
                });
            else $categorizedShipyardCostItems["Others"]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
                return $oneTask->id==$oneItem->task_id;
            });
        
            if(isset($categorizedVariationOrders[$oneTask->category]))
                $categorizedVariationOrders[$oneTask->category]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
                    return $oneTask->id==$oneOrder->task_id;
                });
            else $categorizedVariationOrders["Others"]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
                return $oneTask->id==$oneOrder->task_id;
            });
        
            if(isset($categorizedComments[$oneTask->category]))
                $categorizedComments[$oneTask->category]+=array_filter($allComments,function($oneComment)use($oneTask){
                    return $oneTask->id==$oneComment->task_id;
                });
            else $categorizedComments["Others"]+=array_filter($allComments,function($oneComment)use($oneTask){
                return $oneTask->id==$oneComment->task_id;
            });
        }
        
        $totalOwnerSupplies=0;
        $totalVariationOrders=0;
        $totalCostItems=0;
        $totalCosts=0;
        $totalShipyardCostItems=0;
        $totalComments=0;
        $sheet1->setCellValue('A1', "Category");
        $sheet1->setCellValue('B1', "Task");
        $sheet1->setCellValue('C1', "Owner's supply");
        $sheet1->setCellValue('D1', "Quoted");
        $sheet1->setCellValue('E1', "Variation orders");
        $sheet1->setCellValue('F1', "Total");
        $sheet1->setCellValue('G1', 'Total yard');
        $sheet1->setCellValue('H1', "Billed yard");
        $sheet1->setCellValue('I1', "Final yard");
        $sheet1->setCellValue('J1', 'Comments');

        $sheet1->setCellValue('B2', "Total:");
        $sheet1->setCellValue('C2', 0);
        $sheet1->setCellValue('D2', 0);
        $sheet1->setCellValue('E2', 0);
        $sheet1->setCellValue('F2', 0);
        $sheet1->setCellValue('G2', 0);
        $sheet1->setCellValue('H2', 0);
        $sheet1->setCellValue('I2', 0);
        $sheet1->setCellValue('J2', 0);

        $rowIndex=3;
        foreach ($categorizedTasks as $category=>$oneList) {
            $categoryOwnerSupply=0;
            $categoryCostItems=0;
            $categoryTotalCosts=0;
            $categoryShipyardCostItems=0;
            $categoryVariationOrder=0;
            $categoryComments=0;
            $sheet1->setCellValue('A'.$rowIndex, $category);
            $sheet1->setCellValue('B'.$rowIndex, 0);
            $sheet1->setCellValue('C'.$rowIndex, 0);
            $sheet1->setCellValue('D'.$rowIndex, 0);
            $sheet1->setCellValue('E'.$rowIndex, 0);
            $sheet1->setCellValue('F'.$rowIndex, 0);
            $sheet1->setCellValue('G'.$rowIndex, 0);
            $sheet1->setCellValue('H'.$rowIndex, 0);
            $sheet1->setCellValue('I'.$rowIndex, 0);
            $sheet1->setCellValue('J'.$rowIndex, 0);
            $category_row=$rowIndex;
            $rowIndex++;
            foreach ($oneList as $key => $oneTask) {
                
                $oneTaskSupplies=array_filter($categorizedOwnerSupplies[$category],function($oneSupply)use($oneTask){
                    return $oneSupply->task_id==$oneTask->id;
                });
                $oneTaskCostItems=array_filter($categorizedCostItems[$category],function($oneItem)use($oneTask){
                    return $oneItem->task_id==$oneTask->id;
                });
                $oneTaskShipyardCostItems=array_filter($categorizedShipyardCostItems[$category],function($oneItem)use($oneTask){
                    return $oneItem->task_id==$oneTask->id;
                });
                $oneTaskVariationOrders=array_filter($categorizedVariationOrders[$category],function($oneOrder)use($oneTask){
                    return $oneOrder->task_id==$oneTask->id;
                });
                $oneTaskComments=array_filter($categorizedComments[$category],function($oneComment)use($oneTask){
                    return $oneComment->task_id==$oneTask->id;
                });
                $oneTaskTotalSupplies=0;
                foreach ($oneTaskSupplies as $oneSupply) {
                    $oneTaskTotalSupplies+=$oneSupply->cost;
                }
                $categoryOwnerSupply+=$oneTaskTotalSupplies;

                $oneTaskTotalCostItems=0;
                foreach ($oneTaskCostItems as $oneItem) {
                    $oneTaskTotalCostItems+=$oneItem->total_cost;
                }
                $categoryCostItems+=$oneTaskTotalCostItems;

                $oneTaskTotalCosts=$oneTaskTotalSupplies+$oneTaskTotalCostItems;
                $categoryTotalCosts+=$oneTaskTotalCosts;

                $oneTaskTotalShipyardCostItems=0;
                foreach ($oneTaskShipyardCostItems as $oneItem) {
                    $oneTaskTotalShipyardCostItems+=$oneItem->total_cost;
                }
                $categoryShipyardCostItems+=$oneTaskTotalShipyardCostItems;

                $oneTaskTotalVariationOrders=0;
                foreach ($oneTaskVariationOrders as $oneOrder) {
                    $oneTaskTotalVariationOrders+=$oneOrder->cost;
                }
                $categoryVariationOrder+=$oneTaskTotalVariationOrders;

                $oneTaskTotalComments=count($oneTaskComments);
                $categoryComments+=$oneTaskTotalComments;

                
                $totalOwnerSupplies+=$oneTaskTotalSupplies;
                $totalCostItems+=$oneTaskTotalCostItems;
                $totalShipyardCostItems+=$oneTaskTotalShipyardCostItems;
                $totalVariationOrders+=$oneTaskTotalVariationOrders;
                $totalComments+=$oneTaskTotalComments;
                $totalCosts+=($oneTaskTotalSupplies+$oneTaskTotalCostItems);

                $sheet1->setCellValue('B'.$rowIndex, $oneTask->title);
                $sheet1->setCellValue('C'.$rowIndex, $oneTaskTotalSupplies);
                $sheet1->setCellValue('D'.$rowIndex, $oneTaskTotalCostItems);
                $sheet1->setCellValue('E'.$rowIndex, $oneTaskTotalVariationOrders);
                $sheet1->setCellValue('F'.$rowIndex, $oneTaskTotalCosts);
                $sheet1->setCellValue('G'.$rowIndex, $oneTaskTotalShipyardCostItems);
                $sheet1->setCellValue('H'.$rowIndex, 0);
                $sheet1->setCellValue('I'.$rowIndex, 0);
                $sheet1->setCellValue('J'.$rowIndex, $oneTaskTotalComments);
                $rowIndex++;
            }
            $categorizedStats[$category]["owner_supplies"]=$categoryOwnerSupply;
            $categorizedStats[$category]["cost_items"]=$categoryCostItems;
            $categorizedStats[$category]["variation_orders"]=$categoryVariationOrder;
            $categorizedStats[$category]["shipyard_cost_items"]=$categoryShipyardCostItems;
            $categorizedStats[$category]["comments"]=$categoryComments;
            $sheet1->setCellValue('B'.$category_row, "");
            $sheet1->setCellValue('C'.$category_row, $categoryOwnerSupply);
            $sheet1->setCellValue('D'.$category_row, $categoryCostItems);
            $sheet1->setCellValue('E'.$category_row, $categoryVariationOrder);
            $sheet1->setCellValue('F'.$category_row, $categoryTotalCosts);
            $sheet1->setCellValue('G'.$category_row, $categoryShipyardCostItems);
            $sheet1->setCellValue('H'.$category_row, 0);
            $sheet1->setCellValue('I'.$category_row, $categoryComments);
        }
        $sheet1->setCellValue('C2', $totalOwnerSupplies);
        $sheet1->setCellValue('D2', $totalCostItems);
        $sheet1->setCellValue('E2', $totalVariationOrders);
        $sheet1->setCellValue('F2', $totalCosts);
        $sheet1->setCellValue('G2', $totalShipyardCostItems);
        $sheet1->setCellValue('H2', 0);
        $sheet1->setCellValue('I2', 0);
        $sheet1->setCellValue('J2', $totalComments);
        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $cost_form_file_path=getcwd() . '/' . get_setting("project_file_path").'/'.$project_id."/cost_form.xlsx";

        // Write the Excel file content to the response body
        if(file_exists($cost_form_file_path)) unlink($cost_form_file_path);
        
        $writer->save($cost_form_file_path);
        ////////////////////////////////
        $files_info = $this->Project_files_model->get_all_where(array("project_id" => $project_id, "deleted" => 0))->getResult();

        // if (count($files_info) > 0) {
            $project_id = 0;
            $file_path_array = array();
            foreach ($files_info as $file_info) {
                //we have to check the permission for each file
                //initialize the permission check only if the project id is different
    
                if ($project_id != $file_info->project_id) {
                    $this->init_project_permission_checker($file_info->project_id);
                    $project_id = $file_info->project_id;
                }
    
                if (!$this->can_view_files()) {
                    app_redirect("forbidden");
                }
    
                $file_path_array[] = array("file_name" => $file_info->project_id . "/" . $file_info->file_name, "file_id" => $file_info->file_id, "service_type" => $file_info->service_type);
    
            }
            
            $file_path_array[]=array("file_name" => $file_info->project_id . "/" ."project_form.xlsx","file_id" =>"", "service_type" =>"");
            $file_path_array[]=array("file_name" =>$file_info->project_id . "/" ."quotation_form.xlsx","file_id" =>"", "service_type" =>"");
            $file_path_array[]=array("file_name" =>$file_info->project_id . "/" ."cost_form.xlsx","file_id" =>"", "service_type" =>"");
            
            $serialized_file_data = serialize($file_path_array);

            // return json_encode($serialized_file_data);
            return $this->download_app_files(get_setting("project_file_path"), $serialized_file_data);
        // }
        // return '<script>window.close();</script>';
    }
    function import_yard_quotation_file(){
        $shipyard_id=$this->request->getPost("shipyard_id");
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $project_info=$this->Projects_model->get_one($shipyard_info->project_id);
        // $allShipyards=$this->Project_yards_model->get_all_where(array("project_id"=>$project_id))->getResult();

        upload_file_to_temp(true);
        $file = get_array_value($_FILES, "file");

        // if (!$file) {
        //     die("Invalid file");
        // }
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $temp_file = get_array_value($file, "tmp_name");
        $file_name = get_array_value($file, "name");
        $file_size = get_array_value($file, "size");
        $temp_file_path = get_setting("temp_file_path");
        $excel_file = \PhpOffice\PhpSpreadsheet\IOFactory::load($temp_file_path . $file_name);

        $excel_file->setActiveSheetIndex(0);
        $worksheet=$excel_file->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g., 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g., 'F'

        // Convert the highest column letter to a numeric index (e.g., 'F' => 6)
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        // Initialize an empty array to store the data
        $data = [];

        // Loop through each row and column to read the data
        for ($row = 1; $row <= $highestRow; ++$row) {
            $rowData = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $rowData[] = $cellValue;
            }
            $data[] = $rowData;
        }
        // return json_encode($data);
        $this->Shipyard_cost_items_model->delete_where(array("shipyard_id"=>$shipyard_id));
        for($count=1;$count<count($data);$count++){
            // $task_info=$this->Tasks_model->get_one($task_id);
            // foreach ($allShipyards as $oneYard) {
                # code...
                $saveData=array(
                    "shipyard_id"=>$shipyard_id,
                    "task_id"=>$data[$count][2],
                    "project_id"=>$shipyard_info->project_id,
                    "name"=>$data[$count][6],
                    "description"=>$data[$count][7],
                    "quantity"=>$data[$count][9],
                    "measurement"=>$data[$count][10],
                    "unit_price"=>$data[$count][11],
                    "currency"=>$project_info->currency,
                    "discount"=>$data[$count][14],
                    "yard_remarks"=>$data[$count][16],
                );
                $this->Shipyard_cost_items_model->ci_save($saveData,null);
            // }
            
        }
        echo json_encode(array("success"=>true));
    }
    function export_yard_quotation($shipyard_id){
        require_once(APPPATH . "ThirdParty/PHPOffice-PhpSpreadsheet/vendor/autoload.php");
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $shipyard_info=$this->Project_yards_model->get_one($shipyard_id);
        $project_info=$this->Projects_model->get_one($shipyard_info->project_id);
        $allShipyardCostItems=$this->Shipyard_cost_items_model->get_all_with_costs_where(array("shipyard_id"=>$shipyard_id))->getResult();

        // Add data to the first worksheet
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Cost items');
        $sheet1->setCellValue('A1', 'Project ID');
        $sheet1->setCellValue('B1', 'Project Title');
        $sheet1->setCellValue('C1', 'Task ID');
        $sheet1->setCellValue('D1', 'Task Title');
        $sheet1->setCellValue('E1', 'Group');
        $sheet1->setCellValue('F1', 'Dock List Number');
        $sheet1->setCellValue('G1', 'Cost item');
        $sheet1->setCellValue('H1', 'Description');
        $sheet1->setCellValue('I1', 'Cost type');
        $sheet1->setCellValue('J1', 'Est. quantity');
        $sheet1->setCellValue('K1', 'Measurement unit');
        $sheet1->setCellValue('L1', 'Unit price');
        $sheet1->setCellValue('M1', 'Unit price currency');
        $sheet1->setCellValue('N1', 'Quote');
        $sheet1->setCellValue('O1', 'Discount (0-100%)');
        $sheet1->setCellValue('P1', 'Discounted quote');
        $sheet1->setCellValue('Q1', 'Yard remarks');
        $sheet1->setCellValue('R1', 'Link to Task');
        $rowNumber=2;
        foreach ($allShipyardCostItems as $oneItem) {
            $task_info=$this->Tasks_model->get_one($oneItem->task_id);
            $sheet1->setCellValue('A'.$rowNumber, $project_info->id);
            $sheet1->setCellValue('B'.$rowNumber, $project_info->title);
            $sheet1->setCellValue('C'.$rowNumber, $task_info->id);
            $sheet1->setCellValue('D'.$rowNumber, $task_info->title);
            $sheet1->setCellValue('E'.$rowNumber, $task_info->category);
            $sheet1->setCellValue('F'.$rowNumber, $task_info->dock_list_number);
            $sheet1->setCellValue('G'.$rowNumber, $oneItem->name);
            $sheet1->setCellValue('H'.$rowNumber, $oneItem->description);
            $sheet1->setCellValue('I'.$rowNumber, $oneItem->quote_type);
            $sheet1->setCellValue('J'.$rowNumber, $oneItem->quantity);
            $sheet1->setCellValue('K'.$rowNumber, $oneItem->measurement);
            $sheet1->setCellValue('L'.$rowNumber, $oneItem->unit_price);
            $sheet1->setCellValue('M'.$rowNumber, $oneItem->currency);
            $sheet1->setCellValue('N'.$rowNumber, $oneItem->currency." ".(float)$oneItem->unit_price*(float)$oneItem->quantity);
            $sheet1->setCellValue('O'.$rowNumber, $oneItem->discount." %");
            $sheet1->setCellValue('P'.$rowNumber, $oneItem->currency." ".$oneItem->total_cost);
            $sheet1->setCellValue('Q'.$rowNumber, $oneItem->yard_remarks);
            $sheet1->setCellValue('R'.$rowNumber, get_uri("task_view/view/").$oneItem->task_id);
            $rowNumber++;
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = service('response');

// Set response headers for file download
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="'.$shipyard_info->title.'_yard_quotation_form.xlsx"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // Write the Excel file content to the response body
        $writer->save('php://output');

        // Return the response object
        return $response;
    }
    function save_report_document(){
        $title=$this->request->getPost('title');
        $description=$this->request->getPost('description');
        $content=$this->request->getPost('content');
        $id=$this->request->getPost('id');
        $project_id=$this->request->getPost("project_id");
        $new_data=array(
            "title"=>$title,
            "description"=>$description,
            "content"=>$content,
            "project_id"=>$project_id
        );
        $saved_id=$this->Report_documents_model->ci_save($new_data,$id);
        return json_encode(array("success"=>true,"saved_id"=>$saved_id));
    }
    function delete_report_document(){
        $report_id=$this->request->getPost('id');
        $this->Report_documents_model->delete_permanently($report_id);
        return json_encode(array("success"=>true));
    }
    
    function tab_report_documents($project_id){
        $project_info=$this->Projects_model->get_one($project_id);
        $allTemplates=$this->Report_templates_model->get_all()->getResult();
        return $this->template->view("projects/report_documents/index",["project_info"=>$project_info,"allTemplates"=>$allTemplates]);
    }
    function report_documents_list_data($project_id){
        $allDocuments=$this->Report_documents_model->get_all_where(array("project_id"=>$project_id))->getResult();
        $data=array();
        foreach ($allDocuments as $key => $oneDocument) {
            $data[]=array(
                $oneDocument->id,
                '<a href="'.get_uri('projects/report_documents/'.$oneDocument->id).'" >'.$oneDocument->title.'</a>',
                js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_note'), "class" => "delete", "data-id" => $oneDocument->id, "data-action-url" => get_uri("projects/delete_report_document"), "data-action" => "delete-confirmation"))
            );
        }
        return json_encode(array("data"=>$data));
    }
    function report_documents($id){
        $document_info=$this->Report_documents_model->get_one($id);
        $project_detail=$this->Projects_model->get_details(array("id"=>$document_info->project_id))->getResult()[0];
        return $this->template->rander("projects/report_documents/edit",["document_info"=>$document_info,"project_detail"=>$project_detail]);
    }
    function report_templates($project_id,$template_id){
        $project_info=$this->Projects_model->get_one($project_id);
        $project_detail=$this->Projects_model->get_details(array("id"=>$project_id))->getResult()[0];
        $client_info=$this->Clients_model->get_details(array("id"=>$project_info->client_id))->getResult()[0];
        $template_info=$this->Report_templates_model->get_one($template_id);
        return $this->template->rander("projects/report_documents/template",["client_info"=>$client_info,"project_detail"=>$project_detail,"template_info"=>$template_info]);
    }
    function modal_report_edit(){
        return $this->template->view("projects/report_documents/editor");
    }

}

/* End of file projects.php */
/* Location: ./app/controllers/projects.php */