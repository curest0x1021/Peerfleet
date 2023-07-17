<?php echo form_open(get_uri("projects/save_task"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
<div id="tasks-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <input type="hidden" name="id" value="<?php echo $add_type == "multiple" ? "" : $model_info->id; ?>" />
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
            <input type="hidden" name="add_type" value="<?php echo $add_type; ?>" />
            <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>" />

            <?php if ($is_clone) { ?>
                <input type="hidden" name="is_clone" value="1" />
            <?php } ?>

            <div class="form-group">
                <div class="row">
                    <label for="title" class=" col-md-3"><?php echo app_lang('title'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "title",
                            "name" => "title",
                            "value" => $add_type == "multiple" ? "" : $model_info->title,
                            "class" => "form-control",
                            "placeholder" => app_lang('title'),
                            "maxlength" => 60,
                            "autofocus" => true,
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="project_labels" class=" col-md-3"><?php echo app_lang('category'); ?></label>
                    <div class=" col-md-9" id="dropdown-apploader-section">
                        <?php
                        echo form_input(array(
                            "id" => "project_labels",
                            "name" => "category",
                            "value" => $model_info->labels,
                            "class" => "form-control",
                            "placeholder" => app_lang('category')
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="dock_list_number" class=" col-md-3"><?php echo app_lang('dock_list_number'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "dock_list_number",
                            "name" => "dock_list_number",
                            "value" => $add_type == "multiple" ? "" : $model_info->dock_list_number,
                            "class" => "form-control",
                            "maxlength" => 15,
                            "placeholder" => app_lang('dock_list_number'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="reference_drawing" class=" col-md-3"><?php echo app_lang('reference_drawing'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "reference_drawing",
                            "name" => "reference_drawing",
                            "value" => $add_type == "multiple" ? "" : $model_info->reference_drawing,
                            "class" => "form-control",
                            "maxlength" => 30,
                            "placeholder" => app_lang('reference_drawing'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="description" class=" col-md-3"><?php echo app_lang('description'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_textarea(array(
                            "id" => "description",
                            "name" => "description",
                            "value" => $add_type == "multiple" ? "" : process_images_from_content($model_info->description, false),
                            "class" => "form-control",
                            "placeholder" => app_lang('description'),
                            "data-rich-text-editor" => true
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="location" class=" col-md-3"><?php echo app_lang('location'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_textarea(array(
                            "id" => "location",
                            "name" => "location",
                            "value" => $add_type == "multiple" ? "" : $model_info->location,
                            "class" => "form-control",
                            "placeholder" => app_lang('location'),
                            "maxlength" => 300,
                            "data-rich-text-editor" => true,
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="specification" class=" col-md-3"><?php echo app_lang('specification'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_textarea(array(
                            "id" => "specification",
                            "name" => "specification",
                            "value" => $add_type == "multiple" ? "" : $model_info->specification,
                            "class" => "form-control",
                            "placeholder" => app_lang('specification_placeholder'),
                            "maxlength" => 300,
                            "data-rich-text-editor" => true,
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="requisition_number" class=" col-md-3"><?php echo app_lang('requisition_number'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "requisition_number",
                            "name" => "requisition_number",
                            "value" => $add_type == "multiple" ? "" : $model_info->requisition_number,
                            "class" => "form-control",
                            "maxlength" => 30,
                            "placeholder" => app_lang('requisition_number'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <?php if (!$project_id) { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="project_id" class=" col-md-3"><?php echo app_lang('project'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_dropdown("project_id", $projects_dropdown, array($model_info->project_id), "class='select2 validate-hidden' id='project_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- <div class="form-group">
                <div class="row">
                    <label for="points" class="col-md-3"><?php echo app_lang('points'); ?>
                        <span class="help" data-bs-toggle="tooltip" title="<?php echo app_lang('task_point_help_text'); ?>"><i data-feather="help-circle" class="icon-16"></i></span>
                    </label>

                    <div class="col-md-9">
                        <?php
                        echo form_dropdown("points", $points_dropdown, array($model_info->points), "class='select2' id='points'");
                        ?>
                    </div>
                </div>
            </div> -->
            <!-- <div class="form-group">
                <div class="row">
                    <label for="milestone_id" class=" col-md-3"><?php echo app_lang('milestone'); ?></label>
                    <div class="col-md-9" id="dropdown-apploader-section">
                        <?php
                        echo form_input(array(
                            "id" => "milestone_id",
                            "name" => "milestone_id",
                            "value" => $model_info->milestone_id,
                            "class" => "form-control",
                            "placeholder" => app_lang('milestone')
                        ));
                        ?>
                    </div>
                </div>
            </div> -->

            <?php if ($show_assign_to_dropdown) { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="assigned_to" class=" col-md-3"><?php echo app_lang('assign_to'); ?></label>
                        <div class="col-md-9" id="dropdown-apploader-section">
                            <?php
                            echo form_input(array(
                                "id" => "assigned_to",
                                "name" => "assigned_to",
                                "value" => $model_info->assigned_to,
                                "class" => "form-control",
                                "placeholder" => app_lang('assign_to')
                            ));
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label for="collaborators" class=" col-md-3"><?php echo app_lang('collaborators'); ?></label>
                        <div class="col-md-9" id="dropdown-apploader-section">
                            <?php
                            echo form_input(array(
                                "id" => "collaborators",
                                "name" => "collaborators",
                                "value" => $model_info->collaborators,
                                "class" => "form-control",
                                "placeholder" => app_lang('collaborators')
                            ));
                            ?>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <div class="form-group">
                <div class="row">
                    <label for="status_id" class=" col-md-3"><?php echo app_lang('status'); ?></label>
                    <div class="col-md-9">
                        <?php
                        foreach ($statuses as $status) {
                            $task_status[$status->id] = $status->key_name ? app_lang($status->key_name) : $status->title;
                        }

                        if ($is_clone) {
                            echo form_dropdown("status_id", $task_status, 1, "class='select2'");
                        } else {
                            echo form_dropdown("status_id", $task_status, array($model_info->status_id), "class='select2'");
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="priority_id" class=" col-md-3"><?php echo app_lang('priority'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "priority_id",
                            "name" => "priority_id",
                            "value" => $model_info->priority_id,
                            "class" => "form-control",
                            "placeholder" => app_lang('priority')
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="start_date" class=" col-md-3"><?php echo app_lang('start_date'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "start_date",
                            "name" => "start_date",
                            "autocomplete" => "off",
                            "value" => is_date_exists($model_info->start_date) ? $model_info->start_date : "",
                            "class" => "form-control",
                            "placeholder" => "YYYY-MM-DD"
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="deadline" class=" col-md-3"><?php echo app_lang('deadline'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "deadline",
                            "name" => "deadline",
                            "autocomplete" => "off",
                            "value" => is_date_exists($model_info->deadline) ? $model_info->deadline : "",
                            "class" => "form-control",
                            "placeholder" => "YYYY-MM-DD",
                            "data-rule-greaterThanOrEqual" => "#start_date",
                            "data-msg-greaterThanOrEqual" => app_lang("deadline_must_be_equal_or_greater_than_start_date")
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <!-- To be included  -->
            <div class="form-group">
                <h4><?php echo app_lang("to_be_included"); ?>:</h4>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <label for="gas_free_certificate" class="col-7"><?php echo app_lang('gas_free_certificate'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "gas_free_certificate_yes",
                                    "name" => "gas_free_certificate",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->gas_free_certificate == "1") ? true : false);
                                ?>
                                <label for="gas_free_certificate_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "gas_free_certificate_no",
                                    "name" => "gas_free_certificate",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->gas_free_certificate == "0") ? true : false);
                                ?>
                                <label for="gas_free_certificate_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="painting_after_completion" class="col-7"><?php echo app_lang('painting_after_completion'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "painting_after_completion_yes",
                                    "name" => "painting_after_completion",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->painting_after_completion == "1") ? true : false);
                                ?>
                                <label for="painting_after_completion_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "painting_after_completion_no",
                                    "name" => "painting_after_completion",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->painting_after_completion == "0") ? true : false);
                                ?>
                                <label for="painting_after_completion_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="light" class="col-7"><?php echo app_lang('light'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "light_yes",
                                    "name" => "light",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->light == "1") ? true : false);
                                ?>
                                <label for="light_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "light_no",
                                    "name" => "light",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->light == "0") ? true : false);
                                ?>
                                <label for="light_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="parts_on_board" class="col-7"><?php echo app_lang('parts_on_board'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "parts_on_board_yes",
                                    "name" => "parts_on_board",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->parts_on_board == "1") ? true : false);
                                ?>
                                <label for="parts_on_board_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "parts_on_board_no",
                                    "name" => "parts_on_board",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->parts_on_board == "0") ? true : false);
                                ?>
                                <label for="parts_on_board_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="ventilation" class="col-7"><?php echo app_lang('ventilation'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "ventilation_yes",
                                    "name" => "ventilation",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->ventilation == "1") ? true : false);
                                ?>
                                <label for="ventilation_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "ventilation_no",
                                    "name" => "ventilation",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->ventilation == "0") ? true : false);
                                ?>
                                <label for="ventilation_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="transport_to_yard_workshop" class="col-7"><?php echo app_lang('transport_to_yard_workshop'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "transport_to_yard_workshop_yes",
                                    "name" => "transport_to_yard_workshop",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->transport_to_yard_workshop == "1") ? true : false);
                                ?>
                                <label for="transport_to_yard_workshop_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "transport_to_yard_workshop_no",
                                    "name" => "transport_to_yard_workshop",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->transport_to_yard_workshop == "0") ? true : false);
                                ?>
                                <label for="transport_to_yard_workshop_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="crane_assistance" class="col-7"><?php echo app_lang('crane_assistance'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "crane_assistance_yes",
                                    "name" => "crane_assistance",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->crane_assistance == "1") ? true : false);
                                ?>
                                <label for="crane_assistance_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "crane_assistance_no",
                                    "name" => "crane_assistance",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->crane_assistance == "0") ? true : false);
                                ?>
                                <label for="crane_assistance_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="transport_outside_yard" class="col-7"><?php echo app_lang('transport_outside_yard'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "transport_outside_yard_yes",
                                    "name" => "transport_outside_yard",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->transport_outside_yard == "1") ? true : false);
                                ?>
                                <label for="transport_outside_yard_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "transport_outside_yard_no",
                                    "name" => "transport_outside_yard",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->transport_outside_yard == "0") ? true : false);
                                ?>
                                <label for="transport_outside_yard_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="cleaning_before" class="col-7"><?php echo app_lang('cleaning_before'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "cleaning_before_yes",
                                    "name" => "cleaning_before",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->cleaning_before == "1") ? true : false);
                                ?>
                                <label for="cleaning_before_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "cleaning_before_no",
                                    "name" => "cleaning_before",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->cleaning_before == "0") ? true : false);
                                ?>
                                <label for="cleaning_before_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="material_yards_supply" class="col-7"><?php echo app_lang('material_yards_supply'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "material_yards_supply_yes",
                                    "name" => "material_yards_supply",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->material_yards_supply == "1") ? true : false);
                                ?>
                                <label for="material_yards_supply_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "material_yards_supply_no",
                                    "name" => "material_yards_supply",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->material_yards_supply == "0") ? true : false);
                                ?>
                                <label for="material_yards_supply_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="cleaning_after" class="col-7"><?php echo app_lang('cleaning_after'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "cleaning_after_yes",
                                    "name" => "cleaning_after",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->cleaning_after == "1") ? true : false);
                                ?>
                                <label for="cleaning_after_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "cleaning_after_no",
                                    "name" => "cleaning_after",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->cleaning_after == "0") ? true : false);
                                ?>
                                <label for="cleaning_after_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="material_owners_supply" class="col-7"><?php echo app_lang('material_owners_supply'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "material_owners_supply_yes",
                                    "name" => "material_owners_supply",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->material_owners_supply == "1") ? true : false);
                                ?>
                                <label for="material_owners_supply_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "material_owners_supply_no",
                                    "name" => "material_owners_supply",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->material_owners_supply == "0") ? true : false);
                                ?>
                                <label for="material_owners_supply_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="work_permit" class="col-7"><?php echo app_lang('work_permit'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "work_permit_yes",
                                    "name" => "work_permit",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->work_permit == "1") ? true : false);
                                ?>
                                <label for="work_permit_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "work_permit_no",
                                    "name" => "work_permit",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->work_permit == "0") ? true : false);
                                ?>
                                <label for="work_permit_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="risk_assessment" class="col-7"><?php echo app_lang('risk_assessment'); ?></label>
                            <div class="col-5">
                                <?php
                                echo form_radio(array(
                                    "id" => "risk_assessment_yes",
                                    "name" => "risk_assessment",
                                    "class" => "form-check-input",
                                ), "1", ($model_info->risk_assessment == "1") ? true : false);
                                ?>
                                <label for="risk_assessment_yes" class="mr15 p0"><?php echo app_lang('yes'); ?></label>
                                <?php
                                echo form_radio(array(
                                    "id" => "risk_assessment_no",
                                    "name" => "risk_assessment",
                                    "class" => "form-check-input",
                                ), "0", ($model_info->risk_assessment == "0") ? true : false);
                                ?>
                                <label for="risk_assessment_no" class="mr15 p0"><?php echo app_lang('no'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <!-- Maker informations -->
            <div>
                <h4><?php echo app_lang("maker_informations"); ?>:</h4>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="maker" class=" col-md-3"><?php echo app_lang('maker'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "maker",
                            "name" => "maker",
                            "value" => $add_type == "multiple" ? "" : $model_info->maker,
                            "class" => "form-control",
                            "maxlength" => 30,
                            "placeholder" => app_lang('maker'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="type" class=" col-md-3"><?php echo app_lang('type'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "type",
                            "name" => "type",
                            "value" => $add_type == "multiple" ? "" : $model_info->type,
                            "class" => "form-control",
                            "maxlength" => 30,
                            "placeholder" => app_lang('type'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="serial_number" class=" col-md-3"><?php echo app_lang('serial_number'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "serial_number",
                            "name" => "serial_number",
                            "value" => $add_type == "multiple" ? "" : $model_info->serial_number,
                            "class" => "form-control",
                            "maxlength" => 30,
                            "placeholder" => app_lang('serial_number'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="pms_scs_number" class=" col-md-3"><?php echo app_lang('pms_scs_number'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "pms_scs_number",
                            "name" => "pms_scs_number",
                            "value" => $add_type == "multiple" ? "" : $model_info->pms_scs_number,
                            "class" => "form-control",
                            "maxlength" => 30,
                            "placeholder" => app_lang('pms_scs_number'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <!--  -->

            <?php if (get_setting("enable_recurring_option_for_tasks")) { ?>

                <div class="form-group">
                    <div class="row">
                        <label for="recurring" class=" col-md-3"><?php echo app_lang('recurring'); ?>  <span class="help" data-bs-toggle="tooltip" title="<?php echo app_lang('cron_job_required'); ?>"><i data-feather="help-circle" class="icon-16"></i></span></label>
                        <div class=" col-md-9">
                            <?php
                            echo form_checkbox("recurring", "1", $model_info->recurring ? true : false, "id='recurring' class='form-check-input'");
                            ?>
                        </div>
                    </div>
                </div>   

                <div id="recurring_fields" class="<?php if (!$model_info->recurring) echo "hide"; ?>"> 
                    <div class="form-group">
                        <div class="row">
                            <label for="repeat_every" class=" col-md-3"><?php echo app_lang('repeat_every'); ?></label>
                            <div class="col-md-4">
                                <?php
                                echo form_input(array(
                                    "id" => "repeat_every",
                                    "name" => "repeat_every",
                                    "type" => "number",
                                    "value" => $model_info->repeat_every ? $model_info->repeat_every : 1,
                                    "min" => 1,
                                    "class" => "form-control recurring_element",
                                    "placeholder" => app_lang('repeat_every'),
                                    "data-rule-required" => true,
                                    "data-msg-required" => app_lang("field_required")
                                ));
                                ?>
                            </div>
                            <div class="col-md-5">
                                <?php
                                echo form_dropdown(
                                        "repeat_type", array(
                                    "days" => app_lang("interval_days"),
                                    "weeks" => app_lang("interval_weeks"),
                                    "months" => app_lang("interval_months"),
                                    "years" => app_lang("interval_years"),
                                        ), $model_info->repeat_type ? $model_info->repeat_type : "months", "class='select2 recurring_element' id='repeat_type'"
                                );
                                ?>
                            </div>
                        </div>    
                    </div>    

                    <div class="form-group">
                        <div class="row">
                            <label for="no_of_cycles" class=" col-md-3"><?php echo app_lang('cycles'); ?></label>
                            <div class="col-md-4">
                                <?php
                                echo form_input(array(
                                    "id" => "no_of_cycles",
                                    "name" => "no_of_cycles",
                                    "type" => "number",
                                    "min" => 1,
                                    "value" => $model_info->no_of_cycles ? $model_info->no_of_cycles : "",
                                    "class" => "form-control",
                                    "placeholder" => app_lang('cycles')
                                ));
                                ?>
                            </div>
                            <div class="col-md-5 mt5">
                                <span class="help" data-bs-toggle="tooltip" title="<?php echo app_lang('recurring_cycle_instructions'); ?>"><i data-feather="help-circle" class="icon-16"></i></span>
                            </div>
                        </div>  
                    </div>  

                    <div class = "form-group hide" id = "next_recurring_date_container" >
                        <div class="row">
                            <label for = "next_recurring_date" class = " col-md-3"><?php echo app_lang('next_recurring_date'); ?>  </label>
                            <div class=" col-md-9">
                                <?php
                                echo form_input(array(
                                    "id" => "next_recurring_date",
                                    "name" => "next_recurring_date",
                                    "class" => "form-control",
                                    "placeholder" => app_lang('next_recurring_date'),
                                    "autocomplete" => "off",
                                    "data-rule-required" => true,
                                    "data-msg-required" => app_lang("field_required"),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>  

            <?php } ?>

            <?php echo view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?> 

            <?php echo view("includes/dropzone_preview"); ?>

            <?php if ($is_clone) { ?>
                <?php if ($has_checklist) { ?>
                    <div class="form-group">
                        <label for="copy_checklist" class=" col-md-12">
                            <?php
                            echo form_checkbox("copy_checklist", "1", true, "id='copy_checklist' class='float-start mr15 form-check-input'");
                            ?>    
                            <?php echo app_lang('copy_checklist'); ?>
                        </label>
                    </div>
                <?php } ?>

                <?php if ($has_sub_task) { ?>
                    <div class="form-group">
                        <label for="copy_sub_tasks" class=" col-md-12">
                            <?php
                            echo form_checkbox("copy_sub_tasks", "1", false, "id='copy_sub_tasks' class='float-start mr15 form-check-input'");
                            ?>    
                            <?php echo app_lang('copy_sub_tasks'); ?>
                        </label>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <div class="modal-footer">
        <div id="link-of-new-view" class="hide">
            <?php
            echo modal_anchor(get_uri("projects/task_view"), "", array("data-modal-lg" => "1"));
            ?>
        </div>

        <?php if (!$model_info->id || $add_type == "multiple") { ?>
            <button class="btn btn-default upload-file-button float-start me-auto btn-sm round" type="button" style="color:#7988a2"><i data-feather="camera" class="icon-16"></i> <?php echo app_lang("upload_file"); ?></button>
        <?php } ?>

        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>

        <?php if ($add_type == "multiple") { ?>
            <button id="save-and-add-button" type="button" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save_and_add_more'); ?></button>
        <?php } else { ?>
            <?php if ($view_type !== "details") { ?>
                <button id="save-and-show-button" type="button" class="btn btn-info text-white"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save_and_show'); ?></button>
            <?php } ?>
            <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
        <?php } ?>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {

<?php if (!$model_info->id || $add_type == "multiple") { ?>
            var uploadUrl = "<?php echo get_uri('projects/upload_file'); ?>";
            var validationUri = "<?php echo get_uri('projects/validate_project_file'); ?>";

            var dropzone = attachDropzoneWithForm("#tasks-dropzone", uploadUrl, validationUri);
<?php } ?>
        //send data to show the task after save
        window.showAddNewModal = false;

        $("#save-and-show-button, #save-and-add-button").click(function () {
            window.showAddNewModal = true;
            $(this).trigger("submit");
        });

        var taskShowText = "<?php echo app_lang('task_info') ?>",
                multipleTaskAddText = "<?php echo app_lang('add_multiple_tasks') ?>",
                addType = "<?php echo $add_type; ?>";

        window.taskForm = $("#task-form").appForm({
            closeModalOnSuccess: false,
            onSuccess: function (result) {
                $("#task-table").appTable({newData: result.data, dataId: result.id});
                $("#reload-kanban-button:visible").trigger("click");

                $("#save_and_show_value").append(result.save_and_show_link);

                if (window.showAddNewModal) {
                    var $taskViewLink = $("#link-of-new-view").find("a");

                    if (addType === "multiple") {
                        //add multiple tasks
                        $taskViewLink.attr("data-action-url", "<?php echo get_uri("projects/task_modal_form"); ?>");
                        $taskViewLink.attr("data-title", multipleTaskAddText);
                        $taskViewLink.attr("data-post-last_id", result.id);
                        $taskViewLink.attr("data-post-project_id", "<?php echo $project_id; ?>");
                        $taskViewLink.attr("data-post-add_type", "multiple");
                    } else {
                        //save and show
                        $taskViewLink.attr("data-action-url", "<?php echo get_uri("projects/task_view"); ?>");
                        $taskViewLink.attr("data-title", taskShowText + " #" + result.id);
                        $taskViewLink.attr("data-post-id", result.id);
                    }

                    $taskViewLink.trigger("click");
                } else {
                    window.taskForm.closeModal();

                    if (window.refreshAfterAddTask) {
                        window.refreshAfterAddTask = false;
                        location.reload();
                    }
                }

                if (typeof window.reloadGantt === "function") {
                    window.reloadGantt(true);
                }
            },
            onAjaxSuccess: function (result) {
                if (!result.success && result.next_recurring_date_error) {
                    $("#next_recurring_date").val(result.next_recurring_date_value);
                    $("#next_recurring_date_container").removeClass("hide");

                    $("#task-form").data("validator").showErrors({
                        "next_recurring_date": result.next_recurring_date_error
                    });
                }
            }
        });
        $("#task-form .select2").select2();
        setTimeout(function () {
            $("#title").focus();
        }, 200);

        setDatePicker("#start_date");

        setDatePicker("#deadline", {
            endDate: "<?php echo $project_deadline; ?>"
        });

        $('[data-bs-toggle="tooltip"]').tooltip();

        //show/hide recurring fields
        $("#recurring").click(function () {
            if ($(this).is(":checked")) {
                $("#recurring_fields").removeClass("hide");
            } else {
                $("#recurring_fields").addClass("hide");
            }
        });

        setDatePicker("#next_recurring_date", {
            startDate: moment().add(1, 'days').format("YYYY-MM-DD") //set min date = tomorrow
        });

        $('#priority_id').select2({data: <?php echo json_encode($priorities_dropdown); ?>});
    });
</script>

<?php echo view("projects/tasks/get_related_data_of_project_script"); ?>