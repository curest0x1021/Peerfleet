<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('facts_and_figure'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("wires/import_modal_form/" . $client_id . "/info"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="wire-info-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#wire-info-table").appTable({
            source: '<?php echo_uri("wires/info_list_data/" . $client_id) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("equipment") ?>'},
                {title: '<?php echo app_lang("wire") ?>'},
                {title: '<?php echo app_lang("diameter") . ' in mm' ?>'},
                {title: '<?php echo app_lang("length") . ' in m' ?>'},
                {title: '<?php echo app_lang("swl") . ' in mt' ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5],
            xlsColumns: [1, 2, 3, 4, 5]
        });
    });
</script>