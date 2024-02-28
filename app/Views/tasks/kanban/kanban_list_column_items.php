<?php

$show_in_kanban = get_setting("show_in_kanban");
$show_in_kanban_items = explode(',', $show_in_kanban);
$status_colors=array();
foreach ($allStatus as $oneStatus) {
    # code...
    $status_colors[$oneStatus->title]=$oneStatus->color;
}

foreach ($tasks as $data) {
    $unread_comments_class = "";
    $icon = "";
    if (isset($data->unread) && $data->unread && $data->unread != "0") {
        $unread_comments_class = "unread-comments-of-tasks";
        $icon = "<i data-feather='message-circle' class='icon-16 ml5 unread-comments-of-tasks-icon'></i>";
    }

    $title = "";
    $main_task_id = "#" . $data->id;
    $sub_task_search_column = "#" . $data->id;

    if ($data->parent_task_id) {
        $sub_task_search_column = "#" . $data->parent_task_id;
        //this is a sub task
        $title = "<span class='sub-task-icon mr5 ml10' title='" . app_lang("sub_task") . "'><i data-feather='git-merge' class='icon-14'></i></span>";
    }

    $toggle_sub_task_icon = "";

    if ($data->has_sub_tasks) {
        $toggle_sub_task_icon = "<span class='filter-sub-task-button clickable ml5' title='" . app_lang("show_sub_tasks") . "' main-task-id= '$main_task_id'><i data-feather='filter' class='icon-16'></i></span>";
    }

    $title .=("<div style='flex-grow:1;max-width:10vw;word-wrap:break-word;' >". modal_anchor(get_uri("tasks/view"), $data->title . $icon, array("title" => app_lang('task_info') . " #$data->id", "data-post-id" => $data->id, "data-search" => $sub_task_search_column, "class" => $unread_comments_class, "data-modal-lg" => "1"))."</div>");

    // $task_point = "";
    // if ($data->points > 1) {
    //     $task_point .= "<span class='badge badge-light clickable mt0' title='" . app_lang('points') . "'>" . $data->points . "</span> ";
    // }
    // $title .= "<span class='float-end ml5'>" . $task_point . "</span>";
$priorityMark="";
    if ($data->priority_id) {
        // $title .= "<span class='float-end' title='" . app_lang('priority') . ": " . $data->priority_title . "'>
        //                 <span class='sub-task-icon priority-badge' style='background: $data->priority_color'><i data-feather='$data->priority_icon' class='icon-14'></i></span> $toggle_sub_task_icon
        //             </span>";
        $priorityMark="<span class='float-end' title='" . app_lang('priority') . ": " . $data->priority_title . "'>
            <span class='sub-task-icon priority-badge' style='background: $data->priority_color'><i data-feather='$data->priority_icon' class='icon-14'></i></span> $toggle_sub_task_icon
        </span>";
    }

    $task_labels = make_labels_view_data($data->labels_list, true);

    $title .= "<span class='float-end mr5'>" . $task_labels . "</span>";

    $context_title = "";
    if ($data->project_id) {
        $context_title = anchor(get_uri("projects/view/" . $data->project_id), $data->project_title ? $data->project_title : "");
    } else if ($data->client_id) {
        $context_title = anchor(get_uri("clients/view/" . $data->client_id), $data->charter_name ? $data->charter_name : "");
    } else if ($data->lead_id) {
        $context_title = anchor(get_uri("leads/view/" . $data->lead_id), $data->company_name ? $data->company_name : "");
    } else if ($data->invoice_id) {
        $context_title = anchor(get_uri("invoices/view/" . $data->invoice_id), get_invoice_id($data->invoice_id));
    } else if ($data->estimate_id) {
        $context_title = anchor(get_uri("estimates/view/" . $data->estimate_id), get_estimate_id($data->estimate_id));
    } else if ($data->order_id) {
        $context_title = anchor(get_uri("orders/view/" . $data->order_id), get_order_id($data->order_id));
    } else if ($data->contract_id) {
        $context_title = anchor(get_uri("contracts/view/" . $data->contract_id), $data->contract_title ? $data->contract_title : "");
    } else if ($data->proposal_id) {
        $context_title = anchor(get_uri("proposals/view/" . $data->proposal_id), get_proposal_id($data->proposal_id));
    } else if ($data->subscription_id) {
        $context_title = anchor(get_uri("subscriptions/view/" . $data->subscription_id), $data->subscription_title ? $data->subscription_title : "");
    } else if ($data->expense_id) {
        $context_title = modal_anchor(get_uri("expenses/expense_details"), ($data->expense_title ? $data->expense_title : format_to_date($data->expense_date, false)), array("title" => app_lang("expense_details"), "data-post-id" => $data->expense_id, "data-modal-lg" => "1"));
    } else if ($data->ticket_id) {
        $context_title = anchor(get_uri("tickets/view/" . $data->ticket_id), $data->ticket_title ? $data->ticket_title : "");
    }

    $milestone_title = "-";
    if ($data->milestone_title) {
        $milestone_title = $data->milestone_title;
    }

    $assigned_to = "-";

    if ($data->assigned_to) {
        $image_url = get_avatar($data->assigned_to_avatar);
        $assigned_to_user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $data->assigned_to_user";
        $assigned_to = get_team_member_profile_link($data->assigned_to, $assigned_to_user);

        // if ($data->user_type != "staff") {
        //     $assigned_to = get_client_contact_profile_link($data->assigned_to, $assigned_to_user);
        // }
    }


    // $collaborators = $this->_get_collaborators($data->collaborator_list);

    // if (!$collaborators) {
    //     $collaborators = "-";
    // }


    $checkbox_class = "checkbox-blank";
    if ($data->status_key_name === "done") {
        $checkbox_class = "checkbox-checked";
    }

    // if (get_array_value($tasks_status_edit_permissions, $data->id)) {
        //show changeable status checkbox and link to team members
        $check_status = js_anchor("<span class='$checkbox_class mr15 float-start'></span>", array('title' => "", "class" => "js-task", "data-id" => $data->id, "data-value" => $data->status_key_name === "done" ? "1" : "3", "data-act" => "update-task-status-checkbox"));
        $status = js_anchor($data->status_key_name ? app_lang($data->status_key_name) : $data->status_title, array('title' => "", "class" => "", "data-id" => $data->id, "data-value" => $data->status_id, "data-act" => "update-task-status"));
    // } else {
    //     //don't show clickable checkboxes/status to client
    //     if ($checkbox_class == "checkbox-blank") {
    //         $checkbox_class = "checkbox-un-checked";
    //     }
    //     $check_status = "<span class='$checkbox_class mr15 float-start'></span> " . $data->id;
    //     $status = $data->status_key_name ? app_lang($data->status_key_name) : $data->status_title;
    // }



    $deadline_text = "-";
    if ($data->deadline && is_date_exists($data->deadline)) {

        // if ($show_time_with_task) {
            if (date("H:i:s", strtotime($data->deadline)) == "00:00:00") {
                $deadline_text = format_to_date($data->deadline, false);
            } else {
                $deadline_text = format_to_relative_time($data->deadline, false, false, true);
            }
        // } else {
        //     $deadline_text = format_to_date($data->deadline, false);
        // }

        if (get_my_local_time("Y-m-d") > $data->deadline && $data->status_id != "3") {
            $deadline_text = "<span class='text-danger'>" . $deadline_text . "</span> ";
        } else if (format_to_date(get_my_local_time(), false) == format_to_date($data->deadline, false) && $data->status_id != "3") {
            $deadline_text = "<span class='text-warning'>" . $deadline_text . "</span> ";
        }
    }


    $start_date = "-";
    if (is_date_exists($data->start_date)) {
        // if ($show_time_with_task) {
            if (date("H:i:s", strtotime($data->start_date)) == "00:00:00") {
                $start_date = format_to_date($data->start_date, false);
            } else {
                $start_date = format_to_relative_time($data->start_date, false, false, true);
            }
        // } else {
        //     $start_date = format_to_date($data->start_date, false);
        // }
    }

    $options = "";

    if (get_array_value($tasks_edit_permissions, $data->id)) {
        $options .= modal_anchor(get_uri("tasks/modal_form_edit/".$data->id), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_task'), "data-post-id" => $data->id));
    }
    // if (can_delete_tasks($data)) {
        $options .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_task'), "onclick"=>'delete_task('.$data->id.')',"class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("tasks/delete"), "data-action" => "delete-confirmation"));
    // }
    // echo '<tr style="border-style:none none none none solid;" ><td class="" style="border-left:5px solid '.$status_colors[$data->status_title].';" >' . 
    // $check_status . '</td><td>' . 
    // $data->dock_list_number . 
    // "</td><td  ><div class='d-flex align-items-center' >" . 
    // $title . 
    // "</div></td><td>" . 
    // $data->reference_drawing . 
    // "</td><td>" .  
    // '<span class="">' . $start_date . '</span>' . 
    // "</td><td>" . 
    // '<span class="text-danger">' . $deadline_text . '</span>' . 
    // "</td><td>" . 
    // $assigned_to . 
    // "</td><td>" . 
    // $status . 
    // "</td><td class='text-center option '>" . 
    // $options . 
    // "</td></tr>";


///////////////////////
echo '<tr style="border-style:none none none none solid;" ><td class="" style="border-left:5px solid '.$status_colors[$data->status_title].';" >' . 
$check_status . '</td><td>' . 
$data->dock_list_number . 
"</td><td  ><div class='d-flex align-items-center' >" . 
$title . 
"</div></td><td>" .  
'<span class="">' . $start_date . '</span>' . 
"</td><td>" . 
'<span class="text-danger">' . $deadline_text . '</span>' . 
"</td><td>".
$milestone_title.
"</td><td>
Yard
</td><td>" . 
$assigned_to . 
"</td><td>".
$data->collaborators.
"</td><td>" . 
$status . $priorityMark.
"</td><td class='text-center option '>" . 
$options . 
"</td></tr>";

////////////////////////


    // echo modal_anchor(get_uri("tasks/view"), "<div class='d-flex'>
    //             <span class='avatar'><img style='width: 30px; height: 30px;' src='" . get_avatar($task->assigned_to_avatar) . "'></span>
    //             <div class='w400'>" . $sub_task_icon . $task_id . $task->title . $toggle_sub_task_icon . $batch_operation_checkbox . "</div>
    //             <div class='clearfix w200'>" . $start_date . $end_date . "</div>
    //         </div>
    //         <div class='d-flex'>" . $project_name . $client_name . $kanban_custom_fields_data . $task_labels . $task_checklist_status . $sub_task_status . "
    //             <div class='clearfix'></div>" . $parent_task . "
    //         </div>", array("class" => "kanban-list-item $disable_dragging $unread_comments_class", "data-status_id" => $task->status_id, "data-id" => $task->id, "data-project_id" => $task->project_id, "data-sort" => $task->new_sort, "data-post-id" => $task->id, "title" => app_lang('task_info') . " #$task->id", "data-modal-lg" => "1"));
}