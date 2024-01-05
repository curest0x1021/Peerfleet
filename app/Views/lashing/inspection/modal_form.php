<?php echo form_open(get_uri("lashing/save_inspection"), array("id" => "inspection-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $lashing->client_id; ?>" />
        <input type="hidden" name="lashing_id" value="<?php echo $lashing->id; ?>" />
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group">
            <div  class="col-md-12 notepad-title">
                <strong><?php echo $lashing->name . "(" . $lashing->description . ")"; ?></strong>
            </div>
        </div>
        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("inspection_date"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "inspection_date",
                    "name" => "inspection_date",
                    "value" => $model_info->inspection_date ? $model_info->inspection_date : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('inspection_date'),
                    "autoComplete" => "off",
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("inspected_by"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "inspected_by",
                    "name" => "inspected_by",
                    "value" => $model_info->inspected_by ? $model_info->inspected_by : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('inspected_by'),
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("location"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "location",
                    "name" => "location",
                    "value" => $model_info->location ? $model_info->location : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('location'),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("quantity") . " " . app_lang("passed"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                    echo form_input(array(
                        "id" => "passed",
                        "name" => "passed",
                        "value" => $model_info->passed ? $model_info->passed : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('passed'),
                        "type" => "number",
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("remarks"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_textarea(array(
                    "id" => "remarks",
                    "name" => "remarks",
                    "value" => $model_info->remarks ? $model_info->remarks : "",
                    "placeholder" => app_lang('remarks'),
                    "class" => "form-control"
                ));
                ?>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        const forceRefresh = '<?php echo $force_refresh; ?>';

        $("#inspection-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 5000
                });

                setTimeout(() => {
                    window.location.reload();
                }, 500);

            }
        });

        setDatePicker("#inspection_date");
    });
</script>