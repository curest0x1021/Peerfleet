<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang('spare_parts'); ?></h1>
                </div>
                <ul id="crane-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs" role="tablist">
                    <li><a role="presentation" data-bs-toggle="tab" data-bs-target="#items-tab"> <?php echo app_lang('items'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="card rounded-bottom">
                        <div class="tab-title clearfix">
                            <?php if ($can_edit_items) { ?>
                                <div class="title-button-group">
                                    <?php echo anchor(get_uri("manufacturers"), app_lang('manufacturers') . " <i data-feather='external-link' class='icon-16'></i>", array("class" => "mr15", "target" => "_blank")); ?>
                                    <?php echo anchor(get_uri("ship_equipments"), app_lang('ship_equipments') . " <i data-feather='external-link' class='icon-16'></i>", array("class" => "mr15", "target" => "_blank")); ?>
                                    <?php echo anchor(get_uri("applicable_equipments"), app_lang('applicable_equipments') . " <i data-feather='external-link' class='icon-16'></i>", array("class" => "mr15", "target" => "_blank")); ?>
                                    <?php echo anchor(get_uri("units"), app_lang('units') . " <i data-feather='external-link' class='icon-16'></i>", array("class" => "mr15", "target" => "_blank")); ?>
                                    <?php echo modal_anchor(get_uri("spare_parts/import_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
                                    <?php echo modal_anchor(get_uri("spare_parts/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="table-responsive">
                            <table id="item-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#item-table").appTable({
            source: '<?php echo_uri("spare_parts/list_data") ?>',
            checkBoxes: [
                {text: '<?php echo app_lang("critical") ?>', name: "is_critical", value: "1", isChecked: false},
                {text: '<?php echo app_lang("non_critical") ?>', name: "is_critical", value: "0", isChecked: false}
            ],
            order: [[1, "desc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("critical") ?>', visible: false},
                {title: '<?php echo app_lang("critical") ?>', class: "text-center w50"},
                {title: '<?php echo app_lang("name") ?>', class: "all"},
                {title: '<?php echo app_lang("manufacturer") ?>', class: "w15p"},
                {title: '<?php echo app_lang("ship_equipment") ?>', class: "w15p"},
                {title: '<?php echo app_lang("applicable_equipment") ?>', class: "w15p"},
                {title: '<?php echo app_lang("unit") ?>', class: "text-center w100"},
                {title: '<?php echo app_lang("part_number") ?>', class: "text-center w10p"},
                {title: '<?php echo app_lang("hs_code") ?>', class: "text-center w10p"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 3, 4, 5, 6, 7, 8, 9],
            xlsColumns: [1, 3, 4, 5, 6, 7, 8, 9]
        });

        $('body').on('click', '[data-act=update-critical-checkbox]', function () {
            $(this).find("span").removeClass("checkbox-checked");
            $(this).find("span").addClass("inline-loader");
            $.ajax({
                url: '<?php echo_uri("spare_parts/save_critical") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {value: $(this).attr('data-value')},
                success: function (response) {
                    if (response.success) {
                        $("#item-table").appTable({newData: response.data, dataId: response.id});
                    }
                }
            });
        });
    });
</script>