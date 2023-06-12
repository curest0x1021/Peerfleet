<?php echo form_open(get_uri("cranes/save_loadtest"), array("id" => "loadtest-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

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
                        "value" => $model_info->test_date ? $model_info->test_date : "",
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
                <label for="result" class="<?php echo $label_column; ?>"><?php echo app_lang('result'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_textarea(array(
                        "id" => "result",
                        "name" => "result",
                        "value" => $model_info->result ? $model_info->result : "",
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
                        "value" => $model_info->location ? $model_info->location : "",
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
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default cancel-upload" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary start-upload"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#loadtest-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
                $("#crane-loadtest-table").appTable({ reload: true });
            }
        });

        setDatePicker("#test_date");

    });
</script>