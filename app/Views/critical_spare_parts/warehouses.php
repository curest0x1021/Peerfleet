<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('warehouses'); ?></h4>
    </div>
    <div class="table-responsive">
        <table id="warehouse-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">

    loadWarehouseTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("critical_spare_parts/warehouses_list_data") ?>',
            filterDropdown: [
                {name: "client_id", class: "w200", options: <?php echo $vessels_dropdown; ?>},
            ],
            order: [[2, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: "", "class": "text-center w25"},
                {title: '<?php echo app_lang("code") ?>', class: "text-center w100"},
                {title: '<?php echo app_lang("name") ?>', class: "all"},
                {title: '<?php echo app_lang("vessel") ?>', class: "w20p"},
                {title: '<?php echo app_lang("total_items") ?>', class:"text-center w15p"},
                {title: '<?php echo app_lang("total_quantities") ?>', class:"text-center w15p"},
                {title: '<?php echo app_lang("min_stock_items") ?>', class:"text-center w15p"}
            ],
            printColumns: [1, 2, 3, 4],
            xlsColumns: [1, 2, 3, 4]
        });
    }

    $(document).ready(function () {
        loadWarehouseTable("#warehouse-table");
    });
</script>