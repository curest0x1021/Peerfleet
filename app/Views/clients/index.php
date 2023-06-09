<div id="page-content" class="page-wrapper clearfix">
    <div class="clearfix grid-button">
        <ul id="vessel-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
            <li><a role="presentation" data-bs-toggle="tab" href="<?php echo_uri("clients/clients_list/"); ?>" data-bs-target="#clients_list"><?php echo app_lang('vessels'); ?></a></li>
            <div class="tab-title clearfix no-border">
                <div class="title-button-group">
                    <?php if ($can_edit_clients) { ?>
                        <?php echo modal_anchor(get_uri("clients/import_clients_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_vessels'), array("class" => "btn btn-default", "title" => app_lang('import_vessels'))); ?>
                        <?php echo modal_anchor(get_uri("clients/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_vessel'), array("class" => "btn btn-default", "title" => app_lang('add_vessel'))); ?>
                    <?php } ?>
                </div>
            </div>
        </ul>
        <div class="card">
            <div class="table-responsive">
                <table id="client-table" class="display" cellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadClientsTable = function(selector) {
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
                    title: "<?php echo app_lang("primary_contact") ?>",
                    order_by: "primary_contact"
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
        var filter = $(this).attr("data-filter");
        if (filter) {
            window.selectedVesselQuickFilter = filter;
        }
        loadClientsTable("#client-table");
    });
</script>