<?php echo form_open(get_uri("tickets/save_new"), array("id" => "ticket-form", "class" => "general-form", "role" => "form")); ?>
<div id="new-ticket-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
            <!------------------------------------------>
            <div class="form-group">
                <div class="row">
                    <label for="client_id" class=" col-md-3"><?php echo "Manufacturer"; ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(
                            array(
                                "id" => "manufacturer_id",
                                "name" => "manufacturer_id",
                                "value" => $model_info->manufacturer ? $model_info->manufacturer : "",
                                "class" => "form-control",
                                "placeholder" => 'Manufacturer',
                                "autofocus" => true,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="equipment" class=" col-md-3"><?php echo "Equipment"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(
                            array(
                                "id" => "equipment",
                                "name" => "equipment",
                                "value" => $model_info->equipment ? $model_info->equipment : "",
                                "class" => "form-control",
                                "placeholder" => 'Equipment',
                                "autofocus" => true,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="serial_number" class=" col-md-3"><?php echo "Serial Number"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(
                            array(
                                "id" => "serial_number",
                                "name" => "serial_number",
                                "value" => $model_info->serial_number ? $model_info->serial_number : "",
                                "class" => "form-control",
                                "placeholder" => 'Serial Number',
                                "autofocus" => true,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="critical_disturbance" class=" col-md-3"><?php echo "Critical Disturbance"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        $critical_disturbances = [
                            [
                                "id" => 0,
                                "text" => "No"
                            ],
                            [
                                "id" => 1,
                                "text" => "Yes"
                            ],
                        ];
                        echo form_input(
                            array(
                                "id" => "critical_disturbance",
                                "name" => "critical_disturbance",
                                "value" => $model_info->critical_disturbance ? $model_info->critical_disturbance : "",
                                "class" => "form-control",
                                "placeholder" => 'Critical Disturbance',
                                "autofocus" => true,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="critical_equipment" class=" col-md-3"><?php echo "Critical Equipment"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        $critical_equipments = [
                            [
                                "id" => 0,
                                "text" => "No"
                            ],
                            [
                                "id" => 1,
                                "text" => "Yes"
                            ],
                        ];
                        echo form_input(
                            array(
                                "id" => "critical_equipment",
                                "name" => "critical_equipment",
                                "value" => $model_info->critical_equipment ? $model_info->critical_equipment : "",
                                "class" => "form-control",
                                "placeholder" => 'Critical Equipment',
                                "autofocus" => true,
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <!------------------------------------------>
            <!-- client can't be changed during editing -->






            <?php echo view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?>

            <?php echo view("includes/dropzone_preview"); ?>
        </div>
    </div>

    <div class="modal-footer">

        <!-- file can't be uploaded during editing -->
        <button class="btn btn-default upload-file-button float-start me-auto btn-sm round  <?php
        if ($model_info->id) {
            echo "hide";
        }
        ?>" type="button" style="color:#7988a2"><i data-feather='camera' class='icon-16'></i>
            <?php echo app_lang("upload_file"); ?></button>

        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x"
                class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span>
            <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>



<script type="text/javascript">
    $(document).ready(function () {
        $('#description').summernote();
        var uploadUrl = "<?php echo get_uri("tickets/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("tickets/validate_ticket_file"); ?>";
        var editMode = "<?php echo $model_info->id; ?>";

        var dropzone = attachDropzoneWithForm("#new-ticket-dropzone", uploadUrl, validationUrl);

        $("#ticket-form").appForm({
            onSuccess: function (result) {
                if (editMode) {

                    appAlert.success(result.message, {
                        duration: 10000
                    });

                    //don't reload whole page when it's the list view
                    if ($("#ticket-table").length) {
                        $("#ticket-table").appTable({
                            newData: result.data,
                            dataId: result.id
                        });
                    } else {
                        location.reload();
                    }
                } else {
                    $("#ticket-table").appTable({
                        newData: result.data,
                        dataId: result.id
                    });
                }

            }
        });
        setTimeout(function () {
            $("#title").focus();
        }, 200);
        $("#ticket-form .select2").select2();
    });
</script>