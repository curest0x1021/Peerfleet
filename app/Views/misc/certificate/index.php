<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('certificates'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="misc-certificates-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#misc-certificates-table").appTable({
            source: '<?php echo_uri("misc/certificate_list_data/" . $client_id . "/" . $main_id) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo ("Shackle") ?>'},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("files") ?>', class: "all"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 15],
            xlsColumns: [1, 15]
        });
    });
</script>