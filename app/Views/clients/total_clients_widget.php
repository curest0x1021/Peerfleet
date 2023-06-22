<div class="card bg-white">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i data-feather="anchor" class="icon-16"></i> &nbsp;<?php echo app_lang('fleet_overview'); ?></span>
        <div class="d-flex align-items-center">
            <span style="font-size: 12px; font-weight: 400; margin-right: 16px;"><?php echo app_lang("total_vessels"); ?>: <b><?php echo $total; ?></b></span>
            <button id="show_fleet" class="btn btn-primary"><?php echo app_lang('show_fleet'); ?></button>
        </div>
    </div>
    <div class="table-responsive" id="total-clients-widget-table">
        <table id="client-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        initScrollbar('#total-clients-widget-table', {
            setHeight: 330
        });

        $("#client-table").appTable({
            source: '<?php echo_uri("clients/total_clients_list") ?>',
            order: [[3, "desc"]],
            displayLength: 30,
            responsive: false, //hide responsive (+) icon
            columns: [
                {title: '<?php echo app_lang("vessel_name") ?>', "class": 'w40p'},
                {title: '<?php echo app_lang("type") ?>', "class": 'w25p'},
                {title: '<?php echo app_lang("build_series") ?>', "class": 'w20p'},
                {title: '<?php echo app_lang("favorite") ?>', "class": 'text-center w100'},
            ],
            onInitComplete: function () {
                $("#client-table_wrapper .datatable-tools").addClass("hide");
            },
            rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).attr("style", "border-left:5px solid " + aData[0] + " !important;");
            }
        });

        $("#show_fleet").click(function() {
            window.location.href = "<?php echo get_uri("clients/index/clients_list"); ?>"
        });
    });
</script>
