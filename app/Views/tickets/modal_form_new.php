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
                        echo form_dropdown("client_id", $clients_dropdown, array($model_info->client_id), "class='select2 validate-hidden' id='client_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="equipment" class=" col-md-3"><?php echo "Equipment"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "equipment",
                            "name" => "equipment",
                            "value" => $model_info->equipment?$model_info->equipment:"",
                            "class" => "form-control",
                            "placeholder" => 'Equipment',
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
                    <label for="serial_number" class=" col-md-3"><?php echo "Serial Number"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "serial_number",
                            "name" => "serial_number",
                            "value" => $model_info->serial_number?$model_info->serial_number:"",
                            "class" => "form-control",
                            "placeholder" => 'Serial Number',
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
                    <label for="critical_disturbance" class=" col-md-3"><?php echo "Critical Disturbance"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        $critical_disturbances=[
                            [
                                "id"=>0,
                                "text"=>"No"
                            ],
                            [
                                "id"=>1,
                                "text"=>"Yes"
                            ],
                        ];
                        echo form_input(array(
                            "id" => "critical_disturbance",
                            "name" => "critical_disturbance",
                            "value" => $model_info->critical_disturbance?$model_info->critical_disturbance:"",
                            "class" => "form-control",
                            "placeholder" => 'Critical Disturbance',
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
                    <label for="critical_equipment" class=" col-md-3"><?php echo "Critical Equipment"; ?></label>
                    <div class=" col-md-9">
                        <?php
                        $critical_equipments=[
                            [
                                "id"=>0,
                                "text"=>"No"
                            ],
                            [
                                "id"=>1,
                                "text"=>"Yes"
                            ],
                        ];
                        echo form_input(array(
                            "id" => "critical_equipment",
                            "name" => "critical_equipment",
                            "value" => $model_info->critical_equipment?$model_info->critical_equipment:"",
                            "class" => "form-control",
                            "placeholder" => 'Critical Equipment',
                            "autofocus" => true,
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
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
                                                                                            ?>" type="button" style="color:#7988a2"><i data-feather='camera' class='icon-16'></i> <?php echo app_lang("upload_file"); ?></button>

        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>



<script type="text/javascript">
    $(document).ready(function() {
        $('#description').summernote();
        var uploadUrl = "<?php echo get_uri("tickets/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("tickets/validate_ticket_file"); ?>";
        var editMode = "<?php echo $model_info->id; ?>";

        var dropzone = attachDropzoneWithForm("#new-ticket-dropzone", uploadUrl, validationUrl);

        $("#ticket-form").appForm({
            onSuccess: function(result) {
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
        setTimeout(function() {
            $("#title").focus();
        }, 200);
        $("#ticket-form .select2").select2();

        $("#ticket_labels").select2({
            multiple: true,
            data: <?php echo json_encode($label_suggestions); ?>
        });

        <?php if ($show_project_reference == "1") { ?>
            //load all projects of selected client
            $("#client_id").select2().on("change", function() {
                var client_id = $(this).val();
                if ($(this).val()) {
                    $('#project_id').select2("destroy");
                    $("#project_id").hide();
                    appLoader.show({
                        container: "#porject-dropdown-section",
                        zIndex: 1
                    });
                    $.ajax({
                        url: "<?php echo get_uri("tickets/get_project_suggestion") ?>" + "/" + client_id,
                        dataType: "json",
                        success: function(result) {
                            $("#project_id").show().val("");
                            $('#project_id').select2({
                                data: result
                            });
                            appLoader.hide();
                        }
                    });
                }
            });

            $('#project_id').select2({
                data: <?php echo json_encode($projects_suggestion); ?>
            });

        <?php } ?>

        //load all client contacts of selected client
        $("#client_id").select2().on("change", function() {
            var client_id = $(this).val();
            if ($(this).val()) {
                $('#requested_by_id').select2("destroy");
                $("#requested_by_id").hide();
                appLoader.show({
                    container: "#requested-by-dropdown-section",
                    zIndex: 1
                });
                $.ajax({
                    url: "<?php echo get_uri("tickets/get_client_contact_suggestion") ?>" + "/" + client_id,
                    dataType: "json",
                    success: function(result) {
                        $("#requested_by_id").show().val("");
                        $('#requested_by_id').select2({
                            data: result
                        });
                        appLoader.hide();
                    }
                });
            }
        });

        $('#requested_by_id').select2({
            data: <?php echo json_encode($requested_by_dropdown); ?>
        });

        $("#critical_disturbance").select2({
            data: <?php 
                echo (json_encode($critical_disturbances)); 
                ?>
        });

        $("#critical_equipment").select2({
            data: <?php 
                echo (json_encode($critical_equipments)); 
                ?>
        });

        if ("<?php echo $project_id; ?>") {
            $("#client_id").select2("readonly", true);
        }

    });
</script>