<div class="card">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('misc_info'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo anchor(get_uri("lifting_gear_types"), app_lang('lifting_gear_types') . " <i data-feather='external-link' class='icon-16'></i>" , array("class" => "mr15", "target" => "_blank")); ?>
                <?php echo modal_anchor(get_uri("misc/info_modal_form/" . $client_id. "/" . $main_id), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="misc-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    loadMiscTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("misc/info_list_data/" . $client_id. "/" . $main_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "<?php echo app_lang("internal_id") ?>", "class": "w100"},
                {title: "<?php echo app_lang("description") ?>", "class": "w150"},
                {title: "WLL (TS)"},
                {title: "WL (m)"},
                {title: "<?php echo app_lang("type") ?>"},
                {title: "BL (kN)"},
                {title: "<?php echo app_lang("icc") ?>"},
                {title: "<?php echo app_lang("manufacturer") ?>"},
                {title: "<?php echo app_lang("delivered") ?>"},
                {title: "<?php echo app_lang("lifts") ?>"},
                {title: "<?php echo app_lang("loadtest") ?>", "class": "text-center w50"},
                {title: "<?php echo app_lang("visual_inspection") ?>", "class": "text-center w50"},
                {visible: false, searchable: false},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            xlsColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
        });
    };
    $(document).ready(function() {
        loadMiscTable("#misc-table");
    });
</script>