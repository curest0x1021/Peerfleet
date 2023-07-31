<?php echo form_open(get_uri("wires/save_loadtest"), array("id" => "loadtest-form", "class" => "general-form", "role" => "form")); ?>
<div id="load-test-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <input type="hidden" name="wire_id" value="<?php echo $wire->id; ?>" />
            <input type="hidden" name="client_id" value="<?php echo $wire->client_id; ?>" />
            <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

            <div class="form-group notepad-title">
                <strong><?php echo $wire->crane . " - " . $wire->wire ; ?></strong>
            </div>
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
                            "value" => $model_info->test_date,
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
                    <label for="location" class="<?php echo $label_column; ?>"><?php echo app_lang('location'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_input(array(
                            "id" => "location",
                            "name" => "location",
                            "value" => $model_info->location,
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

            <div class="form-group row">
                <div class="<?php echo $label_column; ?>">
                    <span><?php echo app_lang("passed"); ?>:</span>
                </div>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_checkbox("passed", "1", $model_info->passed ? $model_info->passed == "1" : false, "id='passed' class='form-check-input mt-2'");
                    ?>
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
                            "value" => $model_info->result,
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
                    <label class="<?php echo $label_column; ?>"></label>
                    <div class="<?php echo $field_column; ?> row pr-0">
                        <?php
                        echo view("includes/file_list", array("files" => $model_info->files));
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

        var dropzone = attachDropzoneWithForm("#load-test-dropzone", uploadUrl, validationUri);

        $("#loadtest-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 5000
                });
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        });

        setDatePicker("#test_date");
    });
</script>