<?php echo form_open(get_uri("grommets/save_loadtest"), array("id" => "loadtest-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $grommet->client_id; ?>" />
        <input type="hidden" name="grommet_id" value="<?php echo $grommet->id; ?>" />
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group">
            <div  class="col-md-12 notepad-title">
                <strong><?php echo $grommet->internal_id; ?></strong>
            </div>
        </div>
        <?php if ($allow_initial_test) { ?>
            <div class="form-group">
                <div class="row">
                    <label for="initial_test" class="<?php echo $label_column; ?>"><?php echo app_lang('initial_test'); ?></label>
                    <div class="<?php echo $field_column; ?>">
                        <?php
                        echo form_checkbox(
                            "initial_test", "1", $model_info->initial_test, "id='initial_test' class='form-check-input'"
                        );
                        ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <input type="hidden" name="initial_test" value="0" />
        <?php } ?>
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

        $('#loadtest-form').bind('submit', function () {
            $('#passed').prop('disabled', false);
            $('#remarks').prop('disabled', false);
        });

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

        $("#initial_test").change(function() {
            if (this.checked) {
                $("#passed").prop('checked', true);
                $("#passed").prop('disabled', true);
                $("#remarks").prop('disabled', true);
            } else {
                $("#passed").prop('checked', false);
                $("#passed").prop('disabled', false);
                $("#remarks").prop('disabled', false);
            }
        });
    });
</script>