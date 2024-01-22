<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('certificates'); ?></h4>
        <?php if ($can_edit_items) { ?>
            <div class="title-button-group">
            </div>
        <?php } ?>
    </div>
    <div class="table-responsive">
        <table id="grommet-certificates-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#grommet-certificates-table").appTable({
            source: '<?php echo_uri("grommets/certificate_list_data/" . $client_id . "/" . $main_id) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo ("Grommet") ?>'},
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
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("files") ?>', class: "all"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5],
            xlsColumns: [1, 2, 3, 4, 5]
        });
    });
</script>