<div id="page-content" class="page-wrapper pb0 clearfix task-view-modal-body task-preview">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 order-lg-last">
                    <div class="clearfix">
                        <div class="container-fluid">
                            <div class="mb15">
                                <strong><?php echo app_lang("reminders"); ?></strong>
                            </div>
                            <div class="mb15">
                                <div><?php echo app_lang("visual_inspection_interval"); ?></div>
                                <strong>12 Months</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php echo form_open(get_uri("lashing/save_info"), array("id" => "lashing-form", "class" => "general-form", "role" => "form")); ?>
                    <div class="clearfix">
                        <div class="container-fluid">
                            <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
                            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>No.:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "no",
                                        "name" => "no",
                                        "value" => $model_info->no ? $model_info->no : $next_no,
                                        "class" => "form-control",
                                        "readonly" => true,
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("category"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_dropdown("category_id", $category_dropdown, array($model_info->category_id), "class='select2 validate-hidden' id='category_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("name"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "name",
                                        "name" => "name",
                                        "value" => $model_info->name ? $model_info->name : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('name'),
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("description"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "description",
                                        "name" => "description",
                                        "value" => $model_info->description ? $model_info->description : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('description'),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>Qty:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "qty",
                                        "name" => "qty",
                                        "value" => $model_info->qty ? $model_info->qty : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('qty'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>Length [mm]:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "length",
                                        "name" => "length",
                                        "value" => $model_info->length ? $model_info->length : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('length'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>Width [mm]:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "width",
                                        "name" => "width",
                                        "value" => $model_info->width ? $model_info->width : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('width'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>Height [mm]:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "height",
                                        "name" => "height",
                                        "value" => $model_info->height ? $model_info->height : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('height'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>MSL [kN]:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "msl",
                                        "name" => "msl",
                                        "value" => $model_info->msl ? $model_info->msl : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('msl'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>BL [kN]:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "bl",
                                        "name" => "bl",
                                        "value" => $model_info->bl ? $model_info->bl : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('bl'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("supplied_date"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "supplied_date",
                                        "name" => "supplied_date",
                                        "value" => $model_info->supplied_date ? $model_info->supplied_date : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('supplied_date'),
                                        "autocomplete" => "off",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("supplied_place"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "supplied_place",
                                        "name" => "supplied_place",
                                        "value" => $model_info->supplied_place ? $model_info->supplied_place : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('supplied_place'),
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("property"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "property",
                                        "name" => "property",
                                        "value" => $model_info->property ? $model_info->property : "",
                                        "class" => "form-control",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
                            <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        const clientId = <?php echo $client_id; ?>;
        const lashingId = '<?php echo $model_info->id; ?>';

        $("#lashing-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 10000
                });
                $("#lashing-table").appTable({
                    newData: result.data,
                    dataId: result.id
                });
            }
        });

        $(".select2").select2();
        setDatePicker("#supplied_date");
        $("#property").select2({
            data: [{"id": "SAL", "text": "SAL"}, {"id": "Ship", "text": "Ship"}]
        });
    });
</script>