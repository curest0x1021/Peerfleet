<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('facts_and_figure'); ?></h4>
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
                {title: '<?php echo app_lang("crane") ?>'},
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