<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('loadtest'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("wires/import_modal_form/" . $client_id . "/loadtest"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="wire-loadtest-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#wire-loadtest-table").appTable({
            source: '<?php echo_uri("wires/loadtest_list_data/" . $client_id . '/' . $equipment) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("name") ?>', class: "w200"},
                {title: '<?php echo app_lang("test_date") ?>', class: "w100"},
                {title: '<?php echo app_lang("location") ?>', class: "w150"},
                {title: '<?php echo app_lang("passed") ?>', class: "text-center w50"},
                {title: '<?php echo app_lang("remarks") ?>', class: "w30p"},
                {title: '<?php echo app_lang("files") ?>', class: "all"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5],
            xlsColumns: [1, 2, 3, 4, 5]
        });
    });
</script>