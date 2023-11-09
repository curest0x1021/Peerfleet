<div class="card">
    <div class="table-responsive">
        <table id="client-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    loadClientsTable = function(selector) {
        // var showInvoiceInfo = true;
        // if (!"<?php echo $show_invoice_info; ?>") {
        //     showInvoiceInfo = false;
        // }

        var showOptions = true;
        if (!"<?php echo $can_edit_clients; ?>") {
            showOptions = false;
        }

        var quick_filters_dropdown = <?php echo view("clients/quick_filters_dropdown"); ?>;
        if (window.selectedVesselQuickFilter) {
            var filterIndex = quick_filters_dropdown.findIndex(x => x.id === window.selectedVesselQuickFilter);
            if ([filterIndex] > -1) {
                //match found
                quick_filters_dropdown[filterIndex].isSelected = true;
            }
        }

        $(selector).appTable({
            source: '<?php echo_uri("clients/list_data") ?>',
            serverSide: true,
            columns: [{
                    title: "<?php echo app_lang("id") ?>",
                    "class": "text-center w50 all",
                    order_by: "id"
                },
                {
                    title: "<?php echo app_lang("charter_name") ?>",
                    "class": "all",
                    order_by: "charter_name"
                },
                {
                    title: "<?php echo app_lang("responsible_person") ?>",
                    order_by: "responsible_person"
                },
                {
                    title: "<?php echo app_lang("vessel_types") ?>",
                    order_by: "vessel_types"
                },
                {
                    title: "<?php echo app_lang("projects") ?>"
                },
                {
                    title: '<i data-feather="menu" class="icon-16"></i>',
                    "class": "text-center option w100",
                    visible: showOptions
                }
            ],
            printColumns: [0, 1, 2, 3, 4],
            xlsColumns: [0, 1, 2, 3, 4]
        });
    };
    $(document).ready(function() {
        loadClientsTable("#client-table");
    });
</script>