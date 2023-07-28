<?php echo form_open(get_uri("shipyards/save"), array("id" => "shipyard-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix" style="height: 768px; position: relative; overflow: auto;">
    <div class="container-fluid">
        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("id"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "id",
                    "name" => "id",
                    "value" => $model_info->id ? $model_info->id : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('id'),
                    "type" => "number",
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
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
                <span><?php echo app_lang("country"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_dropdown("country_id", $countries_dropdown, array(strtolower($model_info->country_id)), "class='select2 validate-hidden' id='country_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("region"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_dropdown("region_id", $regions_dropdown, array($model_info->region_id), "class='select2 validate-hidden' id='region_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("sailing_area"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_dropdown("sailingarea_id", $sailing_areas_dropdown, array($model_info->sailingarea_id), "class='select2 validate-hidden' id='sailingarea_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("description"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <div class="notepad">
                    <?php
                    echo form_textarea(array(
                        "id" => "description",
                        "name" => "description",
                        "value" => process_images_from_content($model_info->description, false),
                        "class" => "form-control",
                        "placeholder" => app_lang('description') . "...",
                        "data-rich-text-editor" => true
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("latitude"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "lat",
                    "name" => "lat",
                    "value" => $model_info->lat ? $model_info->lat : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('latitude'),
                    "type" => "number",
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("longitude"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "lon",
                    "name" => "lon",
                    "value" => $model_info->lon ? $model_info->lon : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('longitude'),
                    "type" => "number",
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("url"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "url",
                    "name" => "url",
                    "value" => $model_info->url ? $model_info->url : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('url'),
                    "type" => "url",
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("services"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "services",
                    "name" => "services",
                    "value" => $model_info->services,
                    "class" => "form-control",
                    "placeholder" => app_lang('services'),
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("score"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "score",
                    "name" => "score",
                    "value" => $model_info->score ? $model_info->score : "",
                    "type" => "number",
                    "class" => "form-control",
                    "placeholder" => app_lang('score')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("maxLength"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "maxLength",
                    "name" => "maxLength",
                    "value" => $model_info->maxLength ? $model_info->maxLength : "",
                    "type" => "number",
                    "class" => "form-control",
                    "placeholder" => app_lang('maxLength')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("maxWidth"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "maxWidth",
                    "name" => "maxWidth",
                    "value" => $model_info->maxWidth ? $model_info->maxWidth : "",
                    "type" => "number",
                    "class" => "form-control",
                    "placeholder" => app_lang('maxWidth')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("maxDepth"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "maxDepth",
                    "name" => "maxDepth",
                    "value" => $model_info->maxDepth ? $model_info->maxDepth : "",
                    "type" => "number",
                    "class" => "form-control",
                    "placeholder" => app_lang('maxDepth')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("docksCount"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "docksCount",
                    "name" => "docksCount",
                    "value" => $model_info->docksCount ? $model_info->docksCount : "",
                    "type" => "number",
                    "class" => "form-control",
                    "placeholder" => app_lang('docksCount')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("cranesCount"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "cranesCount",
                    "name" => "cranesCount",
                    "value" => $model_info->cranesCount ? $model_info->cranesCount : "",
                    "type" => "number",
                    "class" => "form-control",
                    "placeholder" => app_lang('cranesCount')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("dock"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "dock",
                    "name" => "dock",
                    "value" => $model_info->dock ? $model_info->dock : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('dock')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("email"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "email",
                    "name" => "email",
                    "value" => $model_info->email ? $model_info->email : "",
                    "type" => "email",
                    "class" => "form-control",
                    "placeholder" => app_lang('email'),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("phone"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "phone",
                    "name" => "phone",
                    "value" => $model_info->phone ? $model_info->phone : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('phone'),
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("fax"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "fax",
                    "name" => "fax",
                    "value" => $model_info->fax ? $model_info->fax : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('fax')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("only_new_build"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_checkbox("only_new_build", "1", $model_info->only_new_build, "id='only_new_build' class='form-check-input mt-2'");
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("published"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_checkbox("published", "1", $model_info->published, "id='published' class='form-check-input mt-2'");
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("city"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "city",
                    "name" => "city",
                    "value" => $model_info->city ? $model_info->city : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('city')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("street"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "street",
                    "name" => "street",
                    "value" => $model_info->street ? $model_info->street : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('street')
                ));
                ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("zip"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "zip",
                    "name" => "zip",
                    "value" => $model_info->zip ? $model_info->zip : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('zip')
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
$(document).ready(function () {
    const countryMap = JSON.parse('<?php echo json_encode($country_map); ?>');
    $("#shipyard-form").appForm({
        onSuccess: function (result) {
            appAlert.success(result.message, {duration: 5000});
            setTimeout(() => {
                window.location.reload();
            }, [500]);
        }
    });
    setTimeout(function () {
        $("#id").focus();
    }, 200);

    $("#services").select2({multiple: true, data: <?php echo $services_dropdown; ?>});
    $(".select2").select2();

    $("#country_id").change((e) => {
        const data = countryMap.find((item) => item.country_id === e.target.value);
        if (data) {
            console.log(data.region_id, data.sailingarea_id);
            $("#region_id").val(data.region_id);
            $("#region_id").trigger("change");
            $("#sailingarea_id").val(data.sailingarea_id);
            $("#sailingarea_id").trigger("change");
        }
    });

});
</script>