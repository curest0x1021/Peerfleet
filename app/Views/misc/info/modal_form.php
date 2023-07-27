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
                                <div><?php echo app_lang("load_test_interval"); ?></div>
                                <strong>5 Years</strong>
                            </div>
                            <div class="mb15">
                                <div><?php echo app_lang("visual_inspection_interval"); ?></div>
                                <strong>12 Months</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php echo form_open(get_uri("misc/save_info"), array("id" => "misc-form", "class" => "general-form", "role" => "form")); ?>
                    <div class="clearfix">
                        <div class="container-fluid">
                            <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
                            <input type="hidden" name="main_id" value="<?php echo $main_info->id; ?>" />
                            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("internal_id"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "internal_id",
                                        "name" => "internal_id",
                                        "value" => $model_info->internal_id ? $model_info->internal_id : $next_internal_id,
                                        "class" => "form-control",
                                        "placeholder" => app_lang('internal_id'),
                                        "readonly" => true,
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("item_description"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "item_description",
                                        "name" => "item_description",
                                        "value" => $main_info->item_description,
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
                                    <span><?php echo app_lang("icc"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_dropdown("icc_id", $icc_dropdown, array($model_info->icc_id), "class='select2 validate-hidden' id='icc_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("certificate_number"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "certificate_number",
                                        "name" => "certificate_number",
                                        "value" => $model_info->certificate_number ? $model_info->certificate_number : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('certificate_number'),
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("certificate_type"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_dropdown("certificate_type_id", $certificate_types_dropdown, array($model_info->certificate_type_id), "class='select2 validate-hidden' id='certificate_type_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("tag_marking"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "tag_marking",
                                        "name" => "tag_marking",
                                        "value" => $model_info->tag_marking ? $model_info->tag_marking : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('tag_marking'),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("manufacturer"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_dropdown("manufacturer_id", $manufacturers_dropdown, array($model_info->manufacturer_id), "class='select2 validate-hidden' id='manufacturer_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
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
                                    <span><?php echo app_lang("lifts"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "lifts",
                                        "name" => "lifts",
                                        "value" => $model_info->lifts ? $model_info->lifts : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('lifts'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("date_of_discharged"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "date_of_discharged",
                                        "name" => "date_of_discharged",
                                        "value" => $model_info->date_of_discharged ? $model_info->date_of_discharged : "",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('date_of_discharged')
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
        $('#misc-form').bind('submit', function () {
            $('#type_id').prop('disabled', false);
        });

        $("#misc-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 10000
                });
                $("#misc-table").appTable({
                    newData: result.data,
                    dataId: result.id
                });
            }
        });

        $(".select2").select2();
        setDatePicker("#supplied_date");
        setDatePicker("#date_of_discharged");
    });
</script>