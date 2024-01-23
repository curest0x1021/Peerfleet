<?php echo form_open(get_uri("equipments/save"), array("id" => "equipment-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info ? $model_info->id : 0; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="name" class="<?php echo $label_column; ?>"><?php echo app_lang('name'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "name",
                        "name" => "name",
                        "value" => $model_info ? $model_info->name : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('name'),
                        "autofocuse" => true,
                        "maxlength" => 250,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="visual_inspection_month" class="<?php echo $label_column; ?>"><?php echo (app_lang('visual_inspection') . " (" . app_lang('months') . ")"); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "visual_inspection_month",
                        "name" => "visual_inspection_month",
                        "value" => $model_info ? $model_info->visual_inspection_month : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('months'),
                        "autofocuse" => true,
                        "maxlength" => 250,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="load_test_year" class="<?php echo $label_column; ?>"><?php echo app_lang('load_test') . " (" . app_lang('years') . ")"; ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "load_test_year",
                        "name" => "load_test_year",
                        "value" => $model_info ? $model_info->load_test_year : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('years'),
                        "autofocuse" => true,
                        "maxlength" => 250,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="wire_exchange_year" class="<?php echo $label_column; ?>"><?php echo app_lang('wire_exchange') . " (" . app_lang('years') . ")"; ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "wire_exchange_year",
                        "name" => "wire_exchange_year",
                        "value" => $model_info ? $model_info->wire_exchange_year : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('years'),
                        "autofocuse" => true,
                        "maxlength" => 250,
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
        $("#equipment-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
                $("#equipment-table").appTable({ reload: true });
                $("#wire-info-table").appTable({ reload: true });
            }
        });

        setTimeout(() => {
            $("#name").focus();
        }, 210);

    });
</script>