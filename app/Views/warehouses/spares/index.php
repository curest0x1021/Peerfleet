<div class="card">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('spare_parts'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("warehouses/import_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'), "data-post-tabs" => "spares", "data-post-warehouse_id" => $warehouse_id, "data-post-client_id" => $client_id)); ?>
                <?php echo modal_anchor(get_uri("warehouses/spares_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'), "data-post-warehouse_id" => $warehouse_id, "data-post-client_id" => $client_id)); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="spares-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    loadSparesTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("warehouses/spares_list_data/" . $client_id . "/" . $warehouse_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "", "class": "text-center w25"},
                {title: "<?php echo app_lang("critical") ?>", "class": "text-center w50"},
                {title: "<?php echo app_lang("item") ?>", class: "w150"},
                {title: "<?php echo app_lang("quantity") ?>", "class": "text-center w100"},
                {title: "<?php echo app_lang("min_stocks") ?>", "class": "text-center w100"},
                {title: "<?php echo app_lang("max_stocks") ?>", "class": "text-center w100"},
                {title: "<?php echo app_lang("manufacturer") ?>"},
                {title: "<?php echo app_lang("unit") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("part_number") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("article_number") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("drawing_number") ?>", class: "text-center w100"},
                {title: "<?php echo app_lang("hs_code") ?>", class: "text-center w100"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            xlsColumns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        });
    };
    $(document).ready(function() {
        loadSparesTable("#spares-table");
    });
</script>