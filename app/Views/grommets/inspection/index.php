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
            source: '<?php echo_uri("grommets/inspection_list_data/" . $client_id . "/" . $main_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "<?php echo app_lang("internal_id") ?>", "class": "w100"},
                {title: "<?php echo app_lang("inspection_date") ?>", "class": "w100"},
                {title: "<?php echo app_lang("inspected_by") ?>", "class": "w150"},
                {title: "<?php echo app_lang("location") ?>", "class": "w150"},
                {title: "<?php echo app_lang("passed") ?>", "class": "text-center w70"},
                {title: "<?php echo app_lang("remarks") ?>", "class": "all"},
                {title: "<?php echo app_lang("next_inspection_date") ?>", "class": "w100"},
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