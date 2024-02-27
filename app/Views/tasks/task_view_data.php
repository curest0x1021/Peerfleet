<?php
$progress = 0;
if ($total_sub_tasks) {
    $progress = round($completed_sub_tasks / $total_sub_tasks * 100);
}
$yes_icon = '<i data-feather="check-square" class="icon-16"></i>';
$no_icon = '<i data-feather="square" class="icon-16"></i>';
?>
<!---->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->
<style>
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */

.item-group .col-md-2{
    text-align:center;
    border:1px solid lightgray;
    border-radius:10px;
    margin:10px;
}
.item-group .col-md-12{
    display:flex;
    border:1px solid lightgray;
    border-radius:10px;
    margin:10px;
    align-items:center;
}
.item-image{
    
}
.item-group .col-md-2 .item-image{
   height:20vh;
   max-width:80%;
}
.item-group .col-md-2 .btn-download-item{
   float:right;
}
.item-group .col-md-12 .item-image{
    width:5vw;
    max-height:5vw;
    min-height:5vw;
    
}
.item-group .col-md-12 .item-title{
    margin-left:5vw;
    flex-grow:1;
}
.item-group .col-md-2 .item-title{
    width:95%;
    white-space: nowrap; /* Prevent text from wrapping */
    overflow: hidden; /* Hide any overflowed text */
    text-overflow: ellipsis; /* Display an ellipsis (...) to indicate text overflow */
}
</style>
<!---->
<div>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#general">General</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#costs">Quotes & Costs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#files">Files</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#activity">Comments & Activity</a>
        </li>
    </ul>
</div>
<div class="tab-content" >
    <div class="tab-pane active" id="general" >
        <div class="row" >
            <div class="col-lg-4 order-lg-last">
                <div class="clearfix">
                    <!-- <div class="container-fluid"> -->
                    <div>
                        <div class="row">
                            <div class="col-md-12 mb15 task-title-right d-none">
                                <strong ><?php echo $model_info->title; ?></strong>
                            </div>
                            
                            <div class="d-flex m0">
                                <div class="flex-shrink-0">
                                    <span class="avatar avatar-sm">
                                        <img id="task-assigned-to-avatar" src="<?php echo get_avatar($model_info->assigned_to_avatar); ?>" alt="..." />
                                    </span>
                                </div>
                                <div class="w-100 ps-2 pt5">
                                    <div>
                                        <?php echo get_update_task_info_anchor_data($model_info, "user", $can_edit_tasks, "", $show_assign_to_dropdown); ?>
                                    </div>
                                    <p>
                                        <span class='badge badge-light mr5' title='Point'><?php echo get_update_task_info_anchor_data($model_info, "points", $can_edit_tasks); ?></span>

                                        <?php
                                        echo "<span class='badge' style='background:$model_info->status_color; '>" . get_update_task_info_anchor_data($model_info, "status", $can_edit_task_status) . "</span>";
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <?php if ($total_sub_tasks) { ?>
                                <div class="col-md-12 mb15 mt15">
                                    <span class=""><?php echo $completed_sub_tasks . "/" . $total_sub_tasks; ?> <?php echo app_lang("sub_tasks_completed"); ?></span>
                                    <div class="progress mt5" style="height: 6px;" title="<?php echo $progress; ?>%">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->project_id) { ?>
                                <div class="col-md-12 mb15 mt15">
                                    <strong><?php echo app_lang('milestone') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "milestone", $can_edit_tasks); ?>
                                </div>
                            <?php } ?>

                            <div class="col-md-12 mb15 <?php echo $model_info->project_id ? "" : "mt15"; ?>">
                                <strong><?php echo app_lang('start_date') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "start_date", $can_edit_tasks); ?>
                                <?php
                                if ($show_time_with_task) {
                                    echo get_update_task_info_anchor_data($model_info, "start_time", $can_edit_tasks);
                                }
                                ?>
                            </div>

                            <div class="col-md-12 mb15">
                                <strong><?php echo app_lang('deadline') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "deadline", $can_edit_tasks); ?>
                                <?php
                                if ($show_time_with_task) {
                                    echo get_update_task_info_anchor_data($model_info, "end_time", $can_edit_tasks);
                                }
                                ?>
                                <?php if ($model_info->deadline_milestone_title) { ?>
                                    <span class="help task-deadline-milestone-tooltip" data-bs-toggle="tooltip" title="<?php echo app_lang('milestone') . ": " . $model_info->deadline_milestone_title; ?>"><i data-feather="help-circle" class="icon-16"></i></span>
                                <?php } ?>
                            </div>

                            <!-- <div class="col-md-12 mb15">
                                <strong><?php 
                                //echo app_lang('budget') . ": "; 
                                ?></strong> <?php 
                                //echo $model_info->budget; 
                                ?>
                            </div> -->

                            <div class="col-md-12 mb15">
                                <strong><?php echo app_lang('priority') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "priority", $can_edit_tasks); ?>
                            </div>

                            <div class="col-md-12 mb15">
                                <strong><?php echo app_lang('category') . ": " ?></strong>
                                <?php 
                                // echo get_update_task_info_anchor_data($model_info, "labels", $can_edit_tasks, $labels);
                                echo $model_info->category; 
                                ?>
                            </div>

                            <div class="col-md-12 mb15">
                                <strong><?php echo app_lang('collaborators') . ": "; ?> </strong>
                                <div class="mt5">
                                    <?php 
                                    // echo get_update_task_info_anchor_data($model_info, "collaborators", $can_edit_tasks, $collaborators); 
                                    echo $model_info->collaborators;
                                    ?>
                                </div>
                            </div>

                            <?php if ($model_info->ticket_id && $model_info->project_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang("ticket") . ": "; ?> </strong> <?php echo anchor(get_uri("tickets/view/" . $model_info->ticket_id), get_ticket_id($model_info->ticket_id) . " - " . $model_info->ticket_title); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->recurring_task_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('created_from') . ": "; ?> </strong>
                                    <?php
                                    echo modal_anchor(get_uri("tasks/view"), app_lang("task") . " " . $model_info->recurring_task_id, array("title" => app_lang('task_info') . " #$model_info->recurring_task_id", "data-post-id" => $model_info->recurring_task_id, "data-modal-lg" => "1"));
                                    ?>
                                </div>
                            <?php } ?>

                            <!--recurring info-->
                            <?php if ($model_info->recurring) { ?>

                                <?php
                                $recurring_stopped = false;
                                $recurring_cycle_class = "";
                                if ($model_info->no_of_cycles_completed > 0 && $model_info->no_of_cycles_completed == $model_info->no_of_cycles) {
                                    $recurring_stopped = true;
                                    $recurring_cycle_class = "text-danger";
                                }
                                ?>

                                <?php
                                $cycles = $model_info->no_of_cycles_completed . "/" . $model_info->no_of_cycles;
                                if (!$model_info->no_of_cycles) { //if not no of cycles, so it's infinity
                                    $cycles = $model_info->no_of_cycles_completed . "/&#8734;";
                                }
                                ?>

                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang("repeat_every") . ": "; ?> </strong> <?php echo $model_info->repeat_every . " " . app_lang("interval_" . $model_info->repeat_type); ?>
                                </div>

                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang("cycles") . ": "; ?> </strong> <span class="<?php echo $recurring_cycle_class; ?>"><?php echo $cycles; ?></span>
                                </div>

                                <?php if (!$recurring_stopped && (int) $model_info->next_recurring_date) { ?>
                                    <div class="col-md-12 mb15">
                                        <strong><?php echo app_lang("next_recurring_date") . ": "; ?> </strong> <?php echo format_to_date($model_info->next_recurring_date, false); ?>
                                    </div>
                                <?php } ?>

                            <?php } ?>

                            <?php if ($model_info->context == "project") { ?>
                                <div class="col-md-12 mb15">
                                    <?php
                                    if ($show_timer) {
                                        echo view("tasks/task_timer");
                                    }
                                    ?>
                                </div>

                                <?php if (get_setting("module_project_timesheet") == "1" && $show_timesheet_info) { ?>
                                    <div class="col-md-12 mb15">
                                        <strong><?php echo app_lang("total_time_logged") . ": "; ?></strong>
                                        <?php
                                        echo ajax_anchor(get_uri("tasks/task_timesheet/" . $model_info->id . "/" . $model_info->project_id), $total_task_hours, array("data-real-target" => "#task-timesheet", "class" => "strong"));
                                        ?>
                                    </div>
                                    <div class="col-md-12 mb15">
                                        <div id="task-timesheet"></div>
                                    </div>

                                <?php } ?>
                            <?php } ?>

                            <?php
                            $pinned_status = "hide";
                            if (count($pinned_comments)) {
                                $pinned_status = "";
                            }
                            ?>
                            <div class="col-md-12 mb15 <?php echo $pinned_status; ?>" id="pinned-comment">
                                <div class="mb5">
                                    <strong><?php echo app_lang("pinned_comments") . ": "; ?> </strong>
                                </div>
                                <?php echo view("projects/comments/pinned_comments"); ?>
                            </div>

                            <?php if (can_access_reminders_module()) { ?>
                                <div class="col-md-12 mb15" id="task-reminders">
                                    <div class="mb15"><strong><?php echo app_lang("reminders") . " (" . app_lang('private') . ")" . ": "; ?> </strong></div>
                                    <?php echo view("reminders/reminders_view_data", array("task_id" => $model_info->id, "hide_form" => true, "reminder_view_type" => "task")); ?>
                                </div>
                            <?php } ?>
                            

                            <?php app_hooks()->do_action('app_hook_task_view_right_panel_extension'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb15">
                <div class="clearfix">
                    <!-- <div class="container-fluid"> -->
                    <div>
                        <div class="row">
                        <div style="word-wrap:break-word;"  class="col-md-12 mb15 task-title-left">
                                <strong><?php echo $model_info->title; ?></strong>
                            </div>

                            <?php if ($model_info->parent_task_id) { ?>
                                <div class="col-md-12 mb15">
                                <strong><?php echo app_lang("main_task") . ": "; ?></strong><?php echo modal_anchor(get_uri("tasks/view"), $parent_task_title, array("title" => app_lang('task_info') . " #$model_info->parent_task_id", "data-post-id" => $model_info->parent_task_id, "data-modal-lg" => "1")); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->description) { ?>
                                <div style="word-wrap:break-word;" class="col-md-12 mb15 text-wrap">
                                    <?php echo $model_info->description ? nl2br(link_it(process_images_from_content($model_info->description))) : ""; ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->project_id) { ?>
                                <div class="col-md-12 mb15">
                                <strong><?php echo app_lang('project') . ": "; ?> </strong> <?php echo anchor(get_uri("projects/view/" . $model_info->project_id), $model_info->project_title); ?>
                            </div>
                            <?php } ?>
                            <?php if ($model_info->parent_task_id == 0) { ?>
                                <?php if ($model_info->dock_list_number) { ?>
                                    <div class="col-md-12 mb15 mb15">
                                        <strong><?php echo app_lang('dock_list_number') . ": "; ?></strong> <?php echo $model_info->dock_list_number; ?>
                                    </div>
                                <?php } ?>

                                <?php if ($model_info->reference_drawing) { ?>
                                    <div class="col-md-12 mb15">
                                        <strong><?php echo app_lang('reference_drawing') . ": "; ?></strong> <?php echo $model_info->reference_drawing; ?>
                                    </div>
                                <?php } ?>

                                <?php if ($model_info->location) { ?>
                                    <div class="col-md-12 mb15">
                                        <strong><?php echo app_lang('location') . ": "; ?> </strong> <?php echo $model_info->location; ?>
                                    </div>
                                <?php } ?>

                                <?php if ($model_info->specification) { ?>
                                    <div class="col-md-12 mb15">
                                        <strong><?php echo app_lang('specification') . ": "; ?> </strong> <?php echo $model_info->specification; ?>
                                    </div>
                                <?php } ?>

                                <?php if ($model_info->requisition_number) { ?>
                                    <div class="col-md-12 mb15">
                                        <strong><?php echo app_lang('requisition_number') . ": "; ?> </strong> <?php echo $model_info->requisition_number; ?>
                                    </div>
                                <?php } ?>

                                <strong><?php echo app_lang('to_be_included') . ":" ?></strong>
                                <div class="col-md-12 mb15">
                                    <div class="row">
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('gas_free_certificate') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->gas_free_certificate ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('painting_after_completion') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->painting_after_completion ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('light') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->light ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('parts_on_board') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->parts_on_board ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('ventilation') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->ventilation ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('transport_to_yard_workshop') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->transport_to_yard_workshop ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('crane_assistance') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->crane_assistance ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('transport_outside_yard') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->transport_outside_yard ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('cleaning_before') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->cleaning_before ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('material_yards_supply') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->material_yards_supply ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('cleaning_after') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->cleaning_after ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('material_owners_supply') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->material_owners_supply ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('work_permit') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->work_permit ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 border-bottom">
                                            <div class="row">
                                                <span class="col-9"><?php echo app_lang('risk_assessment') . ": "; ?></span>
                                                <span class="col-3"><?php echo $model_info->risk_assessment ? $yes_icon : $no_icon ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <strong><?php echo app_lang('maker_informations') . ":"; ?></strong>
                                <?php if ($model_info->maker) { ?>
                                    <div class="col-md-12 mb15">
                                        <?php echo app_lang('maker') . ": "; ?> <?php echo $model_info->maker; ?>
                                    </div>
                                <?php } ?>

                                <?php if ($model_info->type) { ?>
                                    <div class="col-md-12 mb15">
                                        <?php echo app_lang('type') . ": "; ?> <?php echo $model_info->type; ?>
                                    </div>
                                <?php } ?>

                                <?php if ($model_info->serial_number) { ?>
                                    <div class="col-md-12 mb15">
                                        <?php echo app_lang('serial_number') . ": "; ?> <?php echo $model_info->serial_number; ?>
                                    </div>
                                <?php } ?>

                                <?php if ($model_info->pms_scs_number) { ?>
                                    <div class="col-md-12 mb15">
                                        <?php echo app_lang('pms_scs_number') . ": "; ?> <?php echo $model_info->pms_scs_number; ?>
                                    </div>
                                <?php } ?>

                            <?php } ?>

                            <?php if ($model_info->client_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('client') . ": "; ?> </strong> <?php echo anchor(get_uri("clients/view/" . $model_info->client_id), $model_info->company_name); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->lead_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('lead') . ": "; ?> </strong> <?php echo anchor(get_uri("leads/view/" . $model_info->lead_id), $model_info->company_name); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->invoice_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('invoice') . ": "; ?> </strong> <?php echo anchor(get_uri("invoices/view/" . $model_info->invoice_id), get_invoice_id($model_info->invoice_id)); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->estimate_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('estimate') . ": "; ?> </strong> <?php echo anchor(get_uri("estimates/view/" . $model_info->estimate_id), get_estimate_id($model_info->estimate_id)); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->order_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('order') . ": "; ?> </strong> <?php echo anchor(get_uri("orders/view/" . $model_info->order_id), get_order_id($model_info->order_id)); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->contract_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('contract') . ": "; ?> </strong> <?php echo anchor(get_uri("contracts/view/" . $model_info->contract_id), $model_info->contract_title); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->proposal_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('proposal') . ": "; ?> </strong> <?php echo anchor(get_uri("proposals/view/" . $model_info->proposal_id), get_proposal_id($model_info->proposal_id)); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->subscription_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('subscription') . ": "; ?> </strong> <?php echo anchor(get_uri("subscriptions/view/" . $model_info->subscription_id), $model_info->subscription_title); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->expense_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang('expense') . ": "; ?> </strong> <?php echo modal_anchor(get_uri("expenses/expense_details"), ($model_info->expense_title ? $model_info->expense_title : format_to_date($model_info->expense_date, false)), array("title" => app_lang("expense_details"), "data-post-id" => $model_info->expense_id, "data-modal-lg" => "1")); ?>
                                </div>
                            <?php } ?>

                            <?php if ($model_info->ticket_id && !$model_info->project_id) { ?>
                                <div class="col-md-12 mb15">
                                    <strong><?php echo app_lang("ticket") . ": "; ?> </strong> <?php echo anchor(get_uri("tickets/view/" . $model_info->ticket_id), get_ticket_id($model_info->ticket_id) . " - " . $model_info->ticket_title); ?>
                                </div>
                            <?php } ?>

                            <?php
                            if (count($custom_fields_list)) {
                                foreach ($custom_fields_list as $data) {
                                    if ($data->value) {
                            ?>
                                        <div class="col-md-12 mb15">
                                            <strong><?php echo $data->title . ": "; ?> </strong> <?php echo view("custom_fields/output_" . $data->field_type, array("value" => $data->value)); ?>
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>

                            <!--checklist-->
                            <?php echo form_open(get_uri("tasks/save_checklist_item"), array("id" => "checklist_form", "class" => "general-form", "role" => "form")); ?>
                            <div class="col-md-12 mb15 b-t" >
                                <div class="pb10 pt10">
                                    <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count">0</span><span>/</span><span class="chcklists_count"></span>
                                </div>
                                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
                                <input type="hidden" id="is_checklist_group" name="is_checklist_group" value="" />

                                <div class="checklist-items" id="checklist-items">

                                </div>
                                <?php if ($can_edit_tasks) { ?>
                                    <div class="mb5 mt5 btn-group checklist-options-panel hide" role="group">
                                        <button id="type-new-item-button" type="button" class="btn btn-default checklist_button active"> <?php echo app_lang('type_new_item'); ?></button>
                                        <button id="select-from-template-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_template'); ?></button>
                                        <button id="select-from-checklist-group-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_checklist_group'); ?></button>
                                    </div>
                                    <div class="form-group">
                                        <div class="mt5 p0">
                                            <?php
                                            echo form_input(array(
                                                "id" => "checklist-add-item",
                                                "name" => "checklist-add-item",
                                                "class" => "form-control",
                                                "placeholder" => app_lang('add_item'),
                                                "data-rule-required" => true,
                                                "data-msg-required" => app_lang("field_required"),
                                                "autocomplete" => "off"
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="mb10 p0 checklist-options-panel hide">
                                        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></button>
                                        <button id="checklist-options-panel-close" type="button" class="btn btn-default ms-2"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php echo form_close(); ?>

                            <!--Sub tasks-->
                            <?php 
                            echo form_open(get_uri("tasks/save_sub_task"), array("id" => "sub_task_form", "class" => "general-form", "role" => "form")); ?>
                            <div class="col-md-12 mb15 b-t" hidden>
                                <div class="pb10 pt10">
                                    <strong><?php echo app_lang("sub_tasks"); ?></strong>
                                </div>

                                <?php
                                foreach ($contexts as $context) {
                                    $context_id_key = $context . "_id";
                                    ?>
                                    <input type="hidden" name="<?php echo $context_id_key; ?>" value="<?php echo $model_info->$context_id_key; ?>" />
                                <?php } ?>

                                <input type="hidden" name="context" value="<?php echo $model_info->context; ?>" />
                                <input type="hidden" name="parent_task_id" value="<?php echo $task_id; ?>" />
                                <input type="hidden" name="milestone_id" value="<?php echo $model_info->milestone_id; ?>" />

                                <div class="sub-tasks" id="sub-tasks">

                                </div>
                                <?php if ($can_create_tasks) { ?>
                                    <div class="form-group">
                                        <div class="mt5 col-md-12 p0">
                                            <?php
                                            echo form_input(array(
                                                "id" => "sub-task-title",
                                                "name" => "sub-task-title",
                                                "class" => "form-control",
                                                "placeholder" => app_lang('create_a_sub_task'),
                                                "data-rule-required" => true,
                                                "data-msg-required" => app_lang("field_required")
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                    <div id="sub-task-options-panel" class="col-md-12 mb15 p0 hide">
                                        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('create'); ?></button>
                                        <button id="sub-task-options-panel-close" type="button" class="btn btn-default"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php echo form_close(); ?>

                            <!--Task dependency-->
                            <?php if ($can_edit_tasks) { ?>
                                <div class="col-md-12 mb15">
                                    <span class="dropdown">
                                        <button class="btn btn-default dropdown-toggle btn-border" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                                            <i data-feather="shuffle" class="icon-16"></i> <?php echo app_lang('add_dependency'); ?>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li role="presentation"><?php echo js_anchor(app_lang("this_task_blocked_by"), array("class" => "add-dependency-btn dropdown-item", "data-dependency_type" => "blocked_by")); ?></li>
                                            <li role="presentation"><?php echo js_anchor(app_lang("this_task_blocking"), array("class" => "add-dependency-btn dropdown-item", "data-dependency_type" => "blocking")); ?></li>
                                        </ul>
                                    </span>
                                </div>
                            <?php } ?>

                            <div class="col-md-12 mb15 <?php echo ($blocked_by || $blocking) ? "" : "hide"; ?>" id="dependency-area">
                                <div class="pb10 pt10">
                                    <strong><?php echo app_lang("dependency"); ?></strong>
                                </div>

                                <div class="p10 list-group-item mb15 dependency-section <?php echo $blocked_by ? "" : "hide"; ?>" id="blocked-by-area">
                                    <div class="pb10"><strong><?php echo app_lang("blocked_by"); ?></strong></div>
                                    <div id="blocked-by-tasks"><?php echo $blocked_by; ?></div>
                                </div>

                                <div class="p10 list-group-item mb15 dependency-section <?php echo $blocking ? "" : "hide"; ?>" id="blocking-area">
                                    <div class="pb10"><strong><?php echo app_lang("blocking"); ?></strong></div>
                                    <div id="blocking-tasks"><?php echo $blocking; ?></div>
                                </div>

                                <?php echo form_open(get_uri("tasks/save_dependency_tasks"), array("id" => "dependency_tasks_form", "class" => "general-form hide", "role" => "form")); ?>

                                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />

                                <div class="form-group mb0">
                                    <div class="mt5 col-md-12 p0">
                                        <?php
                                        echo form_input(array(
                                            "id" => "dependency_task",
                                            "name" => "dependency_task",
                                            "class" => "form-control validate-hidden",
                                            "placeholder" => app_lang('tasks'),
                                            "data-rule-required" => true,
                                            "data-msg-required" => app_lang("field_required"),
                                        ));
                                        ?>
                                    </div>
                                </div>

                                <div class="p0 mt10">
                                    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></button>
                                    <button type="button" class="dependency-tasks-close btn btn-default"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
                                </div>

                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="costs" class="row container tab-pane fade" >
        <!---->
        <div  >
            <!--Cost Items For Yard-->
            <div class="col-md-12" >
                <a class="btn btn-primary" style="margin:10px;" target="_blank" href="<?php echo get_uri("tasks/download_task_cost_items/".$task_id);?>" >
                    <i data-feather="download" ></i>
                    Download cost items as a excel file
                </a>
                <div class="card" style="border: solid 1px lightgray;min-height:20vh;">
                    <div class="card-header d-flex">
                        <b>Cost Item List</b>&nbsp;<i data-feather="info" class="icon-16" style="color:lightgray" ></i>
                    </div>
                    <div class="card-body" style="padding:10px" >
                        
                        <table id="table-quotes-from-yard" class="table " >
                            <thead>
                            <tr>
                                <td>Cost item name</td>
                                <td>UNIT PRICE AND QUANTITY</td>
                                <td>QUOTE</td>
                                <td ><button type="button" id="btn-add-new-quote" class="btn btn-default btn-sm" ><i data-feather="plus-circle" class="icon-16" ></i></button></td>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($model_info)&&$model_info->cost_items){
                                    $cost_items=json_decode($model_info->cost_items);
                                    foreach ($cost_items as $key=>$oneItem) {
                                        # code...
                                        echo "<tr><td>";
                                        echo $oneItem->name;
                                        echo "</td><td>";
                                        echo number_format($oneItem->quantity,1,".","")." ( ".$oneItem->measurement." ) X ".$oneItem->currency." ".number_format($oneItem->unit_price,2,".","")." ( ".$oneItem->quote_type." )";
                                        echo "</td><td>";
                                        echo $oneItem->currency." ".number_format(floatval($oneItem->quantity)*floatval($oneItem->unit_price), 2, '.', '');
                                        echo "</td><td>";
                                        echo '<button onClick="start_edit_cost_item('.$key.')" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="edit" class="icon-16" ></i></button><button onClick="delete_item('.$key.')" type="button" class="btn btn-sm" ><i color="gray" data-feather="x-circle" class="icon-16" ></i></button>';
                                        echo "</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <div id="insert-cost-item-panel" style="margin:5px;" hidden>
                            <div style="min-height:5vh" ></div>
                            <input hidden id="editing_cost_item" value="" />
                            <div class="row" >
                                <div class="form-group" >
                                    <label>Cost item name:</label>
                                    <input
                                        id="cost_item_name"
                                        class="form-control"
                                        type="text"
                                        style="border:1px solid lightgray;border-radius:5px"
                                    />
                                </div>
                            </div>
                            <div class="row" >
                                <div class="form-group" >
                                    <label>Description:</label>
                                    <textarea
                                        id="cost_item_description"
                                        class="form-control"
                                        type="text"
                                        style="border:1px solid lightgray;border-radius:5px"
                                    ></textarea>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6" >
                                    <div class="form-group" >
                                        <label>Quote type:</label>
                                        <select
                                            name="cost_item_quote_type"
                                            id="cost_item_quote_type"
                                            class="form-control"
                                            style="border:1px solid lightgray;border-radius:5px"
                                        >
                                            <option>Per unit</option>
                                            <option>Lump sum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" >
                                    <div class="form-group" >
                                        <label>Quantity:</label>
                                        <input
                                            id="cost_item_quantity"
                                            class="form-control"
                                            type="number"
                                            style="border:1px solid lightgray;border-radius:5px"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-3" >
                                    <div class="form-group" >
                                        <label>Measurement unit:</label>
                                        <input
                                            id="cost_item_measurement_unit"
                                            class="form-control"
                                            placeholder="pcs"
                                            value="pcs"
                                            style="border:1px solid lightgray;border-radius:5px"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6" >
                                    <div class="form-group" >
                                        <label>Unit price:</label>
                                        <div class="input-group mb-3" style="border:1px solid lightgray;border-radius:5px">
                                            <!-- <input readonly type="text" id="cost_item_currency_symbol" class="form-control" value="$"> -->
                                            
                                            <input id="cost_item_unit_price" type="text" class="form-control" value="0.00">
                                            <select id="cost_item_currency"  class="form-control">
                                                <option>AUD</option>
                                                <option>GBP</option>
                                                <option>EUR</option>
                                                <option>JPY</option>
                                                <option>CHF</option>
                                                <option>USD</option>
                                                <option>AFN</option>
                                                <option>ALL</option>
                                                <option>DZD</option>
                                                <option>AOA</option>
                                                <option>ARS</option>
                                                <option>AMD</option>
                                                <option>AWG</option>
                                                <option>AUD</option>
                                                <option>ATS (EURO)</option>
                                                <option>BEF (EURO)</option>
                                                <option>AZN</option>
                                                <option>BSD</option>
                                                <option>BHD</option>
                                                <option>BDT</option>
                                                <option>BBD</option>
                                                <option>BYR</option>
                                                <option>BZD</option>
                                                <option>BMD</option>
                                                <option>BTN</option>
                                                <option>BOB</option>
                                                <option>BAM</option>
                                                <option>BWP</option>
                                                <option>BRL</option>
                                                <option>GBP</option>
                                                <option>BND</option>
                                                <option>BGN</option>
                                                <option>BIF</option>
                                                <option>XOF</option>
                                                <option>XAF</option>
                                                <option>XPF</option>
                                                <option>KHR</option>
                                                <option>CAD</option>
                                                <option>CVE</option>
                                                <option>KYD</option>
                                                <option>CLP</option>
                                                <option>CNY</option>
                                                <option>COP</option>
                                                <option>KMF</option>
                                                <option>CDF</option>
                                                <option>CRC</option>
                                                <option>HRK</option>
                                                <option>CUC</option>
                                                <option>CUP</option>
                                                <option>CYP (EURO)</option>
                                                <option>CZK</option>
                                                <option>DKK</option>
                                                <option>DJF</option>
                                                <option>DOP</option>
                                                <option>XCD</option>
                                                <option>EGP</option>
                                                <option>SVC</option>
                                                <option>EEK (EURO)</option>
                                                <option>ETB</option>
                                                <option>EUR</option>
                                                <option>FKP</option>
                                                <option>FIM (EURO)</option>
                                                <option>FJD</option>
                                                <option>GMD</option>
                                                <option>GEL</option>
                                                <option>DMK (EURO)</option>
                                                <option>GHS</option>
                                                <option>GIP</option>
                                                <option>GRD (EURO)</option>
                                                <option>GTQ</option>
                                                <option>GNF</option>
                                                <option>GYD</option>
                                                <option>HTG</option>
                                                <option>HNL</option>
                                                <option>HKD</option>
                                                <option>HUF</option>
                                                <option>ISK</option>
                                                <option>INR</option>
                                                <option>IDR</option>
                                                <option>IRR</option>
                                                <option>IQD</option>
                                                <option>IED (EURO)</option>
                                                <option>ILS</option>
                                                <option>ITL (EURO)</option>
                                                <option>JMD</option>
                                                <option>JPY</option>
                                                <option>JOD</option>
                                                <option>KZT</option>
                                                <option>KES</option>
                                                <option>KWD</option>
                                                <option>KGS</option>
                                                <option>LAK</option>
                                                <option>LVL (EURO)</option>
                                                <option>LBP</option>
                                                <option>LSL</option>
                                                <option>LRD</option>
                                                <option>LYD</option>
                                                <option>LTL (EURO)</option>
                                                <option>LUF (EURO)</option>
                                                <option>MOP</option>
                                                <option>MKD</option>
                                                <option>MGA</option>
                                                <option>MWK</option>
                                                <option>MYR</option>
                                                <option>MVR</option>
                                                <option>MTL (EURO)</option>
                                                <option>MRO</option>
                                                <option>MUR</option>
                                                <option>MXN</option>
                                                <option>MDL</option>
                                                <option>MNT</option>
                                                <option>MAD</option>
                                                <option>MZN</option>
                                                <option>MMK</option>
                                                <option>ANG</option>
                                                <option>NAD</option>
                                                <option>NPR</option>
                                                <option>NLG (EURO)</option>
                                                <option>NZD</option>
                                                <option>NIO</option>
                                                <option>NGN</option>
                                                <option>KPW</option>
                                                <option>NOK</option>
                                                <option>OMR</option>
                                                <option>PKR</option>
                                                <option>PAB</option>
                                                <option>PGK</option>
                                                <option>PYG</option>
                                                <option>PEN</option>
                                                <option>PHP</option>
                                                <option>PLN</option>
                                                <option>PTE (EURO)</option>
                                                <option>QAR</option>
                                                <option>RON</option>
                                                <option>RUB</option>
                                                <option>RWF</option>
                                                <option>WST</option>
                                                <option>STD</option>
                                                <option>SAR</option>
                                                <option>RSD</option>
                                                <option>SCR</option>
                                                <option>SLL</option>
                                                <option>SGD</option>
                                                <option>SKK (EURO)</option>
                                                <option>SIT (EURO)</option>
                                                <option>SBD</option>
                                                <option>SOS</option>
                                                <option>ZAR</option>
                                                <option>KRW</option>
                                                <option>ESP (EURO)</option>
                                                <option>LKR</option>
                                                <option>SHP</option>
                                                <option>SDG</option>
                                                <option>SRD</option>
                                                <option>SZL</option>
                                                <option>SEK</option>
                                                <option>CHF</option>
                                                <option>SYP</option>
                                                <option>TWD</option>
                                                <option>TZS</option>
                                                <option>THB</option>
                                                <option>TOP</option>
                                                <option>TTD</option>
                                                <option>TND</option>
                                                <option>TRY</option>
                                                <option>TMM</option>
                                                <option>USD</option>
                                                <option>UGX</option>
                                                <option>UAH</option>
                                                <option>UYU</option>
                                                <option>AED</option>
                                                <option>VUV</option>
                                                <option>VEB</option>
                                                <option>VND</option>
                                                <option>YER</option>
                                                <option>ZMK</option>
                                                <option>ZWD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" >
                                    <div class="form-group" >
                                        <label>Discount:</label>
                                        <div class="input-group mb-3" style="border:1px solid lightgray;border-radius:5px">
                                            <input id="cost_item_discount" type="text" class="form-control" value="0.0">
                                            <input readonly type="text" class="form-control" value="%" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="form-group" >
                                    <label>Yard remarks:</label>
                                    <textarea style="border:1px solid lightgray;border-radius:5px" id="cost_item_yard_remarks" class="form-control" name="yard_remarks" ></textarea>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-1" >
                                    <button id="insert-add-cost-item" type="button" class="btn btn-primary" >Save</button>
                                </div>
                                <div class="col-md-1" >
                                    <button id="cancel-add-cost-item" type="button" class="btn btn-default" >Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!---->
            <!--Work Order Quotes-->
            <div class="col-md-12" >
                <div class="card" style="border: solid 1px lightgray;min-height:30vh;">
                    <div class="card-header d-flex">
                        <b>Task Quotes</b>
                    </div>
                    <div class="card-body" style="padding:10px" >
                        <table id="table-quotes-from-yard" class="table " style="margin:0" >
                            <thead>
                            <tr>
                                <td>QUOTE</td>
                                <td>COST</td>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($allYards as $oneYard) {
                                ?>
                                <tr>
                                    <td>
                                        Total yard quote from <?php echo $oneYard->title;?>
                                    </td>
                                    <td>
                                        USD <?php
                                        $totalYardCost=0;
                                        foreach (array_filter($allYardCostItems,function($oneItem)use($oneYard){
                                            return (string)$oneItem->shipyard_id==(string)$oneYard->id;
                                        }) as $oneItem) {
                                            $totalYardCost+=(float)$oneItem->quantity*(float)$oneItem->unit_price;
                                        };
                                        echo $totalYardCost;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                <tr>
                                    <td>Billed cost</td>
                                    <td>USD 0.00</td>
                                </tr>
                                <tr>
                                    <td>Final cost</td>
                                    <td>USD 0.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!---->

            <!--Work Order Quotes-->
            <div class="col-md-12" >
                <div class="card" style="border: solid 1px lightgray;min-height:20vh;">
                    <div class="card-header d-flex">
                        <b>Owner's Supply</b>
                    </div>
                    <div class="card-body" style="padding:10px" >
                        <table id="table-owners-supplies" class="table " style="margin:0" >
                            <thead>
                            <tr>
                                <td>Cost Item Name</td>
                                <td>COST</td>
                                <td>Order Number</td>
                                <td><Button id="btn-add-owner-supply" class="btn btn-default btn-sm" ><i data-feather="plus-circle" class="icon-16" ></i></Button></td>
                            </tr>
                            </thead>
                            <tbody id="table-owners-supplies-table-body">
                                <?php
                                foreach ($owner_supplies as $oneItem) {
                                ?>
                                <tr>
                                    <td><?php echo $oneItem->name;?></td>
                                    <td><?php echo $oneItem->cost;?></td>
                                    <td><?php echo $oneItem->order_number;?></td>
                                    <td><button  class="btn btn-sm btn-default" ><i data-feather="x" class="icon-16" ></i></button></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div id="owner-supply-edit-panel" hidden style="margin-top:5vh" >
                            <div class="row" >
                                <div class="form-group" >
                                    <label>Cost Item Name:</label>
                                    <input
                                    id="owner_supply_name"
                                    name="owner_supply_name"
                                    class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="row" >
                                <div class="form-group" >
                                    <label>Description:</label>
                                    <textarea
                                    id="owner_supply_description"
                                    name="owner_supply_description"
                                    class="form-control"
                                    ></textarea>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6" >
                                    <div class="form-group" >
                                        <label>Unit Price:</label>
                                        <input
                                        type="number"
                                        name="owner_supply_price"
                                        id="owner_supply_price"
                                        class="form-control"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <div class="form-group" >
                                        <label>Order Number:</label>
                                        <input
                                        id="owner_supply_order_number"
                                        name="owner_supply_order_number"
                                        class="form-control"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <button id="btn-save-owner-supply" class="btn btn-primary" >Save</button>
                                <button id="btn-cancel-owner-supply" class="btn btn-default" style="margin-left:1vh" >Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!---->
            <!--Variation Orders-->
            <div class="col-md-12" >
                <div class="card" style="border: solid 1px lightgray;min-height:30vh;">
                    <div class="card-header d-flex">
                        <b>Variation Orders</b>
                    </div>
                    <div class="card-body" style="padding:10px" >
                        <table id="table-quotes-from-yard" class="table table-variation-orders" style="margin:0" >
                            <thead>
                            <tr>
                                <td>Order name</td>
                                <td>Additional cost</td>
                                <td>Start date</td>
                                <td>Finish date</td>
                                <td><?php echo modal_anchor(get_uri('tasks/modal_add_order/'.$task_id),'<button class="btn btn-sm btn-default" ><i class="icon-16" data-feather="plus-circle" ></i></button>',array("title"=>"Creation Variation Order"));?></td>
                            </tr>
                            </thead>
                            <tbody >
                                <?php
                                foreach ($variation_orders as $oneOrder) {
                                ?>
                                <tr>
                                    <td><?php echo $oneOrder->name; ?></td>
                                    <td><?php echo $oneOrder->currency; ?> <?php echo $oneOrder->cost; ?></td>
                                    <td><?php echo date("d.m.Y", strtotime($oneOrder->start_date)); ?></td>
                                    <td><?php echo date("d.m.Y", strtotime($oneOrder->finish_date)); ?></td>
                                    <td><input hidden value='<?php echo $oneOrder->id;?>' /><button class="btn btn-sm btn-default delete-variation-order-item" ><i class="icon-16" data-feather="x" ></i></button></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!----->
        </div>
        <!---->
    </div>

    <div id="activity" class="tab-pane fade" >
        <div class="box-title"><span ><?php echo app_lang("comments"); ?></span></div>
        <!--Task comment section-->
        <div class="clearfix">
            <div class="mb5">
                <strong>Write a comment. </strong>
            </div>
            <div class="b-t pt10 list-container">
                <?php 
                echo view("projects/comments/comment_list_text"); 
                ?>
                <?php if ($can_comment_on_tasks) { ?>
                    <?php echo view("projects/comments/comment_form"); ?>
                <?php } ?>
                
            </div>
        </div>
        <!---->
        <?php if ($login_user->user_type === "staff") { ?>
            <div class="box-title"><span ><?php echo app_lang("activity"); ?></span></div>
            <div class="pl15 pr15 mt15 list-container project-activity-logs-container">
                <?php echo activity_logs_widget(array("limit" => 20, "offset" => 0, "log_type" => "task", "log_type_id" => $model_info->id)); ?>
            </div>
        <?php } ?>
    </div>
    <div id="files" class="tab-pane fade" >
        <div class="box-title"><span ><?php echo app_lang("files"); ?></span></div>
        <div class="d-flex justify-content-end"  >
            <div >
                <a href="<?php echo get_uri('/tasks/download_task_files/'.$task_id);?>" id="btn-download-all" class="btn btn-sm" ><i color="gray" data-feather="download" class="icon-16" ></i></a>
                <button id="btn-grid-group" class="btn btn-sm" ><i color="gray" data-feather="grid" class="icon-16" ></i></button>
                <button id="btn-list-group" class="btn btn-sm" ><i color="gray" data-feather="list" class="icon-16" ></i></button>
                <button id="btn-add-file" class="btn btn-sm" ><i color="gray" data-feather="plus-circle" class="icon-16" ></i></button>
            </div>
        </div>
        <?php 
        // echo view("projects/comments/comment_list"); 
        ?>
        <input type="file" hidden id="new-comment-file-selector" />
        <div class="row item-group" >
            <?php 
            // app_hooks()->do_action('app_hook_task_view_right_panel_extension');
            $all_files=array();
            foreach($comments as $oneComment){
                $files = unserialize($oneComment->files);
                $all_files=array_merge($all_files,$files);
                $total_files = count($files);
                $timeline_file_path = isset($file_path) ? $file_path : get_setting("timeline_file_path");
                foreach($files as $oneFile){
                    // echo $oneFile['file_name'];
                    $url = get_source_url_of_file($oneFile, $timeline_file_path);
                    $thumbnail = get_source_url_of_file($oneFile, $timeline_file_path, "thumbnail");
                    $actual_file_name = remove_file_prefix($oneFile['file_name']);

                    $lll=is_viewable_image_file($oneFile['file_name'])?$url:get_source_url_of_file(array("file_name" => "store-item-no-image.png"), get_setting("system_file_path"));
                    echo 
                    '<div class="group-item col-md-2" >
                        <img class="item-image" src="'.$url.'" />
                        <p class="item-title" >'.$actual_file_name.'</p>
                        <a target="_blank" href="'.get_uri("tasks/download_one_file/".$oneFile['file_name']).'"  class="btn-download-item btn btn-sm" ><i data-feather="download-cloud" class="icon-16" ></i></a>
                    </div>';
                }
            }
            ?>
         </div>
    </div>
        
</div>
<script>
    $(document).ready(function(){
        $("#cost_item_currency_symbol").on('mousedown', false);
        $("#cost_item_currency_symbol").on('keydown', false);
        $("#owner_supply_currency_symbol").on('mousedown', false);
        $("#owner_supply_currency_symbol").on('keydown', false);
        $("#btn-add-new-quote").on("click",function(){
            $("#insert-cost-item-panel").prop("hidden",false);
            $("#btn-add-new-quote").prop("disabled", true);

        })
        $("#insert-add-cost-item").on("click",function(){
            var table=$("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            var cell0 = newRow.insertCell(0);
            var cell1 = newRow.insertCell(1);
            var cell2 = newRow.insertCell(2);
            var cell3 = newRow.insertCell(3);

            cell0.innerHTML = $("#cost_item_name")[0].value;
            cell1.innerHTML = Number($("#cost_item_quantity")[0].value).toFixed(1)+' '+$("#cost_item_measurement_unit")[0].value+" X "+$("#cost_item_currency")[0].value+" "+Number($("#cost_item_unit_price")[0].value).toFixed(2)+" ( "+$("#cost_item_quote_type")[0].value+" ) ";
            cell2.innerHTML = $("#cost_item_currency")[0].value+" "+(Number($("#cost_item_quantity")[0].value)*Number($("#cost_item_unit_price")[0].value)).toFixed(2);
            cell3.innerHTML=`
            <button onClick="start_edit_cost_item(${cost_items.length})" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="edit" class="icon-16" ></i></button>
            <button type="button" onClick="delete_item(${cost_items.length})" class="btn btn-sm" ><i style="color:gray" data-feather="x-circle" class="icon-16" ></i></button>
            `;
            $("#btn-add-new-quote").prop("disabled", false);
            $("#insert-cost-item-panel").prop("hidden",false);
            
            if($("#editing_cost_item")[0].value=="")
                cost_items.push({
                    name:$("#cost_item_name")[0].value,
                    quantity:$("#cost_item_quantity")[0].value,
                    measurement_unit:$("#cost_item_measurement_unit")[0].value,
                    unit_price:$("#cost_item_unit_price")[0].value,
                    quote_type:$("#cost_item_quote_type")[0].value,
                    currency:$("#cost_item_currency")[0].value,
                    description:$("#cost_item_description")[0].value,
                    discount:$("#cost_item_discount")[0].value,
                    yard_remarks:$("#cost_item_yard_remarks")[0].value,
                });
            else{
                $("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0].deleteRow(Number($("#editing_cost_item")[0].value));
                cost_items[Number($("#editing_cost_item")[0].value)]={
                    name:$("#cost_item_name")[0].value,
                    description:$("#cost_item_description")[0].value,
                    discount:$("#cost_item_discount")[0].value,
                    quantity:$("#cost_item_quantity")[0].value,
                    measurement_unit:$("#cost_item_measurement_unit")[0].value,
                    unit_price:$("#cost_item_unit_price")[0].value,
                    quote_type:$("#cost_item_quote_type")[0].value,
                    currency:$("#cost_item_currency")[0].value,
                    yard_remarks:$("#cost_item_yard_remarks")[0].value,
                };  
            }
            $("#editing_cost_item")[0].value="";
            $("#cost_item_name")[0].value="";
            $("#cost_item_description")[0].value="";
            $("#cost_item_quantity")[0].value="";
            $("#cost_item_unit_price")[0].value="";
            $("#cost_item_yard_remarks")[0].value="";
            $.ajax({
                url:'<?php echo get_uri('tasks/save_task_cost_items');?>',
                method:"POST",
                data:{
                    task_id:<?php echo $model_info->id;?>,
                    cost_items:JSON.stringify(cost_items)
                },
                success:function(response){
                }
            })
            
        });
        $("#cancel-add-cost-item").on("click",function(){
            $("#insert-cost-item-panel").prop("hidden",true);
            $("#btn-add-new-quote").prop("disabled", false);
        })
        $("#cost_item_currency").on("change",function(){
            $("#cost_item_currency_symbol")[0].selectedIndex=$("#cost_item_currency")[0].selectedIndex;
        })
        $("#owner_supply_currency").on("change",function(){
            $("#owner_supply_currency_symbol")[0].selectedIndex=$("#owner_supply_currency")[0].selectedIndex;
        })
        $("#btn-add-owner-supply").on("click",function(){
            $("#owner-supply-edit-panel").prop('hidden',false);
            $("#btn-add-owner-supply").prop("disabled",true);
        })
        $("#btn-save-owner-supply").on("click",function(){
            // $("#owner-supply-edit-panel").prop('hidden',false);
            // $("#btn-add-owner-supply").prop("disabled",true);
            
        })
        $("#btn-cancel-owner-supply").on("click",function(){
            $("#owner-supply-edit-panel").prop('hidden',true);
            $("#btn-add-owner-supply").prop("disabled",false);
        })
        $("#btn-save-owner-supply").on("click",function(){
            var owner_supply_name=$("#owner_supply_name")[0].value;
            var owner_supply_description=$("#owner_supply_description")[0].value;
            var owner_supply_price=$("#owner_supply_price")[0].value;
            var owner_supply_order_number=$("#owner_supply_order_number")[0].value;
            owner_supplies.push({
                name:owner_supply_name,
                description:owner_supply_description,
                price:owner_supply_price,
                order_number:owner_supply_order_number
            })
            $.ajax({
                url:'<?php echo get_uri('tasks/save_owner_supply');?>',
                method:"POST",
                data:{
                    task_id:'<?php echo $task_id;?>',
                    name:$("#owner_supply_name")[0].value,
                    description:$("#owner_supply_description")[0].value,
                    cost:$("#owner_supply_price")[0].value,
                    order_number:$("#owner_supply_order_number")[0].value

                },
                success:function(response){
                    console.log(response)
                }
            })
            var table=$("#table-owners-supplies")[0].getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();
            var cell0 = newRow.insertCell(0);
            var cell1 = newRow.insertCell(1);
            var cell2 = newRow.insertCell(2);
            var cell3 = newRow.insertCell(3);
            cell0.innerHTML = owner_supply_name;
            cell1.innerHTML = "USD "+owner_supply_price;
            cell2.innerHTML = owner_supply_order_number;
            cell3.innerHTML=`
            <button onClick="view_owner_supply(${owner_supplies.length})" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="eye" class="icon-16" ></i></button>
            <button onClick="start_edit_owner_supply(${owner_supplies.length})" type="button" class="btn btn-sm" ><i style="color:gray" data-feather="edit" class="icon-16" ></i></button>
            <button type="button" onClick="delete_owner_supply(${owner_supplies.length})" class="btn btn-sm" ><i style="color:gray" data-feather="x-circle" class="icon-16" ></i></button>
            `;
        });
        $("#btn-grid-group").on("click",function(){
            $(".group-item").removeClass("col-md-12").addClass("col-md-2");
            $("#btn-grid-group").prop("disabled",true);
            $("#btn-list-group").prop("disabled",false);
        });
        $("#btn-list-group").on("click",function(){
            $(".group-item").removeClass("col-md-2").addClass("col-md-12");
            $("#btn-grid-group").prop("disabled",false);
            $("#btn-list-group").prop("disabled",true);
        });
        $("#btn-grid-group").prop("disabled",true);
        $("#btn-add-file").on("click",function(){
            $("#new-comment-file-selector").click();
        });
        $("#new-comment-file-selector").on("change",function(event){
            if(event.target.files.length==0) return;
            var myForm=new FormData();
            myForm.append("file_names",[event.target.files[0].name]);
            myForm.append("file_sizes",[event.target.files[0].size]);
            myForm.append("file",event.target.files[0]);
            myForm.append("project_id",'<?php echo $model_info->project_id; ?>');
            myForm.append("id",'<?php echo $model_info->id; ?>');
            $.ajax({
                url: '<?php
                    echo get_uri('tasks/upload_comment_file'); 
                ?>',
                type: "POST",
                data: myForm,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="<?= csrf_token() ?>"]').val()
                },
                processData: false, // prevent jQuery from processing the data
                contentType: false,
                success: function (response) {
                    window.location.reload();
                }
            });
        });
        $(".delete-variation-order-item").on("click",function(){
            var order_id=$(this).parent().find('input')[0].value;
            var delTr=$(this).closest('tr');
            $.ajax({
                url:'<?php echo get_uri('tasks/delete_variation_order');?>/'+order_id,
                method:"GET",
                success:function(response){
                    if(JSON.parse(response).success)
                        delTr.remove();
                }
            })
        })
    })
    var cost_items=[];
    var owner_supplies=[];
    function save_new_quote(){
        var table=$("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();

        var cell0 = newRow.insertCell(0);
        var cell1 = newRow.insertCell(1);
        var cell2 = newRow.insertCell(2);
        var cell3 = newRow.insertCell(3);

        cell0.innerHTML = $("#quote_name")[0].value;
        cell1.innerHTML = $("#quote_price")[0].value;
        cell2.innerHTML = $("#quote_quote")[0].value;
        cell3.innerHTML = "";
        $("#btn-save-new-quote")[0].closest("tr").remove();
        $("#btn-add-new-quote").prop("disabled", false);
    }
    function delete_item(index){
        cost_items.splice(index,1);
        $("#table-quotes-from-yard")[0].getElementsByTagName('tbody')[0].deleteRow(index);
        $.ajax({
            url:'<?php echo get_uri('tasks/save_task_cost_items');?>',
            method:"POST",
            data:{
                task_id:<?php echo $model_info->id;?>,
                cost_items:JSON.stringify(cost_items)
            },
            success:function(response){
            }
        })
        
    }
    function start_edit_cost_item(index){
        $("#editing_cost_item")[0].value=index;
        $("#btn-add-new-quote")[0].click();
        $("#cost_item_name")[0].value=cost_items[index].name;
        $("#cost_item_quantity")[0].value=cost_items[index].quantity;
        $("#cost_item_measurement_unit")[0].value=cost_items[index].measurement_unit;
        $("#cost_item_unit_price")[0].value=cost_items[index].unit_price;
        $("#cost_item_quote_type")[0].value=cost_items[index].quote_type;
        $("#cost_item_currency")[0].value=cost_items[index].currency;
    }
    function delete_owner_supply(index){
        owner_supplies.splice(index,1);
        $("#table-owners-supplies")[0].getElementsByTagName('tbody')[0].deleteRow(index);
    }
    function delete_variation_order(e){  
        var order_id=e.target.parentNode.querySelector('input').value;
        $.ajax({
            url:'<?php echo get_uri('tasks/delete_variation_order');?>/'+order_id,
            method:"GET",
            success:function(response){
                if(JSON.parse(response).success)
                e.target.parentNode.parentNode.parentNode.removeChild(e.target.closest('tr'));
            }
        })
    }
    <?php
        if(isset($model_info)&&$model_info->cost_items)
        echo 'cost_items=JSON.parse(`'.$model_info->cost_items.'`);';
    ?>
    
    <?php if(count($all_files)>0)
    echo 'var all_files='.json_encode($all_files).';'
    ?>
</script>