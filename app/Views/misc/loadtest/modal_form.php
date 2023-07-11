<?php echo form_open(get_uri("misc/save_loadtest"), array("id" => "loadtest-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $misc->client_id; ?>" />
        <input type="hidden" name="misc_id" value="<?php echo $misc->id; ?>" />
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group">
            <div  class="col-md-12 notepad-title">
                <strong><?php echo $misc->internal_id; ?></strong>
            </div>
        </div>
        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("test_date"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "test_date",
                    "name" => "test_date",
                    "value" => $model_info->test_date ? $model_info->test_date : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('test_date'),
                    "autoComplete" => "off",
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("tested_by"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "tested_by",
                    "name" => "tested_by",
                    "value" => $model_info->tested_by ? $model_info->tested_by : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('tested_by'),
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
                <span><?php echo app_lang("passed"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_checkbox("passed", "1", $model_info->passed ? $model_info->passed == "1" : false, "id='passed' class='form-check-input mt-2'");
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
        console.log(forceRefresh);
        $("#loadtest-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 5000
                });
                if (forceRefresh) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    $("#loadtest-detail-table").appTable({newData: result.data, dataId: result.id});;
                }
            }
        });

        setDatePicker("#test_date");
    });
</script>