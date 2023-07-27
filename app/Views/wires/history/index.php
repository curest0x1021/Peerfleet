<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('history'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("wires/import_modal_form/" . $client_id . "/history"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="wire-history-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#wire-history-table").appTable({
            source: '<?php echo_uri("wires/history_list_data/" . $client_id) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: "", class: "text-center, w25"},
                {title: '<?php echo app_lang("name") ?>', class: "all"},
                {title: '<?php echo app_lang("initial") ?>', class: "text-center w10"},
                {title: '<?php echo app_lang("1st_replacement") ?>', class: "text-center w10"},
                {title: '<?php echo app_lang("2nd_replacement") ?>', class: "text-center w10"},
                {title: '<?php echo app_lang("3rd_replacement") ?>', class: "text-center w10"},
                {title: '<?php echo app_lang("4th_replacement") ?>', class: "text-center w10"},
                {title: '<?php echo app_lang("5th_replacement") ?>', class: "text-center w10"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [2, 3, 4, 5, 6, 7, 8],
            xlsColumns: [2, 3, 4, 5, 6, 7, 8]
        });
    });
</script>