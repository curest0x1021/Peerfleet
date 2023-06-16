<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('warehouses'); ?></h4>
        <div class="title-button-group">
            <?php echo modal_anchor(get_uri("clients/warehouse_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_warehouse'), array("class" => "btn btn-default", "title" => app_lang('add_warehouse'), "data-post-client_id" => $client_id)); ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="warehouse-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#warehouse-table").appTable({
            source: '<?php echo_uri("clients/warehouses_list_data/" . $client_id) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("code") ?>'},
                {title: '<?php echo app_lang("name") ?>'},
                {title: '<?php echo app_lang("location") ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3],
            xlsColumns: [1, 2, 3]
        });
    });
</script>