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
                {title: '<?php echo app_lang("code") ?>', class: "text-center w100"},
                {title: '<?php echo app_lang("warehouse") ?>', class: "all"},
                {title: '<?php echo app_lang("vessel") ?>', class: "w200"},
                {title: '<?php echo app_lang("total_items") ?>', class:"text-center w150p"},
                {title: '<?php echo app_lang("total_quantities") ?>', class:"text-center w150p"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4],
            xlsColumns: [1, 2, 3, 4]
        });
    }

    $(document).ready(function () {
        loadWarehouseTable("#warehouse-table");
    });
</script>