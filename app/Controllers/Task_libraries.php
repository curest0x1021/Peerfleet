<?php

namespace App\Controllers;

class Task_libraries extends Security_Controller {
    public function __construct() {
        parent::__construct();
        // $this->access_only_admin_or_settings_admin();
    }

    function index() {
        $allProjectIds=$this->Projects_model->get_dropdown_list(array("id","id"));
        $allProjects=$this->Projects_model->get_dropdown_list(array("id","title"));
        $allTasks=$this->Tasks_model->get_all()->getResultarray();
        $allCategories=$this->Labels_model->get_all_where(array("context"=>"task"))->getResultArray();
        $allContexts = $this->Tasks_model->get_enum_values('pf_tasks', 'context');
        return $this->template->rander('task_libraries/index',["allProjectIds"=>$allProjectIds,"allProjects"=>$allProjects,"allTasks"=>$allTasks,"allContexts"=>$allContexts,'allCategories'=>$allCategories]);
    }

    function save(){
        $project_id = $this->request->getPost('project_id');
        $id = $this->request->getPost('id');
        $add_type = $this->request->getPost('add_type');
        $now = get_current_utc_time();

        $is_clone = $this->request->getPost('is_clone');
        $main_task_id = "";
        if ($is_clone && $id) {
            $main_task_id = $id; //store main task id to get items later
            $id = ""; //on cloning task, save as new
        }

        $client_id = $this->request->getPost('client_id');
        $lead_id = $this->request->getPost('lead_id');
        $invoice_id = $this->request->getPost('invoice_id');
        $estimate_id = $this->request->getPost('estimate_id');
        $order_id = $this->request->getPost('order_id');
        $contract_id = $this->request->getPost('contract_id');
        $proposal_id = $this->request->getPost('proposal_id');
        $subscription_id = $this->request->getPost('subscription_id');
        $expense_id = $this->request->getPost('expense_id');
        $ticket_id = $this->request->getPost('ticket_id');
        $supplier = $this->request->getPost('supplier');

        // $context_data = $this->get_context_and_id();
        
        // $context = $context_data["context"] ? $context_data["context"] : "project";
        $context="project";

        if ($id) {
            $task_info = $this->Tasks_model->get_one($id);
            if (!$this->can_edit_tasks($task_info)) {
                app_redirect("forbidden");
            }
        } else {
            if (!$this->can_create_tasks($context)) {
                app_redirect("forbidden");
            }
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "supplier" => "numeric",
            "title" => "required|max_length[60]",
            "project_id" => "required",
            "labels" => "required",
            "dock_list_number" => "max_length[15]",
            "reference_drawing" => "max_length[30]",
            "location" => "max_length[300]",
            "specification" => "max_length[300]",
            "requisition_number" => "max_length[30]",
            "budget" => "max_length[30]",
            "maker" => "max_length[30]",
            "type" => "max_length[30]",
            "serial_number" => "max_length[30]",
            "pms_scs_number" => "max_length[30]"
        ));

        $points = $this->request->getPost('points') ?? 1;
        $milestone_id = $this->request->getPost('milestone_id') ?? 0;
        $start_date = $this->request->getPost('start_date');
        $assigned_to = $this->request->getPost('assigned_to');
        $collaborators = $this->request->getPost('collaborators');
        $recurring = $this->request->getPost('recurring') ? 1 : 0;
        $repeat_every = $this->request->getPost('repeat_every');
        $repeat_type = $this->request->getPost('repeat_type');
        $no_of_cycles = $this->request->getPost('no_of_cycles');
        $status_id = $this->request->getPost('status_id');
        $priority_id = $this->request->getPost('priority_id') ?? 0;

        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description'),
            "project_id" => $project_id ? $project_id : 0,
            "milestone_id" => $milestone_id ? $milestone_id : 0,
            "points" => $points,
            "status_id" => $status_id,
            "priority_id" => $priority_id,
            "supplier" => $supplier,
            "labels" => $this->request->getPost('labels'),
            "start_date" => date('Y-m-d', strtotime($start_date)),
            "deadline" => date('Y-m-d', strtotime($this->request->getPost('deadline'))),
            "recurring" => $recurring,
            "repeat_every" => $repeat_every ? $repeat_every : 0,
            "repeat_type" => $repeat_type ? $repeat_type : NULL,
            "no_of_cycles" => $no_of_cycles ? $no_of_cycles : 0,
            "dock_list_number" => $this->request->getPost("dock_list_number"),
            "reference_drawing" => $this->request->getPost("reference_drawing"),
            "location" => $this->request->getPost("location"),
            "specification" => $this->request->getPost("specification"),
            "requisition_number" => $this->request->getPost("requisition_number"),
            "budget" => $this->request->getPost("budget"),
            "gas_free_certificate" => $this->request->getPost("gas_free_certificate"),
            "light" => $this->request->getPost("light"),
            "ventilation" => $this->request->getPost("ventilation"),
            "crane_assistance" => $this->request->getPost("crane_assistance"),
            "cleaning_before" => $this->request->getPost("cleaning_before"),
            "cleaning_after" => $this->request->getPost("cleaning_after"),
            "work_permit" => $this->request->getPost("work_permit"),
            "painting_after_completion" => $this->request->getPost("painting_after_completion"),
            "parts_on_board" => $this->request->getPost("parts_on_board"),
            "transport_to_yard_workshop" => $this->request->getPost("transport_to_yard_workshop"),
            "transport_outside_yard" => $this->request->getPost("transport_outside_yard"),
            "material_yards_supply" => $this->request->getPost("material_yards_supply"),
            "material_owners_supply" => $this->request->getPost("material_owners_supply"),
            "risk_assessment" => $this->request->getPost("risk_assessment"),
            "maker" => $this->request->getPost("maker"),
            "type" => $this->request->getPost("type"),
            "serial_number" => $this->request->getPost("serial_number"),
            "pms_scs_number" => $this->request->getPost("pms_scs_number"),
            "cost_type" => $this->request->getPost("cost_type"),
            "est_quantity" => $this->request->getPost("est_quantity"),
            "measurement_unit" => $this->request->getPost("measurement_unit"),
            "unit_price" => $this->request->getPost("unit_price"),
            "unit_price_currency" => $this->request->getPost("unit_price_currency"),
            "quote" => $this->request->getPost("quote"),
            "discount" => $this->request->getPost("discount"),
            "remarks" => $this->request->getPost("remarks"),
        );

        if (!$id) {
            $data["created_date"] = $now;
            $data["context"] = $context;
            // $data["sort"] = $this->Tasks_model->get_next_sort_value($project_id, $status_id);
        }

        if ($ticket_id) {
            $data["ticket_id"] = $ticket_id;
        }

        //clint can't save the assign to and collaborators
        if ($this->login_user->user_type == "client") {
            if (get_setting("client_can_assign_tasks")) {
                $data["assigned_to"] = $assigned_to;
            } else if (!$id) { //it's new data to save
                $data["assigned_to"] = 0;
            }

            $data["collaborators"] = "";
        } else {
            $data["assigned_to"] = $assigned_to;
            $data["collaborators"] = $collaborators;
        }

        $data = clean_data($data);

        //set null value after cleaning the data
        if (!$data["start_date"]) {
            $data["start_date"] = NULL;
        }

        if (!$data["deadline"]) {
            $data["deadline"] = NULL;
        }

        //deadline must be greater or equal to start date
        if ($data["start_date"] && $data["deadline"] && $data["deadline"] < $data["start_date"]) {
            echo json_encode(array("success" => false, 'message' => app_lang('deadline_must_be_equal_or_greater_than_start_date')));
            return false;
        }

        $copy_checklist = $this->request->getPost("copy_checklist");

        $next_recurring_date = "";

        if ($recurring && get_setting("enable_recurring_option_for_tasks")) {
            //set next recurring date for recurring tasks

            if ($id) {
                //update
                if ($this->request->getPost('next_recurring_date')) { //submitted any recurring date? set it.
                    $next_recurring_date = $this->request->getPost('next_recurring_date');
                } else {
                    //re-calculate the next recurring date, if any recurring fields has changed.
                    if ($task_info->recurring != $data['recurring'] || $task_info->repeat_every != $data['repeat_every'] || $task_info->repeat_type != $data['repeat_type'] || $task_info->start_date != $data['start_date']) {
                        $recurring_start_date = $start_date ? $start_date : $task_info->created_date;
                        $next_recurring_date = add_period_to_date($recurring_start_date, $repeat_every, $repeat_type);
                    }
                }
            } else {
                //insert new
                $recurring_start_date = $start_date ? $start_date : get_array_value($data, "created_date");
                $next_recurring_date = add_period_to_date($recurring_start_date, $repeat_every, $repeat_type);
            }


            //recurring date must have to set a future date
            if ($next_recurring_date && get_today_date() >= $next_recurring_date) {
                echo json_encode(array("success" => false, 'message' => app_lang('past_recurring_date_error_message_title_for_tasks'), 'next_recurring_date_error' => app_lang('past_recurring_date_error_message'), "next_recurring_date_value" => $next_recurring_date));
                return false;
            }
        }

        //save status changing time for edit mode
        if ($id) {
            if ($task_info->status_id !== $status_id) {
                $data["status_changed_at"] = $now;
            }

            $this->check_sub_tasks_statuses($status_id, $id);
        }

        $save_id = $this->Tasks_model->ci_save($data, $id);
        if ($save_id) {

            if ($is_clone && $main_task_id) {
                //clone task checklist
                if ($copy_checklist) {
                    $checklist_items = $this->Checklist_items_model->get_all_where(array("task_id" => $main_task_id, "deleted" => 0))->getResult();
                    foreach ($checklist_items as $checklist_item) {
                        //prepare new checklist data
                        $checklist_item_data = (array) $checklist_item;
                        unset($checklist_item_data["id"]);
                        $checklist_item_data['task_id'] = $save_id;

                        $checklist_item = $this->Checklist_items_model->ci_save($checklist_item_data);
                    }
                }

                //clone sub tasks
                if ($this->request->getPost("copy_sub_tasks")) {
                    $sub_tasks = $this->Tasks_model->get_all_where(array("parent_task_id" => $main_task_id, "deleted" => 0))->getResult();
                    foreach ($sub_tasks as $sub_task) {
                        //prepare new sub task data
                        $sub_task_data = (array) $sub_task;

                        unset($sub_task_data["id"]);
                        unset($sub_task_data["blocked_by"]);
                        unset($sub_task_data["blocking"]);

                        $sub_task_data['status_id'] = 1;
                        $sub_task_data['parent_task_id'] = $save_id;
                        $sub_task_data['created_date'] = $now;

                        $sub_task_data["sort"] = $this->Tasks_model->get_next_sort_value($sub_task_data["project_id"], $sub_task_data['status_id']);

                        $sub_task_save_id = $this->Tasks_model->ci_save($sub_task_data);

                        //clone sub task checklist
                        if ($copy_checklist) {
                            $checklist_items = $this->Checklist_items_model->get_all_where(array("task_id" => $sub_task->id, "deleted" => 0))->getResult();
                            foreach ($checklist_items as $checklist_item) {
                                //prepare new checklist data
                                $checklist_item_data = (array) $checklist_item;
                                unset($checklist_item_data["id"]);
                                $checklist_item_data['task_id'] = $sub_task_save_id;

                                $this->Checklist_items_model->ci_save($checklist_item_data);
                            }
                        }
                    }
                }
            }

            //save next recurring date 
            if ($next_recurring_date) {
                $recurring_task_data = array(
                    "next_recurring_date" => $next_recurring_date
                );
                $this->Tasks_model->save_reminder_date($recurring_task_data, $save_id);
            }

            // if created from ticket then save the task id
            if ($ticket_id) {
                $data = array("task_id" => $save_id);
                $this->Tickets_model->ci_save($data, $ticket_id);
            }

            $activity_log_id = get_array_value($data, "activity_log_id");

            $new_activity_log_id = save_custom_fields("tasks", $save_id, $this->login_user->is_admin, $this->login_user->user_type, $activity_log_id);

            if ($id) {
                //updated
                if ($task_info->context === "project") {
                    log_notification("project_task_updated", array("project_id" => $project_id, "task_id" => $save_id, "activity_log_id" => $new_activity_log_id ? $new_activity_log_id : $activity_log_id));
                } else {
                    $context_id_key = $task_info->context . "_id";
                    $context_id_value = ${$task_info->context . "_id"};

                    log_notification("general_task_updated", array("$context_id_key" => $context_id_value, "task_id" => $save_id, "activity_log_id" => $new_activity_log_id ? $new_activity_log_id : $activity_log_id));
                }
            } else {
                //created
                if ($context === "project") {
                    log_notification("project_task_created", array("project_id" => $project_id, "task_id" => $save_id));
                } else {
                    $context_id_key = $context . "_id";
                    $context_id_value = ${$context . "_id"};

                    log_notification("general_task_created", array("$context_id_key" => $context_id_value, "task_id" => $save_id));
                }

                //save uploaded files as comment
                $target_path = get_setting("timeline_file_path");
                $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "project_comment");

                if ($files_data && $files_data != "a:0:{}") {
                    $comment_data = array(
                        "created_by" => $this->login_user->id,
                        "created_at" => $now,
                        "project_id" => $project_id,
                        "task_id" => $save_id
                    );

                    $comment_data = clean_data($comment_data);

                    $comment_data["files"] = $files_data; //don't clean serilized data

                    $this->Project_comments_model->save_comment($comment_data);
                }
            }

            return redirect()->to('/task_libraries');
            // echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved'), "add_type" => $add_type));
        } else {
            return redirect()->to('/task_libraries');
            // echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
        
    }

    private function get_context_and_id($model_info = null) {
        $context_id_pairs = $this->get_context_id_pairs();

        foreach ($context_id_pairs as $pair) {
            $id_key = $pair["id_key"];
            $id = $model_info ? ($model_info->$id_key ? $model_info->$id_key : null) : null;

            $request = request(); //needed when loading controller from widget helper

            if ($id !== null) {
                $pair["id"] = $id;
            } else if ($request->getPost($id_key)) {
                $pair["id"] = $request->getPost($id_key);
            }

            if ($pair["id"] !== null) {
                return $pair;
            }
        }

        return array("context" => "project", "id" => null);
    }

    private function get_context_id_pairs() {
        return array(
            array("context" => "project", "id_key" => "project_id", "id" => null), //keep the 1st item as project since it'll be used maximum times
            array("context" => "client", "id_key" => "client_id", "id" => null),
            array("context" => "contract", "id_key" => "contract_id", "id" => null),
            array("context" => "estimate", "id_key" => "estimate_id", "id" => null),
            array("context" => "expense", "id_key" => "expense_id", "id" => null),
            array("context" => "invoice", "id_key" => "invoice_id", "id" => null),
            array("context" => "lead", "id_key" => "lead_id", "id" => null),
            array("context" => "order", "id_key" => "order_id", "id" => null),
            array("context" => "proposal", "id_key" => "proposal_id", "id" => null),
            array("context" => "subscription", "id_key" => "subscription_id", "id" => null),
            array("context" => "ticket", "id_key" => "ticket_id", "id" => null)
        );
    }

    function view($parameter){
        $allProjects=$this->Projects_model->get_dropdown_list(array("id","title"));
        $allTasks=$this->Tasks_model->get_all()->getResultarray();
        $gotTask=$this->Tasks_model->get_one(array("id"=>$parameter));
        $gotLabels=explode(",",$gotTask->labels);
        $gotLabel=$gotLabels[0];
        $gotProject=$this->Projects_model->get_one(array("id"=>$gotTask->project_id));
        $allCategories=$this->Labels_model->get_all_where(array("context"=>"task"))->getResultArray();
        $allContexts = $this->Tasks_model->get_enum_values('pf_tasks', 'context');
        return $this->template->rander('task_libraries/edit',["task_id"=>$parameter,"gotProject"=>$gotProject,"gotLabel"=>$gotLabel,"gotTask"=>$gotTask,"allProjects"=>$allProjects,"allTasks"=>$allTasks,"allContexts"=>$allContexts,'allCategories'=>$allCategories]);
    }

    function update($parameter){
        $project_id = $this->request->getPost('project_id');
        $id = $this->request->getPost('id');
        $id=$parameter;
        $add_type = $this->request->getPost('add_type');
        $now = get_current_utc_time();

        $is_clone = $this->request->getPost('is_clone');
        $main_task_id = "";
        if ($is_clone && $id) {
            $main_task_id = $id; //store main task id to get items later
            $id = ""; //on cloning task, save as new
        }

        $client_id = $this->request->getPost('client_id');
        $lead_id = $this->request->getPost('lead_id');
        $invoice_id = $this->request->getPost('invoice_id');
        $estimate_id = $this->request->getPost('estimate_id');
        $order_id = $this->request->getPost('order_id');
        $contract_id = $this->request->getPost('contract_id');
        $proposal_id = $this->request->getPost('proposal_id');
        $subscription_id = $this->request->getPost('subscription_id');
        $expense_id = $this->request->getPost('expense_id');
        $ticket_id = $this->request->getPost('ticket_id');
        $supplier = $this->request->getPost('supplier');

        // $context_data = $this->get_context_and_id();
        
        // $context = $context_data["context"] ? $context_data["context"] : "project";
        $context="project";

        if ($id) {
            $task_info = $this->Tasks_model->get_one($id);
            if (!$this->can_edit_tasks($task_info)) {
                app_redirect("forbidden");
            }
        } else {
            if (!$this->can_create_tasks($context)) {
                app_redirect("forbidden");
            }
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "supplier" => "numeric",
            "title" => "required|max_length[60]",
            "project_id" => "required",
            "labels" => "required",
            "dock_list_number" => "max_length[15]",
            "reference_drawing" => "max_length[30]",
            "location" => "max_length[300]",
            "specification" => "max_length[300]",
            "requisition_number" => "max_length[30]",
            "budget" => "max_length[30]",
            "maker" => "max_length[30]",
            "type" => "max_length[30]",
            "serial_number" => "max_length[30]",
            "pms_scs_number" => "max_length[30]"
        ));

        $points = $this->request->getPost('points') ?? 1;
        $milestone_id = $this->request->getPost('milestone_id') ?? 0;
        $start_date = $this->request->getPost('start_date');
        $assigned_to = $this->request->getPost('assigned_to');
        $collaborators = $this->request->getPost('collaborators');
        $recurring = $this->request->getPost('recurring') ? 1 : 0;
        $repeat_every = $this->request->getPost('repeat_every');
        $repeat_type = $this->request->getPost('repeat_type');
        $no_of_cycles = $this->request->getPost('no_of_cycles');
        $status_id = $this->request->getPost('status_id');
        $priority_id = $this->request->getPost('priority_id') ?? 0;

        $data = array(
            "title" => $this->request->getPost('title'),
            "description" => $this->request->getPost('description'),
            "project_id" => $project_id ? $project_id : 0,
            "milestone_id" => $milestone_id ? $milestone_id : 0,
            "points" => $points,
            "status_id" => $status_id,
            "priority_id" => $priority_id,
            "supplier" => $supplier,
            "labels" => $this->request->getPost('labels'),
            "start_date" => date('Y-m-d', strtotime($start_date)),
            "deadline" => date('Y-m-d', strtotime($this->request->getPost('deadline'))),
            "recurring" => $recurring,
            "repeat_every" => $repeat_every ? $repeat_every : 0,
            "repeat_type" => $repeat_type ? $repeat_type : NULL,
            "no_of_cycles" => $no_of_cycles ? $no_of_cycles : 0,
            "dock_list_number" => $this->request->getPost("dock_list_number"),
            "reference_drawing" => $this->request->getPost("reference_drawing"),
            "location" => $this->request->getPost("location"),
            "specification" => $this->request->getPost("specification"),
            "requisition_number" => $this->request->getPost("requisition_number"),
            "budget" => $this->request->getPost("budget"),
            "gas_free_certificate" => $this->request->getPost("gas_free_certificate"),
            "light" => $this->request->getPost("light"),
            "ventilation" => $this->request->getPost("ventilation"),
            "crane_assistance" => $this->request->getPost("crane_assistance"),
            "cleaning_before" => $this->request->getPost("cleaning_before"),
            "cleaning_after" => $this->request->getPost("cleaning_after"),
            "work_permit" => $this->request->getPost("work_permit"),
            "painting_after_completion" => $this->request->getPost("painting_after_completion"),
            "parts_on_board" => $this->request->getPost("parts_on_board"),
            "transport_to_yard_workshop" => $this->request->getPost("transport_to_yard_workshop"),
            "transport_outside_yard" => $this->request->getPost("transport_outside_yard"),
            "material_yards_supply" => $this->request->getPost("material_yards_supply"),
            "material_owners_supply" => $this->request->getPost("material_owners_supply"),
            "risk_assessment" => $this->request->getPost("risk_assessment"),
            "maker" => $this->request->getPost("maker"),
            "type" => $this->request->getPost("type"),
            "serial_number" => $this->request->getPost("serial_number"),
            "pms_scs_number" => $this->request->getPost("pms_scs_number"),
            "cost_type" => $this->request->getPost("cost_type"),
            "est_quantity" => $this->request->getPost("est_quantity"),
            "measurement_unit" => $this->request->getPost("measurement_unit"),
            "unit_price" => $this->request->getPost("unit_price"),
            "unit_price_currency" => $this->request->getPost("unit_price_currency"),
            "quote" => $this->request->getPost("quote"),
            "discount" => $this->request->getPost("discount"),
            "remarks" => $this->request->getPost("remarks"),
        );

        if (!$id) {
            $data["created_date"] = $now;
            $data["context"] = $context;
            // $data["sort"] = $this->Tasks_model->get_next_sort_value($project_id, $status_id);
        }

        if ($ticket_id) {
            $data["ticket_id"] = $ticket_id;
        }

        //clint can't save the assign to and collaborators
        if ($this->login_user->user_type == "client") {
            if (get_setting("client_can_assign_tasks")) {
                $data["assigned_to"] = $assigned_to;
            } else if (!$id) { //it's new data to save
                $data["assigned_to"] = 0;
            }

            $data["collaborators"] = "";
        } else {
            $data["assigned_to"] = $assigned_to;
            $data["collaborators"] = $collaborators;
        }

        $data = clean_data($data);

        //set null value after cleaning the data
        if (!$data["start_date"]) {
            $data["start_date"] = NULL;
        }

        if (!$data["deadline"]) {
            $data["deadline"] = NULL;
        }

        //deadline must be greater or equal to start date
        if ($data["start_date"] && $data["deadline"] && $data["deadline"] < $data["start_date"]) {
            echo json_encode(array("success" => false, 'message' => app_lang('deadline_must_be_equal_or_greater_than_start_date')));
            return false;
        }

        $copy_checklist = $this->request->getPost("copy_checklist");

        $next_recurring_date = "";

        if ($recurring && get_setting("enable_recurring_option_for_tasks")) {
            //set next recurring date for recurring tasks

            if ($id) {
                //update
                if ($this->request->getPost('next_recurring_date')) { //submitted any recurring date? set it.
                    $next_recurring_date = $this->request->getPost('next_recurring_date');
                } else {
                    //re-calculate the next recurring date, if any recurring fields has changed.
                    if ($task_info->recurring != $data['recurring'] || $task_info->repeat_every != $data['repeat_every'] || $task_info->repeat_type != $data['repeat_type'] || $task_info->start_date != $data['start_date']) {
                        $recurring_start_date = $start_date ? $start_date : $task_info->created_date;
                        $next_recurring_date = add_period_to_date($recurring_start_date, $repeat_every, $repeat_type);
                    }
                }
            } else {
                //insert new
                $recurring_start_date = $start_date ? $start_date : get_array_value($data, "created_date");
                $next_recurring_date = add_period_to_date($recurring_start_date, $repeat_every, $repeat_type);
            }


            //recurring date must have to set a future date
            if ($next_recurring_date && get_today_date() >= $next_recurring_date) {
                echo json_encode(array("success" => false, 'message' => app_lang('past_recurring_date_error_message_title_for_tasks'), 'next_recurring_date_error' => app_lang('past_recurring_date_error_message'), "next_recurring_date_value" => $next_recurring_date));
                return false;
            }
        }

        //save status changing time for edit mode
        if ($id) {
            if ($task_info->status_id !== $status_id) {
                $data["status_changed_at"] = $now;
            }

            $this->check_sub_tasks_statuses($status_id, $id);
        }

        $save_id = $this->Tasks_model->ci_save($data, $id);
        if ($save_id) {

            if ($is_clone && $main_task_id) {
                //clone task checklist
                if ($copy_checklist) {
                    $checklist_items = $this->Checklist_items_model->get_all_where(array("task_id" => $main_task_id, "deleted" => 0))->getResult();
                    foreach ($checklist_items as $checklist_item) {
                        //prepare new checklist data
                        $checklist_item_data = (array) $checklist_item;
                        unset($checklist_item_data["id"]);
                        $checklist_item_data['task_id'] = $save_id;

                        $checklist_item = $this->Checklist_items_model->ci_save($checklist_item_data);
                    }
                }

                //clone sub tasks
                if ($this->request->getPost("copy_sub_tasks")) {
                    $sub_tasks = $this->Tasks_model->get_all_where(array("parent_task_id" => $main_task_id, "deleted" => 0))->getResult();
                    foreach ($sub_tasks as $sub_task) {
                        //prepare new sub task data
                        $sub_task_data = (array) $sub_task;

                        unset($sub_task_data["id"]);
                        unset($sub_task_data["blocked_by"]);
                        unset($sub_task_data["blocking"]);

                        $sub_task_data['status_id'] = 1;
                        $sub_task_data['parent_task_id'] = $save_id;
                        $sub_task_data['created_date'] = $now;

                        $sub_task_data["sort"] = $this->Tasks_model->get_next_sort_value($sub_task_data["project_id"], $sub_task_data['status_id']);

                        $sub_task_save_id = $this->Tasks_model->ci_save($sub_task_data);

                        //clone sub task checklist
                        if ($copy_checklist) {
                            $checklist_items = $this->Checklist_items_model->get_all_where(array("task_id" => $sub_task->id, "deleted" => 0))->getResult();
                            foreach ($checklist_items as $checklist_item) {
                                //prepare new checklist data
                                $checklist_item_data = (array) $checklist_item;
                                unset($checklist_item_data["id"]);
                                $checklist_item_data['task_id'] = $sub_task_save_id;

                                $this->Checklist_items_model->ci_save($checklist_item_data);
                            }
                        }
                    }
                }
            }

            //save next recurring date 
            if ($next_recurring_date) {
                $recurring_task_data = array(
                    "next_recurring_date" => $next_recurring_date
                );
                $this->Tasks_model->save_reminder_date($recurring_task_data, $save_id);
            }

            // if created from ticket then save the task id
            if ($ticket_id) {
                $data = array("task_id" => $save_id);
                $this->Tickets_model->ci_save($data, $ticket_id);
            }

            $activity_log_id = get_array_value($data, "activity_log_id");

            $new_activity_log_id = save_custom_fields("tasks", $save_id, $this->login_user->is_admin, $this->login_user->user_type, $activity_log_id);

            if ($id) {
                //updated
                if ($task_info->context === "project") {
                    log_notification("project_task_updated", array("project_id" => $project_id, "task_id" => $save_id, "activity_log_id" => $new_activity_log_id ? $new_activity_log_id : $activity_log_id));
                } else {
                    $context_id_key = $task_info->context . "_id";
                    $context_id_value = ${$task_info->context . "_id"};

                    log_notification("general_task_updated", array("$context_id_key" => $context_id_value, "task_id" => $save_id, "activity_log_id" => $new_activity_log_id ? $new_activity_log_id : $activity_log_id));
                }
            } else {
                //created
                if ($context === "project") {
                    log_notification("project_task_created", array("project_id" => $project_id, "task_id" => $save_id));
                } else {
                    $context_id_key = $context . "_id";
                    $context_id_value = ${$context . "_id"};

                    log_notification("general_task_created", array("$context_id_key" => $context_id_value, "task_id" => $save_id));
                }

                //save uploaded files as comment
                $target_path = get_setting("timeline_file_path");
                $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "project_comment");

                if ($files_data && $files_data != "a:0:{}") {
                    $comment_data = array(
                        "created_by" => $this->login_user->id,
                        "created_at" => $now,
                        "project_id" => $project_id,
                        "task_id" => $save_id
                    );

                    $comment_data = clean_data($comment_data);

                    $comment_data["files"] = $files_data; //don't clean serilized data

                    $this->Project_comments_model->save_comment($comment_data);
                }
            }

            return redirect()->to('/task_libraries');
            // echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved'), "add_type" => $add_type));
        } else {
            return redirect()->to('/task_libraries');
            // echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
        
        
    }
    //parent task can't be marked as done if there is any sub task which is not done yet
    private function check_sub_tasks_statuses($status_id = 0, $parent_task_id = 0) {
        if ($status_id !== "3") {
            //parent task isn't marking as done
            return true;
        }

        $sub_tasks = $this->Tasks_model->get_details(array("parent_task_id" => $parent_task_id, "deleted" => 0))->getResult();

        foreach ($sub_tasks as $sub_task) {
            if ($sub_task->status_id !== "3") {
                //this sub task isn't done yet, show error and exit
                echo json_encode(array("success" => false, 'message' => app_lang("parent_task_completing_error_message")));
                exit();
            }
        }
    }

}