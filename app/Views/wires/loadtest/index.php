<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('loadtest'); ?></h4>
        <div class="title-button-group">
            <?php echo modal_anchor(get_uri("wires/loadtest_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_loadtest'), array("class" => "btn btn-default", "title" => app_lang('add_loadtest'), "data-post-client_id" => $client_id)); ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="wire-loadtest-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#wire-loadtest-table").appTable({
            source: '<?php echo_uri("wires/loadtest_list_data/" . $client_id) ?>',
            order: [[0, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("test_date") ?>', class: "w100"},
                {title: '<?php echo app_lang("crane") ?>', class: "w100"},
                {title: '<?php echo app_lang("wire") ?>', class: "w100"},
                {title: '<?php echo app_lang("result_loadtest") ?>', class: "w30p"},
                {title: '<?php echo app_lang("location") ?>', class: "w150"},
                {title: '<?php echo app_lang("files") ?>', class: "all"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5],
            xlsColumns: [1, 2, 3, 4, 5]
        });
    });
</script>