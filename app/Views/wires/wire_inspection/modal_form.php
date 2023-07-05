<?php echo form_open(get_uri("wires/save_wire_inspection"), array("id" => "inspection-form", "class" => "general-form", "role" => "form")); ?>
<div id="wire-inspection-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
            <input type="hidden" name="id" value="<?php echo isset($model_info) ? $model_info->id : null; ?>" />

            <div class="form-group">
                <div class="row">
                    <label for="inspection_date" class="<?php echo $label_column; ?>"><?php echo app_lang('inspection_date'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_input(array(
                            "id" => "inspection_date",
                            "name" => "inspection_date",
                            "class" => "form-control",
                            "placeholder" => app_lang('inspection_date'),
                            "value" => isset($model_info) ? $model_info->inspection_date : "",
                            "autocomplete" => "off",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="crane" class="<?php echo $label_column; ?>"><?php echo app_lang('crane'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_dropdown("crane", $cranes_dropdown, isset($model_info) ? $model_info->crane : "", "class='select2' id='crane' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="wire_id" class="<?php echo $label_column; ?>"><?php echo app_lang("wire"); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                            echo form_input(array(
                                "id" => "wire_id",
                                "name" => "wire_id",
                                "value" => isset($model_info) ? $model_info->wire : null,
                                "class" => "form-control",
                                "placeholder" => app_lang("wire"),
                                "data-rule-required" => true,
                                "data-msg-required" => app_lang("field_required"),
                            ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="result" class="<?php echo $label_column; ?>"><?php echo app_lang('result'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_textarea(array(
                            "id" => "result",
                            "name" => "result",
                            "value" => isset($model_info) ? $model_info->result : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('result_loadtest') . "...",
                            "data-rich-text-editor" => true
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="location" class="<?php echo $label_column; ?>"><?php echo app_lang('location'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_input(array(
                            "id" => "location",
                            "name" => "location",
                            "value" => isset($model_info) ? $model_info->location : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('location'),
                            "maxlength" => 255,
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="next_suggested_inspection" class="<?php echo $label_column; ?>"><?php echo app_lang('next_suggested_inspection'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_input(array(
                            "id" => "next_suggested_inspection",
                            "name" => "next_suggested_inspection",
                            "class" => "form-control",
                            "placeholder" => app_lang('next_suggested_inspection'),
                            "value" => isset($model_info) ? $model_info->next_suggested_inspection : "",
                            "autocomplete" => "off",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="<?php echo $label_column; ?>"></label>
                    <div class="<?php echo $field_column; ?> row pr-0">
                        <?php
                        echo view("includes/file_list", array("files" => isset($model_info) ? $model_info->files : ''));
                        ?>
                    </div>
                </div>
            </div>

            <?php echo view("includes/dropzone_preview"); ?>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-default upload-file-button float-start btn-sm round me-auto" type="button" style="color:#7988a2"><i data-feather="file" class="icon-16"></i> <?php echo app_lang("upload_file"); ?></button>
        <button type="button" class="btn btn-default cancel-upload" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary start-upload"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var uploadUrl = "<?php echo get_uri("wires/upload_file"); ?>";
        var validationUri = "<?php echo get_uri("wires/validate_file"); ?>";
        var client_id = '<?php echo $client_id; ?>';

        var dropzone = attachDropzoneWithForm("#wire-inspection-dropzone", uploadUrl, validationUri);

        $("#inspection-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
                $("#wire-inspection-table").appTable({ newData: result.data, dataId: result.id });
            }
        });

        setDatePicker("#inspection_date");
        setDatePicker("#next_suggested_inspection");
        $("#crane").select2().on("change", function (e) {
            loadWires(client_id, e.val);
        });

        var crane = '<?php echo isset($model_info) ? $model_info->crane : null; ?>';
        var wire_id = '<?php echo isset($model_info) ? $model_info->wire_id : null; ?>';
        if (crane && wire_id) {
            loadWires(client_id, crane, wire_id);
        }
    });

    function loadWires(client_id, crane, wire_id = 0) {
        $("#wire_id").select2("destroy");
        const url = '<?php echo_uri("wires/get_wires_dropdown") ?>';
        $.post(url, { client_id: client_id, crane: crane },
            function(data, status) {
                if (status == "success") {
                    $("#wire_id").val("");
                    $("#wire_id").select2({ data: JSON.parse(data) });
                    if (wire_id > 0) {
                        console.log(wire_id)
                        $("#wire_id").select2("val", wire_id );
                    }
                }
            });
    }
</script>