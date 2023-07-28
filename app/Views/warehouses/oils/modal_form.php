<?php echo form_open(get_uri("warehouses/save_oil"), array("id" => "oils-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="warehouse_id" value="<?php echo $warehouse_id; ?>" />
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="oil_id" class="<?php echo $label_column; ?>"><?php echo app_lang('item'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_dropdown("oil_id", $items_dropdown, array($model_info->oil_id), "class='select2 validate-hidden' id='oil_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
            </div>
        </div>

        <div id="item-info"></div>

        <div class="form-group">
            <div class="row">
                <label for="quantity" class="<?php echo $label_column; ?>"><?php echo app_lang('quantity'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "quantity",
                        "name" => "quantity",
                        "value" => $model_info->quantity ? $model_info->quantity : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('quantity'),
                        "type" => "number",
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="min_stocks" class="<?php echo $label_column; ?>"><?php echo app_lang('min_stocks'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "min_stocks",
                        "name" => "min_stocks",
                        "value" => $model_info->min_stocks ? $model_info->min_stocks : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('min_stocks'),
                        "type" => "number"
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
    var oils = [];
    $(document).ready(function() {
        oils = JSON.parse('<?php echo json_encode($oils); ?>');
        const modelInfo = JSON.parse('<?php echo json_encode($model_info);?>');

        $("#oils-form").bind("submit", function() {
            $("#oil_id").prop("disabled", false);
        });

        $("#oils-form").appForm({
            onSuccess: function(result) {
                if (result.min_stock_reached) {
                    appAlert.error(result.message, {duration: 1000});
                    // setTimeout(() => {
                    //     window.location.reload();
                    // }, 500);
                } else {
                    appAlert.success(result.message, {duration: 5000});
                    // $("#oils-table").appTable({newData: result.data, dataId: result.id});
                }
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        });

        $('#oil_id').select2();
        $("#oil_id").change((e) => {
            generateInfo(e.target.value);
        });

        if (modelInfo.id) {
            generateInfo(modelInfo.oil_id);
            $("#oil_id").prop("disabled", true);
        }

    });

    function generateInfo(id) {
        const index = oils.findIndex((k) => k.id === id);
            if (index > -1) {
                const item = oils[index];
                let html = '<div class="row"><div class="<?php echo $label_column; ?>"></div><div class="<?php echo $field_column; ?>">';
                html += `<div class="row"><label class="col-md-5"><?php echo app_lang("manufacturer");?> : </label><span class="col-md-7">${item.manufacturer}</span></div>`;
                html += `<div class="row"><label class="col-md-5"><?php echo app_lang("unit");?> : </label><span class="col-md-7">${item.unit}</span></div>`;
                html += `<div class="row"><label class="col-md-5"><?php echo app_lang("part_number");?> : </label><span class="col-md-7">${item.part_number}</span></div>`;
                html += `<div class="row"><label class="col-md-5"><?php echo app_lang("article_number");?> : </label><span class="col-md-7">${item.article_number}</span></div>`;
                html += `<div class="row"><label class="col-md-5"><?php echo app_lang("hs_code");?> : </label><span class="col-md-7">${item.hs_code}</span></div>`;
                html += `<div class="row"><label class="col-md-5"><?php echo app_lang("critical");?> : </label><span class="col-md-7">${item.is_critical === "1" ? "Yes" : "No"}</span></div>`;
                html += "</div></div>"
                $("#item-info").html(html);
            } else {
                $("#item-info").html("");
            }
    }
</script>