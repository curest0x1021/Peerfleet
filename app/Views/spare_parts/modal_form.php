<?php echo form_open(get_uri("spare_parts/save"), array("id" => "item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

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
                <label for="manufacturer_id" class="<?php echo $label_column; ?>"><?php echo app_lang('manufacturer'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_dropdown("manufacturer_id", $manufacturers_dropdown, array($model_info->manufacturer_id), "class='select2 validate-hidden' id='manufacturer_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="applicable_equip_id" class="<?php echo $label_column; ?>"><?php echo app_lang('applicable_equipment'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_dropdown("applicable_equip_id", $applicable_equipments_dropdown, array($model_info->applicable_equip_id), "class='select2 validate-hidden' id='applicable_equip_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="ship_equip_id" class="<?php echo $label_column; ?>"><?php echo app_lang('ship_equipment'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_dropdown("ship_equip_id", $ship_equipments_dropdown, array($model_info->ship_equip_id), "class='select2 validate-hidden' id='ship_equip_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="unit_id" class="<?php echo $label_column; ?>"><?php echo app_lang('unit'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_dropdown("unit_id", $units_dropdown, array($model_info->unit_id), "class='select2 validate-hidden' id='unit_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="part_number" class="<?php echo $label_column; ?>"><?php echo app_lang('part_number'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "part_number",
                        "name" => "part_number",
                        "value" => $model_info->part_number ? $model_info->part_number : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('part_number'),
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
                <label for="part_description" class="<?php echo $label_column; ?>"><?php echo app_lang('part_description'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_textarea(array(
                        "id" => "part_description",
                        "name" => "part_description",
                        "value" => $model_info->part_description ? $model_info->part_description : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('part_description') . "...",
                        "data-rich-text-editor" => true,
                        "maxlength" => 200,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="article_number" class="<?php echo $label_column; ?>"><?php echo app_lang('article_number'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "article_number",
                        "name" => "article_number",
                        "value" => $model_info->article_number ? $model_info->article_number : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('article_number'),
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
                <label for="drawing_number" class="<?php echo $label_column; ?>"><?php echo app_lang('drawing_number'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "drawing_number",
                        "name" => "drawing_number",
                        "value" => $model_info->drawing_number ? $model_info->drawing_number : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('drawing_number'),
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
                <label for="hs_code" class="<?php echo $label_column; ?>"><?php echo app_lang('hs_code'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "hs_code",
                        "name" => "hs_code",
                        "value" => $model_info->hs_code ? $model_info->hs_code : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('hs_code'),
                        "maxlength" => 30,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group ">
            <div class="row">
                <label for="is_critical" class="<?php echo $label_column; ?>"><?php echo app_lang('mark_as_critical'); ?></label>

                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_checkbox("is_critical", "1", $model_info->is_critical, "id='is_critical' class='form-check-input mt-2'");
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
        $("#item-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
                $("#item-table").appTable({newData: result.data, dataId: result.id});;
            }
        });

        setTimeout(() => {
            $("#name").focus();
        }, 210);

        $('.select2').select2();

    });
</script>