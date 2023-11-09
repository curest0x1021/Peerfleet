<?php
    $json_str = json_decode(json_encode($companies), true);

    $htmlContent = "";
    foreach($companies as $data) {
        $htmlContent .= modal_anchor(get_uri("shipyards/modal_view/" . $data->id), $data->name, array("title" => $data->name . " " . app_lang("information"), "data-id" => '_' . $data->id));
    }
?>

<div id="page-content" class="clearfix page-content">
    <div class="container-fluid  full-width-button">
        <div class="row clients-view-button">
            <div class="col-md-12">
                <div class="page-title clearfix no-border no-border-top-radius no-bg">
                    <h1 class="pl0"><?php echo app_lang("shipyards"); ?></h1>
                </div>
                <?php echo view("shipyards/tabs"); ?>
                <div class="tab-content card">
                    <div id="map" style="width: 100%; height: 500px;"></div>
                    <ul id="detail-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title mt20" role="tablist">
                        <li id="repair_tab"><a role="presentation" data-bs-toggle="tab" data-bs-target="#repairs-info"> <?php echo app_lang('shipyards_for_repair') . ' (' . count($repair_list) . ')'; ?></a></li>
                        <li id="newbuild_tab"><a role="presentation" data-bs-toggle="tab" data-bs-target="#newbuilds-info"> <?php echo app_lang('shipyards_for_new_build') . ' (' . count($new_build_list) . ')'; ?></a></li>
                        <li id="scrapping_tab"><a role="presentation" data-bs-toggle="tab" data-bs-target="#scrapping-info"> <?php echo app_lang('shipyards_for_scrapping') . ' (' . count($scrapping_list) . ')'; ?></a></li>
                        <?php if ($can_edit_items) { ?>
                            <div class="tab-title clearfix no-border">
                                <div class="title-button-group">
                                    <?php echo modal_anchor(get_uri("shipyards/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="repairs-info">
                            <div class="table-responsive">
                                <table id="repair-table" class="display" cellspacing="0" width="100%">
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="newbuilds-info">
                            <div class="table-responsive">
                                <table id="new-build-table" class="display" cellspacing="0" width="100%">
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="scrapping-info">
                            <div class="table-responsive">
                                <table id="scrapping-table" class="display" cellspacing="0" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Temp content area -->
                    <div style="display: none;">
                        <?php echo $htmlContent; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    load_css(array(
        "assets/css/leaflet.css",
        "assets/css/leaflet-gesture-handling.min.css",
        "assets/css/MarkerCluster.Default.css",
        "assets/css/MarkerCluster.css",
        "assets/css/flag_icons.css",
        "assets/css/shipyards.css",
        "assets/css/jquery.dataTables.min.css"
    ));
    load_js(array(
        "assets/js/leaflet/leaflet.js",
        "assets/js/leaflet/leaflet-gesture-handling.min.js",
        "assets/js/leaflet/L.Control.Locate.min.js",
        "assets/js/leaflet/leaflet.markercluster.js",
        "assets/js/shipyards/country_geodata.js",
        "assets/js/shipyards/jquery.dataTables.min.js",
        "assets/js/shipyards/map_on_catalog_item.js"
    ));
?>

<script>
    var companies = [];
    var companyMakers = [];
    $(document).ready(function() {
        companies = <?php echo json_encode($json_str); ?>;
        initMap(companies);
        loadRepairTable();
        loadNewBuildTable();
        loadScrappingTable();
    });

    loadRepairTable = function() {
        const data = <?php echo json_encode($repair_list); ?>;
        if (data.length > 0) {
            $("#repair_tab").show();
            $("#repair-table").DataTable({
                columns: [
                    { title: '<?php echo app_lang("shipyard_name") ?>'},
                    { title: '<?php echo app_lang("services") ?>'},
                    { title: '<?php echo app_lang("country") ?>'},
                    { title: '<?php echo app_lang("maxLength") ?>'},
                    { title: '<?php echo app_lang("maxWidth") ?>'},
                    { title: '<?php echo app_lang("maxDepth") ?>'},
                    { title: '<?php echo app_lang("phone") ?>'}
                ],
                data: data,
                pageLength: 10,
                bLengthChange: false,
                scrollCollapse: true,
                searching: false,
                bInfo: false,
                drawCallback: () => {
                    popover();
                }
            });
        } else {
            $("#repair_tab").hide();
        }
    };

    loadNewBuildTable = function(selector) {
        const data = <?php echo json_encode($new_build_list); ?>;
        if (data.length > 0) {
            $("#newbuild_tab").show();
            $("#new-build-table").DataTable({
                columns: [
                    { title: '<?php echo app_lang("shipyard_name") ?>'},
                    { title: '<?php echo app_lang("services") ?>'},
                    { title: '<?php echo app_lang("country") ?>'},
                    { title: '<?php echo app_lang("maxLength") ?>'},
                    { title: '<?php echo app_lang("maxWidth") ?>'},
                    { title: '<?php echo app_lang("maxDepth") ?>'},
                    { title: '<?php echo app_lang("phone") ?>'}
                ],
                data: data,
                pageLength: 10,
                bLengthChange: false,
                scrollCollapse: true,
                searching: false,
                bInfo: false,
                drawCallback: () => {
                    popover();
                }
            });
        } else {
            $("#newbuild_tab").hide();
        }
    };

    loadScrappingTable = function(selector) {
        const data = <?php echo json_encode($scrapping_list); ?>;
        if (data.length > 0) {
            $("#scrapping_tab").show();
            $("#scrapping-table").DataTable({
                columns: [
                    { title: '<?php echo app_lang("shipyard_name") ?>'},
                    { title: '<?php echo app_lang("services") ?>'},
                    { title: '<?php echo app_lang("country") ?>'},
                    { title: '<?php echo app_lang("maxLength") ?>'},
                    { title: '<?php echo app_lang("maxWidth") ?>'},
                    { title: '<?php echo app_lang("maxDepth") ?>'},
                    { title: '<?php echo app_lang("phone") ?>'}
                ],
                data: data,
                pageLength: 10,
                bLengthChange: false,
                scrollCollapse: true,
                searching: false,
                bInfo: false,
                drawCallback: () => {
                    popover();
                }
            });
        } else {
            $("#scrapping_tab").hide();
        }
    };
</script>