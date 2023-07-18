<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view('includes/head'); ?>
</head>

<body style="overflow: auto;">

    <?php
    $progress = 0;
    if ($total_sub_tasks) {
        $progress = round($completed_sub_tasks / $total_sub_tasks * 100);
    }
    $yes_icon = '<i data-feather="check-square" class="icon-16"></i>';
    $no_icon = '<i data-feather="square" class="icon-16"></i>';
    ?>

    <div id="page-content" class="page-wrapper pb0 clearfix task-view-modal-body task-preview">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="page-title clearfix">
                        <h1><?php echo app_lang("task_info") . " #$model_info->id"; ?> <?php echo anchor(get_uri("projects/task_view/" . $model_info->id), '<i data-feather="external-link" class="icon-16"></i>', array("target" => "_blank")); ?></h1>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-4 order-lg-last">
                                <div class="clearfix">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12 mb15 mt15">
                                                <?php
                                                echo "<span class='badge' style='background:$model_info->status_color; '>" . get_update_task_info_anchor_data($model_info, "status", $can_edit_tasks) . "</span>";
                                                ?>
                                            </div>
                                            <div class="col-md-12 mb15 task-title-right d-none">
                                                <strong><?php echo $model_info->title; ?></strong>
                                            </div>

                                            <?php if ($total_sub_tasks) { ?>
                                                <div class="col-md-12 mb15 mt15">
                                                    <span class=""><?php echo $completed_sub_tasks . "/" . $total_sub_tasks; ?> <?php echo app_lang("sub_tasks_completed"); ?></span>
                                                    <div class="progress mt5" style="height: 6px;" title="<?php echo $progress; ?>%">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="col-md-12 mt15 mb15">
                                                <strong><?php echo app_lang('milestone') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "milestone", $can_edit_tasks); ?>
                                            </div>

                                            <div class="col-md-12 mb15">
                                                <strong><?php echo app_lang('start_date') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "start_date", $can_edit_tasks); ?>
                                            </div>

                                            <div class="col-md-12 mb15">
                                                <strong><?php echo app_lang('deadline') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "deadline", $can_edit_tasks); ?>
                                                <?php if ($model_info->deadline_milestone_title) { ?>
                                                    <span class="help task-deadline-milestone-tooltip" data-bs-toggle="tooltip" title="<?php echo app_lang('milestone') . ": " . $model_info->deadline_milestone_title; ?>"><i data-feather="help-circle" class="icon-16"></i></span>
                                                <?php } ?>
                                            </div>

                                            <div class="col-md-12 mb15">
                                                <strong><?php echo app_lang('priority') . ": "; ?></strong> <?php echo get_update_task_info_anchor_data($model_info, "priority", $can_edit_tasks); ?>
                                            </div>

                                            <div class="col-md-12 mb15">
                                                <strong><?php echo app_lang('category') . ": " ?></strong><?php echo get_update_task_info_anchor_data($model_info, "labels", $can_edit_tasks, $labels); ?>
                                            </div>

                                            <div class="col-md-12 mb15">
                                                <strong><?php echo app_lang('collaborators') . ": "; ?> </strong>
                                                <div class="mt5">
                                                    <?php echo get_update_task_info_anchor_data($model_info, "collaborators", $can_edit_tasks, $collaborators); ?>
                                                </div>
                                            </div>

                                            <?php if ($model_info->ticket_id != "0") { ?>
                                                <div class="col-md-12 mb15">
                                                    <strong><?php echo app_lang("ticket") . ": "; ?> </strong> <?php echo anchor(get_uri("tickets/view/" . $model_info->ticket_id), get_ticket_id($model_info->ticket_id) . " - " . $model_info->ticket_title); ?>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 mb15">
                                <div class="clearfix">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12 mb15 task-title-left">
                                                <strong><?php echo $model_info->title; ?></strong>
                                            </div>

                                            <?php if ($model_info->parent_task_id) { ?>
                                                <div class="col-md-12 mb15">
                                                    <strong><?php echo app_lang("main_task") . ": "; ?></strong><?php echo anchor(get_uri("task_view/index/" . $model_info->parent_task_id), $parent_task_title, array("target" => "_blank")); ?>
                                                </div>
                                            <?php } ?>

                                            <?php if ($model_info->description) { ?>
                                                <div class="col-md-12 mb15 text-wrap">
                                                    <?php echo $model_info->description ? nl2br(link_it(process_images_from_content($model_info->description))) : ""; ?>
                                                </div>
                                            <?php } ?>

                                            <div class="col-md-12 mb15">
                                                <strong><?php echo app_lang('project') . ": "; ?> </strong> <?php echo anchor(get_uri("projects/view/" . $model_info->project_id), $model_info->project_title, array("target" => "_blank")); ?>
                                            </div>

                                            <?php if ($model_info->parent_task_id == 0) { ?>
                                                <?php if ($model_info->dock_list_number) { ?>
                                                    <div class="col-md-12 mb15">
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


                                            <!--checklist-->
                                            <div class="col-md-12 mb15 b-t">
                                                <div class="pb10 pt10">
                                                    <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count">0</span><span>/</span><span class="chcklists_count"></span>
                                                </div>

                                                <div class="checklist-items" id="checklist-items">
                                                </div>
                                            </div>

                                            <!--Sub tasks-->
                                            <div class="col-md-12 mb15 b-t">
                                                <div class="pb10 pt10">
                                                    <strong><?php echo app_lang("sub_tasks"); ?></strong>
                                                </div>

                                                <div class="checklist-items" id="sub-tasks">
                                                </div>
                                            </div>

                                            <!--Task comment section-->
                                            <div class="clearfix">
                                                <div class="b-t pt10 list-container">
                                                    <?php echo view("task_view/comment_list"); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            //show the items in checklist
            $("#checklist-items").html(<?php echo $checklist_items; ?>);

            var checklists = $(".checklist-items .checklist-item-row").length;
            //count checklists
            function count_checklists() {
                var checklists = $(".checklist-items .checklist-item-row").length;
                $(".chcklists_count").text(checklists);
            }

            var checklist_complete = $(".checklist-items .checkbox-checked").length;
            $(".chcklists_status_count").text(checklist_complete);

            count_checklists();

            //show the sub tasks
            $("#sub-tasks").html(<?php echo $sub_tasks; ?>);


        });
    </script>
</body>

</html>