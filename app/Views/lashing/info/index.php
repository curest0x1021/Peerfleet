<div class="card">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('lashing_info'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo anchor(get_uri("lifting_gear_types"), app_lang('lifting_gear_types') . " <i data-feather='external-link' class='icon-16'></i>" , array("class" => "mr15", "target" => "_blank")); ?>
                <?php echo modal_anchor(get_uri("lashing/info_modal_form/" . $client_id), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="lashing-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    loadLashingTable = function(selector) {
        $(selector).appTable({
            source: '<?php echo_uri("lashing/info_list_data/" . $client_id) ?>',
            columns: [
                {visible: false, searchable: false},
                {title: "No."},
                {title: "<?php echo app_lang("category") ?>"},
                {title: "<?php echo app_lang("name") ?>"},
                {title: "<?php echo app_lang("description") ?>"},
                {title: "Qty"},
                {title: "Length [mm]"},
                {title: "Width [mm]"},
                {title: "Height [mm]"},
                {title: "MSL [kN]"},
                {title: "BL [kN]"},
                {title: "<?php echo app_lang("supplied_date") ?>"},
                {title: "<?php echo app_lang("supplied_place") ?>"},
                {title: "<?php echo app_lang("property") ?>"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
            xlsColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
        });
    };
    $(document).ready(function() {
        loadLashingTable("#lashing-table");
    });
</script>