<?php echo form_open(get_uri("cranes/save_loadtest"), array("id" => "loadtest-form", "class" => "general-form", "role" => "form")); ?>
<div id="load-test-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
            <input type="hidden" name="id" value="<?php echo isset($model_info) ? $model_info->id : null; ?>" />

            <div class="form-group">
                <div class="row">
                    <label for="test_date" class="<?php echo $label_column; ?>"><?php echo app_lang('test_date'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_input(array(
                            "id" => "test_date",
                            "name" => "test_date",
                            "class" => "form-control",
                            "placeholder" => app_lang('test_date'),
                            "value" => isset($model_info) ? $model_info->test_date : "",
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
                    <label for="rope_id" class="<?php echo $label_column; ?>"><?php echo app_lang("wire"); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                            echo form_input(array(
                                "id" => "rope_id",
                                "name" => "rope_id",
                                "value" => isset($model_info) ? $model_info->rope : null,
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
        var uploadUrl = "<?php echo get_uri("cranes/upload_file"); ?>";
        var validationUri = "<?php echo get_uri("cranes/validate_file"); ?>";
        var client_id = '<?php echo $client_id; ?>';

        var dropzone = attachDropzoneWithForm("#load-test-dropzone", uploadUrl, validationUri);

        $("#loadtest-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
                $("#crane-loadtest-table").appTable({ newData: result.data, dataId: result.id });
            }
        });

        setDatePicker("#test_date");
        $("#crane").select2().on("change", function (e) {
            loadRopes(client_id, e.val);
        });

        var crane = '<?php echo isset($model_info) ? $model_info->crane : null; ?>';
        var rope_id = '<?php echo isset($model_info) ? $model_info->rope_id : null; ?>';
        if (crane && rope_id) {
            loadRopes(client_id, crane, rope_id);
        }
    });

    function loadRopes(client_id, crane, rope_id = 0) {
        $("#rope_id").select2("destroy");
        const url = '<?php echo_uri("cranes/get_ropes_dropdown") ?>';
        $.post(url, { client_id: client_id, crane: crane },
            function(data, status) {
                if (status == "success") {
                    $("#rope_id").val("");
                    $("#rope_id").select2({ data: JSON.parse(data) });
                    if (rope_id > 0) {
                        console.log(rope_id)
                        $("#rope_id").select2("val", rope_id );
                    }
                }
            });
    }
</script>