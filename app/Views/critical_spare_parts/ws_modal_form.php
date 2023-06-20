<?php echo form_open(get_uri("critical_spare_parts/save_ws"), array("id" => "ws-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="warehouse_id" value="<?php echo $warehouse_id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="spare_id" class="<?php echo $label_column; ?>"><?php echo app_lang('item'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_dropdown("spare_id", $items_dropdown, array($model_info->spare_id), "class='select2 validate-hidden' id='spare_id' data-rule-required='true' data-msg-required='" . app_lang('field_required') . "'");
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
                <label for="max_stocks" class="<?php echo $label_column; ?>"><?php echo app_lang('max_stocks'); ?></label>
                <div class="<?php echo $field_column; ?>">
                    <?php
                    echo form_input(array(
                        "id" => "max_stocks",
                        "name" => "max_stocks",
                        "value" => $model_info->max_stocks ? $model_info->max_stocks : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('max_stocks'),
                        "type" => "number",
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
    var sparePars = [];
    $(document).ready(function() {
        spareParts = JSON.parse('<?php echo json_encode($spare_parts); ?>');
        const modelInfo = JSON.parse('<?php echo json_encode($model_info);?>');
        console.log(spareParts);
        $("#ws-form").appForm({
            onSuccess: function(result) {
                if (result.min_stock_reached) {
                    appAlert.error(result.message, {duration: 10000});
                } else {
                    appAlert.success(result.message, {duration: 10000});
                }
                $("#ws-table").appTable({newData: result.data, dataId: result.id});
            }
        });

        $('#spare_id').select2();
        $("#spare_id").change((e) => {
            generateInfo(e.target.value);
        });

        if (modelInfo) {
            generateInfo(modelInfo.spare_id);
        }

    });

    function generateInfo(spareId) {
        const index = spareParts.findIndex((k) => k.id === spareId);
            if (index > -1) {
                const item = spareParts[index];
                let html = '<div class="row"><div class="<?php echo $label_column; ?>"></div><div class="<?php echo $field_column; ?>">';
                html += `<div class="row"><label class="col-6"><?php echo app_lang("manufacturer");?> : </label><span class="col-6">${item.manufacturer}</span></div>`;
                html += `<div class="row"><label class="col-6"><?php echo app_lang("applicable_equipment");?> : </label><span class="col-6">${item.applicable_equip}</span></div>`;
                html += `<div class="row"><label class="col-6"><?php echo app_lang("ship_equipment");?> : </label><span class="col-6">${item.ship_equip}</span></div>`;
                html += `<div class="row"><label class="col-6"><?php echo app_lang("unit");?> : </label><span class="col-6">${item.unit}</span></div>`;
                html += `<div class="row"><label class="col-6"><?php echo app_lang("part_number");?> : </label><span class="col-6">${item.part_number}</span></div>`;
                html += `<div class="row"><label class="col-6"><?php echo app_lang("article_number");?> : </label><span class="col-6">${item.article_number}</span></div>`;
                html += `<div class="row"><label class="col-6"><?php echo app_lang("drawing_number");?> : </label><span class="col-6">${item.drawing_number}</span></div>`;
                html += `<div class="row"><label class="col-6"><?php echo app_lang("hs_code");?> : </label><span class="col-6">${item.hs_code}</span></div>`;
                html += "</div></div>"
                $("#item-info").html(html);
            } else {
                $("#item-info").html("");
            }
    }
</script>