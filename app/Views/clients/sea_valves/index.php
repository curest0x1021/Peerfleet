<div class="card rounded-bottom">
    <div class="tab-title clearfix">
        <h4><?php echo app_lang('sea_valves'); ?></h4>
        <div class="title-button-group">
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
            order: [[0, "desc"]],
            columns: [
                {title: '<?php echo app_lang("id") ?>'},
                {title: '<?php echo app_lang("name") ?>'},
                {title: '<?php echo app_lang("norm") ?>'},
                {title: '<?php echo app_lang("diameter_nominal") ?>'},
                {title: '<?php echo app_lang("pressure_rating") ?>'},
                {title: '<?php echo app_lang("length") ?>'},
                {title: '<?php echo app_lang("height") ?>'},
                {title: '<?php echo app_lang("diameter") ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3, 4, 5 ,6, 7],
            xlsColumns: [0, 1, 2, 3, 4, 5 ,6, 7]
        });
    });
</script>