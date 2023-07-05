<?php echo form_open(get_uri("wires/save_info"), array("id" => "wire-info-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
        <input type="hidden" name="wire_id" value="<?php echo $wire_id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="diameter" class="<?php echo $label_column; ?>"><?php echo app_lang('diameter'); ?> in mm</label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "diameter",
                        "name" => "diameter",
                        "type" => "number",
                        "value" => $model_info->diameter ? $model_info->diameter : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('diameter'),
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
                <label for="length" class="<?php echo $label_column; ?>"><?php echo app_lang('length'); ?> in m</label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "length",
                        "name" => "length",
                        "type" => "number",
                        "value" => $model_info->length ? $model_info->length : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('length'),
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
                <label for="swl" class="<?php echo $label_column; ?>"><?php echo app_lang('swl'); ?> in mt</label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "swl",
                        "name" => "swl",
                        "type" => "number",
                        "value" => $model_info->swl ? $model_info->swl : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('swl'),
                        "autofocus" => true,
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
        $("#wire-info-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
                $("#wire-info-table").appTable({ reload: true });
            }
        });

    });
</script>