<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('items'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("critical_spare_parts/items_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="item-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#item-table").appTable({
            source: '<?php echo_uri("critical_spare_parts/items_list_data") ?>',
            order: [[1, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("name") ?>'},
                {title: '<?php echo app_lang("manufacturer") ?>'},
                {title: '<?php echo app_lang("applicable_equipment") ?>'},
                {title: '<?php echo app_lang("ship_equipment") ?>'},
                {title: '<?php echo app_lang("unit") ?>'},
                {title: '<?php echo app_lang("part_number") ?>'},
                {title: '<?php echo app_lang("hs_code") ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5, 6, 7],
            xlsColumns: [1, 2, 3, 4, 5, 6, 7]
        });
    });
</script>