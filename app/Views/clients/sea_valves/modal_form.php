<?php echo form_open(get_uri("clients/save_sea_valve"), array("id" => "sea-valve-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="name" class="<?php echo $label_column; ?>"><?php echo app_lang('name'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "name",
                        "name" => "name",
                        "value" => $model_info->name ? $model_info->name : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('name'),
                        "autofocus" => true,
                        "maxlength" => 30,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="description" class="<?php echo $label_column; ?>"><?php echo app_lang('description'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_textarea(array(
                        "id" => "description",
                        "name" => "description",
                        "value" => $model_info->description ? $model_info->description : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('description') . "...",
                        "data-rich-text-editor" => true
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="norm" class="<?php echo $label_column; ?>"><?php echo app_lang('norm'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "norm",
                        "name" => "norm",
                        "value" => $model_info->norm ? $model_info->norm : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('norm'),
                        "maxlength" => 20,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="diameter_nominal" class="<?php echo $label_column; ?>"><?php echo app_lang('diameter_nominal'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "diameter_nominal",
                        "name" => "diameter_nominal",
                        "value" => $model_info->diameter_nominal ? $model_info->diameter_nominal : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('diameter_nominal'),
                        "maxlength" => 20,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="pressure_rating" class="<?php echo $label_column; ?>"><?php echo app_lang('pressure_rating'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "pressure_rating",
                        "name" => "pressure_rating",
                        "value" => $model_info->pressure_rating ? $model_info->pressure_rating : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('pressure_rating'),
                        "maxlength" => 20,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="length" class="<?php echo $label_column; ?>"><?php echo app_lang('length'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "length",
                        "name" => "length",
                        "value" => $model_info->length ? $model_info->length : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('length'),
                        "maxlength" => 20,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="height" class="<?php echo $label_column; ?>"><?php echo app_lang('height'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "height",
                        "name" => "height",
                        "value" => $model_info->height ? $model_info->height : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('height'),
                        "maxlength" => 20,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="diameter" class="<?php echo $label_column; ?>"><?php echo app_lang('diameter'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "diameter",
                        "name" => "diameter",
                        "value" => $model_info->diameter ? $model_info->diameter : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('diameter'),
                        "maxlength" => 20,
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
        $("#sea-valve-form").appForm({
            onSuccess: function(result) {
                $("#sea-valve-table").appTable({newData: result.data, dataId: result.id});;
            }
        });

    });
</script>