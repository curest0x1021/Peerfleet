<div class="card">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('loadtest'); ?></h4>
    </div>
    <div class="table-responsive">
        <table id="loadtest-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    loadLoadtestTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("grommets/loadtest_list_data/" . $client_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "<?php echo app_lang("internal_id") ?>"},
                {title: "<?php echo app_lang("test_date") ?>"},
                {title: "<?php echo app_lang("tested_by") ?>"},
                {title: "<?php echo app_lang("location") ?>"},
                {title: "<?php echo app_lang("passed") ?>", "class": "text-center option: 70"},
                {title: "<?php echo app_lang("remarks") ?>"},
                {title: "<?php echo app_lang("next_test_date") ?>"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [2, 3, 4, 5, 6, 7, 8],
            xlsColumns: [2, 3, 4, 5, 6, 7, 8]
        });
    };
    $(document).ready(function() {
        loadLoadtestTable("#loadtest-table");
    });
</script>