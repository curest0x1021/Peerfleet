<?php echo form_open(get_uri("projects/save"), array("id" => "project-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="estimate_id" value="<?php echo $model_info->estimate_id; ?>" />
        <input type="hidden" name="order_id" value="<?php echo $model_info->order_id; ?>" />
        <div class="form-group">
            <div class="row">
                <label for="title" class=" col-md-3"><?php echo app_lang('title'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "title",
                        "name" => "title",
                        "value" => $model_info->title,
                        "class" => "form-control",
                        "placeholder" => app_lang('title'),
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div> 
            </div>
        </div>

        <?php if ($client_id || $login_user->user_type == "client") { ?>
            <input type="hidden" name="project_type" value="client_project" />
        <?php } else { ?>
            <div class="form-group">
                <div class="row">
                    <label for="project_type" class=" col-md-3">Project category</label>
                    <div class=" col-md-9">
                        <?php
                        $category_dropdown = array(
                            array("id"=>"General & Docking","text"=>"General & Docking"),
                            array("id"=>"Hull","text"=>"Hull"),
                            array("id"=>"Equipment for Cargo","text"=>"Equipment for Cargo"),
                            array("id"=>"Ship Equipment","text"=>"Ship Equipment"),
                            array("id"=>"Safety & Crew Equipment","text"=>"Safety & Crew Equipment"),
                            array("id"=>"Machinery Main Components","text"=>"Machinery Main Components"),
                            array("id"=>"Systems machinery main components","text"=>"Systems machinery main components"),
                            array("id"=>"Common systems","text"=>"Common systems"),
                            array("id"=>"Others","text"=>"Others"),
                        );
                        echo form_input(array(
                            "id" => "category_input",
                            "name" => "category",
                            "value" => "",
                            "class" => "form-control",
                            "placeholder" => app_lang('category'),
                            "data-rule-required" => true,
                            "style"=>"border:1px solid lightgray;",
                            "data-msg-required" => app_lang("field_required"),
                            "autocomplete" => "off"
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="project_type" class=" col-md-3"><?php echo app_lang('project_type'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_dropdown("project_type", array(
                            "client_project" => "Vessel project",
                            "internal_project" => app_lang("internal_project"),
                            // "client_project" => app_lang("client_project"),
                            // "internal_project" => app_lang("internal_project"),
                                ), array($model_info->project_type ? $model_info->project_type : "client_project"), "class='select2 validate-hidden' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "' id='project-type-dropdown'");
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($client_id) { ?>
            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
        <?php } else if ($login_user->user_type == "client" || $hide_clients_dropdown) { ?>
            <input type="hidden" name="client_id" value="<?php echo $model_info->client_id; ?>" />
        <?php } else { ?>
            <div class="form-group <?php echo $model_info->project_type === "internal_project" ? 'hide' : ''; ?>" id="clients-dropdown">
                <div class="row">
                    <label for="client_id" class=" col-md-3"><?php echo app_lang('client'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_dropdown("client_id", $clients_dropdown, array($model_info->client_id), "class='select2 validate-hidden' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="form-group">
            <div class="row">
                <label for="description" class=" col-md-3"><?php echo app_lang('description'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "description",
                        "name" => "description",
                        "value" => process_images_from_content($model_info->description, false),
                        "class" => "form-control",
                        "placeholder" => app_lang('description'),
                        "style" => "height:150px;",
                        "data-rich-text-editor" => true
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="start_date" class=" col-md-3"><?php echo app_lang('start_date'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "start_date",
                        "name" => "start_date",
                        "value" => is_date_exists($model_info->start_date) ? $model_info->start_date : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('start_date'),
                        "autocomplete" => "off"
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="deadline" class=" col-md-3"><?php echo app_lang('deadline'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "deadline",
                        "name" => "deadline",
                        "value" => is_date_exists($model_info->deadline) ? $model_info->deadline : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('deadline'),
                        "autocomplete" => "off"
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="price" class=" col-md-3"><?php echo app_lang('price'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "price",
                        "name" => "price",
                        "value" => $model_info->price ? to_decimal_format($model_info->price) : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('price')
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="project_labels" class=" col-md-3"><?php echo app_lang('labels'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "project_labels",
                        "name" => "labels",
                        "value" => $model_info->labels,
                        "class" => "form-control",
                        "placeholder" => app_lang('labels')
                    ));
                    ?>
                </div>
            </div>
        </div>

        <?php if ($model_info->id) { ?>
            <div class="form-group">
                <div class="row">
                    <label for="status_id" class=" col-md-3"><?php echo app_lang('status'); ?></label>
                    <div class="col-md-9">
                        <?php
                        foreach ($statuses as $status) {
                            $project_status[$status->id] = $status->key_name ? app_lang($status->key_name) : $status->title;
                        }

                        echo form_dropdown("status_id", $project_status, array($model_info->status_id), "class='select2'");
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php echo view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?> 
        <div class="form-group">
            <div class="row">
                <label for="project_currency" class=" col-md-3">Project currency</label>
                <div class=" col-md-9">
                    <?php
                    $currency_dropdown=array(
                        array("id"=>"AUD","text"=>"AUD"),
                        array("id"=>"GBP","text"=>"GBP"),
                        array("id"=>"EUR","text"=>"EUR"),
                        array("id"=>"JPY","text"=>"JPY"),
                        array("id"=>"CHF","text"=>"CHF"),
                        array("id"=>"USD","text"=>"USD"),
                        array("id"=>"AFN","text"=>"AFN"),
                        array("id"=>"ALL","text"=>"ALL"),
                        array("id"=>"DZD","text"=>"DZD"),
                        array("id"=>"AOA","text"=>"AOA"),
                        array("id"=>"ARS","text"=>"ARS"),
                        array("id"=>"AMD","text"=>"AMD"),
                        array("id"=>"AWG","text"=>"AWG"),
                        array("id"=>"AUD","text"=>"AUD"),
                        array("id"=>"ATS (EURO)","text"=>"ATS (EURO)"),
                        array("id"=>"BEF (EURO)","text"=>"BEF (EURO)"),
                        array("id"=>"AZN","text"=>"AZN"),
                        array("id"=>"BSD","text"=>"BSD"),
                        array("id"=>"BHD","text"=>"BHD"),
                        array("id"=>"BDT","text"=>"BDT"),
                        array("id"=>"BBD","text"=>"BBD"),
                        array("id"=>"BYR","text"=>"BYR"),
                        array("id"=>"BZD","text"=>"BZD"),
                        array("id"=>"BMD","text"=>"BMD"),
                        array("id"=>"BTN","text"=>"BTN"),
                        array("id"=>"BOB","text"=>"BOB"),
                        array("id"=>"BAM","text"=>"BAM"),
                        array("id"=>"BWP","text"=>"BWP"),
                        array("id"=>"BRL","text"=>"BRL"),
                        array("id"=>"GBP","text"=>"GBP"),
                        array("id"=>"BND","text"=>"BND"),
                        array("id"=>"BGN","text"=>"BGN"),
                        array("id"=>"BIF","text"=>"BIF"),
                        array("id"=>"XOF","text"=>"XOF"),
                        array("id"=>"XAF","text"=>"XAF"),
                        array("id"=>"XPF","text"=>"XPF"),
                        array("id"=>"KHR","text"=>"KHR"),
                        array("id"=>"CAD","text"=>"CAD"),
                        array("id"=>"CVE","text"=>"CVE"),
                        array("id"=>"KYD","text"=>"KYD"),
                        array("id"=>"CLP","text"=>"CLP"),
                        array("id"=>"CNY","text"=>"CNY"),
                        array("id"=>"COP","text"=>"COP"),
                        array("id"=>"KMF","text"=>"KMF"),
                        array("id"=>"CDF","text"=>"CDF"),
                        array("id"=>"CRC","text"=>"CRC"),
                        array("id"=>"HRK","text"=>"HRK"),
                        array("id"=>"CUC","text"=>"CUC"),
                        array("id"=>"CUP","text"=>"CUP"),
                        array("id"=>"CYP (EURO)","text"=>"CYP (EURO)"),
                        array("id"=>"CZK","text"=>"CZK"),
                        array("id"=>"DKK","text"=>"DKK"),
                        array("id"=>"DJF","text"=>"DJF"),
                        array("id"=>"DOP","text"=>"DOP"),
                        array("id"=>"XCD","text"=>"XCD"),
                        array("id"=>"EGP","text"=>"EGP"),
                        array("id"=>"SVC","text"=>"SVC"),
                        array("id"=>"EEK (EURO)","text"=>"EEK (EURO)"),
                        array("id"=>"ETB","text"=>"ETB"),
                        array("id"=>"EUR","text"=>"EUR"),
                        array("id"=>"FKP","text"=>"FKP"),
                        array("id"=>"FIM (EURO)","text"=>"FIM (EURO)"),
                        array("id"=>"FJD","text"=>"FJD"),
                        array("id"=>"GMD","text"=>"GMD"),
                        array("id"=>"GEL","text"=>"GEL"),
                        array("id"=>"DMK (EURO)","text"=>"DMK (EURO)"),
                        array("id"=>"GHS","text"=>"GHS"),
                        array("id"=>"GIP","text"=>"GIP"),
                        array("id"=>"GRD (EURO)","text"=>"GRD (EURO)"),
                        array("id"=>"GTQ","text"=>"GTQ"),
                        array("id"=>"GNF","text"=>"GNF"),
                        array("id"=>"GYD","text"=>"GYD"),
                        array("id"=>"HTG","text"=>"HTG"),
                        array("id"=>"HNL","text"=>"HNL"),
                        array("id"=>"HKD","text"=>"HKD"),
                        array("id"=>"HUF","text"=>"HUF"),
                        array("id"=>"ISK","text"=>"ISK"),
                        array("id"=>"INR","text"=>"INR"),
                        array("id"=>"IDR","text"=>"IDR"),
                        array("id"=>"IRR","text"=>"IRR"),
                        array("id"=>"IQD","text"=>"IQD"),
                        array("id"=>"IED (EURO)","text"=>"IED (EURO)"),
                        array("id"=>"ILS","text"=>"ILS"),
                        array("id"=>"ITL (EURO)","text"=>"ITL (EURO)"),
                        array("id"=>"JMD","text"=>"JMD"),
                        array("id"=>"JPY","text"=>"JPY"),
                        array("id"=>"JOD","text"=>"JOD"),
                        array("id"=>"KZT","text"=>"KZT"),
                        array("id"=>"KES","text"=>"KES"),
                        array("id"=>"KWD","text"=>"KWD"),
                        array("id"=>"KGS","text"=>"KGS"),
                        array("id"=>"LAK","text"=>"LAK"),
                        array("id"=>"LVL (EURO)","text"=>"LVL (EURO)"),
                        array("id"=>"LBP","text"=>"LBP"),
                        array("id"=>"LSL","text"=>"LSL"),
                        array("id"=>"LRD","text"=>"LRD"),
                        array("id"=>"LYD","text"=>"LYD"),
                        array("id"=>"LTL (EURO)","text"=>"LTL (EURO)"),
                        array("id"=>"LUF (EURO)","text"=>"LUF (EURO)"),
                        array("id"=>"MOP","text"=>"MOP"),
                        array("id"=>"MKD","text"=>"MKD"),
                        array("id"=>"MGA","text"=>"MGA"),
                        array("id"=>"MWK","text"=>"MWK"),
                        array("id"=>"MYR","text"=>"MYR"),
                        array("id"=>"MVR","text"=>"MVR"),
                        array("id"=>"MTL (EURO)","text"=>"MTL (EURO)"),
                        array("id"=>"MRO","text"=>"MRO"),
                        array("id"=>"MUR","text"=>"MUR"),
                        array("id"=>"MXN","text"=>"MXN"),
                        array("id"=>"MDL","text"=>"MDL"),
                        array("id"=>"MNT","text"=>"MNT"),
                        array("id"=>"MAD","text"=>"MAD"),
                        array("id"=>"MZN","text"=>"MZN"),
                        array("id"=>"MMK","text"=>"MMK"),
                        array("id"=>"ANG","text"=>"ANG"),
                        array("id"=>"NAD","text"=>"NAD"),
                        array("id"=>"NPR","text"=>"NPR"),
                        array("id"=>"NLG (EURO)","text"=>"NLG (EURO)"),
                        array("id"=>"NZD","text"=>"NZD"),
                        array("id"=>"NIO","text"=>"NIO"),
                        array("id"=>"NGN","text"=>"NGN"),
                        array("id"=>"KPW","text"=>"KPW"),
                        array("id"=>"NOK","text"=>"NOK"),
                        array("id"=>"OMR","text"=>"OMR"),
                        array("id"=>"PKR","text"=>"PKR"),
                        array("id"=>"PAB","text"=>"PAB"),
                        array("id"=>"PGK","text"=>"PGK"),
                        array("id"=>"PYG","text"=>"PYG"),
                        array("id"=>"PEN","text"=>"PEN"),
                        array("id"=>"PHP","text"=>"PHP"),
                        array("id"=>"PLN","text"=>"PLN"),
                        array("id"=>"PTE (EURO)","text"=>"PTE (EURO)"),
                        array("id"=>"QAR","text"=>"QAR"),
                        array("id"=>"RON","text"=>"RON"),
                        array("id"=>"RUB","text"=>"RUB"),
                        array("id"=>"RWF","text"=>"RWF"),
                        array("id"=>"WST","text"=>"WST"),
                        array("id"=>"STD","text"=>"STD"),
                        array("id"=>"SAR","text"=>"SAR"),
                        array("id"=>"RSD","text"=>"RSD"),
                        array("id"=>"SCR","text"=>"SCR"),
                        array("id"=>"SLL","text"=>"SLL"),
                        array("id"=>"SGD","text"=>"SGD"),
                        array("id"=>"SKK (EURO)","text"=>"SKK (EURO)"),
                        array("id"=>"SIT (EURO)","text"=>"SIT (EURO)"),
                        array("id"=>"SBD","text"=>"SBD"),
                        array("id"=>"SOS","text"=>"SOS"),
                        array("id"=>"ZAR","text"=>"ZAR"),
                        array("id"=>"KRW","text"=>"KRW"),
                        array("id"=>"ESP (EURO)","text"=>"ESP (EURO)"),
                        array("id"=>"LKR","text"=>"LKR"),
                        array("id"=>"SHP","text"=>"SHP"),
                        array("id"=>"SDG","text"=>"SDG"),
                        array("id"=>"SRD","text"=>"SRD"),
                        array("id"=>"SZL","text"=>"SZL"),
                        array("id"=>"SEK","text"=>"SEK"),
                        array("id"=>"CHF","text"=>"CHF"),
                        array("id"=>"SYP","text"=>"SYP"),
                        array("id"=>"TWD","text"=>"TWD"),
                        array("id"=>"TZS","text"=>"TZS"),
                        array("id"=>"THB","text"=>"THB"),
                        array("id"=>"TOP","text"=>"TOP"),
                        array("id"=>"TTD","text"=>"TTD"),
                        array("id"=>"TND","text"=>"TND"),
                        array("id"=>"TRY","text"=>"TRY"),
                        array("id"=>"TMM","text"=>"TMM"),
                        array("id"=>"USD","text"=>"USD"),
                        array("id"=>"UGX","text"=>"UGX"),
                        array("id"=>"UAH","text"=>"UAH"),
                        array("id"=>"UYU","text"=>"UYU"),
                        array("id"=>"AED","text"=>"AED"),
                        array("id"=>"VUV","text"=>"VUV"),
                        array("id"=>"VEB","text"=>"VEB"),
                        array("id"=>"VND","text"=>"VND"),
                        array("id"=>"YER","text"=>"YER"),
                        array("id"=>"ZMK","text"=>"ZMK"),
                        array("id"=>"ZWD","text"=>"ZWD"));
                    echo form_input(array(
                        "id" => "project_currency",
                        "name" => "currency",
                        "value" => $model_info->currency?$model_info->currency:"",
                        "class" => "form-control",
                        "placeholder" => "Project currency"
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <div id="link-of-add-project-member-modal" class="hide">
        <?php echo modal_anchor(get_uri("projects/project_member_modal_form"), "", array()); ?>
    </div>

    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <?php if (!$model_info->id && $login_user->user_type != "client" && $can_edit_projects) { ?>
        <button type="button" id="save-and-continue-button" class="btn btn-info text-white"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save_and_continue'); ?></button>
    <?php } ?>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#category_input").select2({
            data:<?php echo json_encode($category_dropdown); ?>
        })
        $("#project_currency").select2({
            data:<?php echo json_encode($currency_dropdown); ?>
        })
        window.projectForm = $("#project-form").appForm({
            closeModalOnSuccess: false,
            onSuccess: function (result) {
                if (typeof RELOAD_PROJECT_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_PROJECT_VIEW_AFTER_UPDATE) {
                    location.reload();

                    window.projectForm.closeModal();
                } else if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    RELOAD_VIEW_AFTER_UPDATE = false;
                    window.location = "<?php echo site_url('projects/view'); ?>/" + result.id;

                    window.projectForm.closeModal();
                } else if (window.showAddNewModal) {
                    var $addProjectMemberLink = $("#link-of-add-project-member-modal").find("a");

                    $addProjectMemberLink.attr("data-action-url", "<?php echo get_uri("projects/project_member_modal_form"); ?>");
                    $addProjectMemberLink.attr("data-title", "<?php echo app_lang("add_new_project_member"); ?>");
                    $addProjectMemberLink.attr("data-post-project_id", result.id);
                    $addProjectMemberLink.attr("data-post-view_type", "from_project_modal");

                    $addProjectMemberLink.trigger("click");

                    $("#project-table").appTable({newData: result.data, dataId: result.id});
                } else {
                    $("#project-table").appTable({newData: result.data, dataId: result.id});

                    window.projectForm.closeModal();
                }
            }
        });

        setTimeout(function () {
            $("#title").focus();
        }, 200);
        $("#project-form .select2").select2();

        setDatePicker("#start_date, #deadline");

        $("#project_labels").select2({multiple: true, data: <?php echo json_encode($label_suggestions); ?>});

        //save and open add new project member modal
        window.showAddNewModal = false;

        $("#save-and-continue-button").click(function () {
            window.showAddNewModal = true;
            $(this).trigger("submit");
        });


        function validateClientDropdown() {
            if ($("#project-type-dropdown").val() === "internal_project") {
                $("#clients-dropdown").addClass("hide");
                $("#clients-dropdown").find(".select2").removeClass("validate-hidden");
                $("#clients-dropdown").find(".select2").removeAttr("data-rule-required");
            } else {
                $("#clients-dropdown").removeClass("hide");
                $("#clients-dropdown").find(".select2").addClass("validate-hidden");
                $("#clients-dropdown").find(".select2").attr("data-rule-required", true);
            }
        }


        $("#project-type-dropdown").select2().on("change", function () {
            validateClientDropdown();
        });

        setTimeout(function () {
            validateClientDropdown();
        });
        $('#description').summernote();
    });
</script>    