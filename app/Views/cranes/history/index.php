<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('facts_and_figure'); ?></h4>
    </div>
    <div class="table-responsive">
        <table id="crane-history-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#crane-history-table").appTable({
            source: '<?php echo_uri("cranes/history_list_data/" . $client_id) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("name") ?>'},
                {title: '<?php echo app_lang("initial") ?>'},
                {title: '<?php echo app_lang("1st_replacement") ?>'},
                {title: '<?php echo app_lang("2nd_replacement") ?>'},
                {title: '<?php echo app_lang("3rd_replacement") ?>'},
                {title: '<?php echo app_lang("4th_replacement") ?>'},
                {title: '<?php echo app_lang("5th_replacement") ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5, 6, 7],
            xlsColumns: [1, 2, 3, 4, 5, 6, 7]
        });
    });
</script>