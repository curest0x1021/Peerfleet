<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('sea_valves'); ?></h4>
        <div class="title-button-group">
            <?php echo modal_anchor(get_uri("clients/import_sea_valves_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_sea_valves'), array("class" => "btn btn-default", "title" => app_lang('import_sea_valves'), "data-post-client_id" => $client_id)); ?>
            <?php echo modal_anchor(get_uri("clients/sea_valve_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_sea_valve'), array("class" => "btn btn-default", "title" => app_lang('add_sea_valve'), "data-post-client_id" => $client_id)); ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="sea-valve-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#sea-valve-table").appTable({
            source: '<?php echo_uri("clients/sea_valves_list_data/" . $client_id) ?>',
            order: [[1, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("name") ?>'},
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("norm") ?>', class: "text-center w10p"},
                {title: '<?php echo app_lang("diameter_nominal") ?>', class: "text-center w10p"},
                {title: '<?php echo app_lang("pressure_rating") ?>', class: "text-center w10p"},
                {title: '<?php echo app_lang("length") ?>', class: "text-center w10p"},
                {title: '<?php echo app_lang("height") ?>', class: "text-center w10p"},
                {title: '<?php echo app_lang("diameter") ?>', class: "text-center w10p"},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2, 3, 4, 5 ,6, 7, 8],
            xlsColumns: [1, 2, 3, 4, 5 ,6, 7, 8]
        });
    });
</script>