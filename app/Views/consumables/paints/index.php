<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo anchor(get_uri("manufacturers"), app_lang('manufacturers') . " <i data-feather='external-link' class='icon-16'></i>" , array("class" => "mr15", "target" => "_blank")); ?>
                <?php echo anchor(get_uri("units"), app_lang('units') . " <i data-feather='external-link' class='icon-16'></i>" , array("class" => "mr15", "target" => "_blank")); ?>
                <?php echo modal_anchor(get_uri("consumables/import_modal_form/paints"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
                <?php echo modal_anchor(get_uri("consumables/paints_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="paint-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#paint-table").appTable({
            source: '<?php echo_uri("consumables/paints_list_data") ?>',
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
                {title: '<?php echo app_lang("unit") ?>', class: "text-center w100"},
                {title: '<?php echo app_lang("part_number") ?>', class: "text-center w15p"},
                {title: '<?php echo app_lang("article_number") ?>', class: "text-center w15p"},
                {title: '<?php echo app_lang("hs_code") ?>', class: "text-center w15p"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 3, 4, 5, 6, 7, 8],
            xlsColumns: [1, 3, 4, 5, 6, 7, 8]
        });

        $('body').on('click', '[data-act=update-paint-critical-checkbox]', function () {
            $(this).find("span").removeClass("checkbox-checked");
            $(this).find("span").addClass("inline-loader");
            $.ajax({
                url: '<?php echo_uri("consumables/save_paint_critical") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {value: $(this).attr('data-value')},
                success: function (response) {
                    if (response.success) {
                        $("#paint-table").appTable({newData: response.data, dataId: response.id});
                    }
                }
            });
        });
    });
</script>