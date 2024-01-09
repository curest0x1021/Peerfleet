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
                    <?php echo form_open(get_uri("grommets/save_main"), array("id" => "main-form", "class" => "general-form", "role" => "form")); ?>
                    <div class="clearfix">
                        <div class="container-fluid">
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
                                        "value" => "G-",
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
                                    <span><?php echo app_lang("item_description"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "item_description",
                                        "name" => "item_description",
                                        "value" => "Grommet-",
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
                                    <span>WLL (TS):</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "wll",
                                        "name" => "wll",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('wll'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>WL (m):</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "wl",
                                        "name" => "wl",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('wl'),
                                        "type" => "number",
                                        "step" => 0.1,
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span><?php echo app_lang("type"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_dropdown("type_id", $types_dropdown, array(), "class='select2 validate-hidden' id='type_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>Dia (mm):</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "dia",
                                        "name" => "dia",
                                        "class" => "form-control",
                                        "placeholder" => app_lang('dia'),
                                        "type" => "number",
                                        "data-rule-required" => true,
                                        "data-msg-required" => app_lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="<?php echo $label_column; ?>">
                                    <span>BL (kN):</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_input(array(
                                        "id" => "bl",
                                        "name" => "bl",
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
                                    <span><?php echo app_lang("icc"); ?>:</span>
                                </div>
                                <div class="<?php echo $field_column; ?>">
                                    <?php
                                    echo form_dropdown("icc_id", $icc_dropdown, array(), "class='select2 validate-hidden' id='icc_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
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
                                    echo form_dropdown("certificate_type_id", $certificate_types_dropdown, array(), "class='select2 validate-hidden' id='certificate_type_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
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
                                    echo form_dropdown("manufacturer_id", $manufacturers_dropdown, array(), "class='select2 validate-hidden' id='manufacturer_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
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
        const clientId = <?php echo $client_id; ?>;

        $("#main-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 10000
                });
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        });

        $(".select2").select2();
        setDatePicker("#supplied_date");
        setDatePicker("#date_of_discharged");

        $("#wll").on("input", (e) => {
            generateItemDescription();
            generateInternalId();
        });

        $("#wl").on("input", (e) => {
            generateItemDescription();
            generateInternalId();
        });

        function generateItemDescription() {
            const wll = $("#wll").val();
            var wl = $("#wl").val();
            $("#item_description").val(`Grommet-${wll} Ts-${wl}m`);
        }

        function generateInternalId() {
            const wll = $("#wll").val();
            var wl = $("#wl").val();
            if (clientId && wll && wl) {
                $.ajax({
                    url: "<?php echo get_uri('grommets/get_internal_id') ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {client_id: clientId, wll: wll, wl: wl},
                    success: function (result) {
                        const { internal_id } = result;
                        $("#internal_id").val(internal_id);
                    }
                });
            }
        }
    });
</script>