<div class="card">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('visual_inspection'); ?></h4>
    </div>
    <div class="table-responsive">
        <table id="inspection-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    loadInspectionTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("misc/inspection_list_data/" . $client_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "<?php echo app_lang("internal_id") ?>"},
                {title: "<?php echo app_lang("inspection_date") ?>"},
                {title: "<?php echo app_lang("inspected_by") ?>"},
                {title: "<?php echo app_lang("location") ?>"},
                {title: "<?php echo app_lang("passed") ?>", "class": "text-center option: 70"},
                {title: "<?php echo app_lang("remarks") ?>"},
                {title: "<?php echo app_lang("next_inspection_date") ?>"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [2, 3, 4, 5, 6, 7, 8],
            xlsColumns: [2, 3, 4, 5, 6, 7, 8]
        });
    };
    $(document).ready(function() {
        loadInspectionTable("#inspection-table");
    });
</script>