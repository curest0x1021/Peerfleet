<?php
    $json_str = json_decode(json_encode($companies), true);
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
                    <div id="shipyards-repair" class="mt20">
                        <h2 class="gradient-title title-content"><?php echo app_lang("shipyards_for_repair"); ?></h2>
                        <div class="table-responsive">
                            <table id="repair-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                    <div id="shipyards-new-build" class="mt20">
                        <h2 class="gradient-title title-content"><?php echo app_lang("shipyards_for_new_build"); ?></h2>
                        <div class="table-responsive">
                            <table id="new-build-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                    <div id="shipyards-scrapping" class="mt20">
                        <h2 class="gradient-title title-content"><?php echo app_lang("shipyards_for_scrapping"); ?></h2>
                        <div class="table-responsive">
                            <table id="scrapping-table" class="display" cellspacing="0" width="100%">
                            </table>
                        </div>
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
    $(document).ready(function() {
        companies = <?php echo json_encode($json_str); ?>;
        loadRepairTable();
        loadNewBuildTable();
        loadScrappingTable();

        initMap(companies);
    });

    loadRepairTable = function() {
        const data = <?php echo json_encode($repair_list); ?>;
        if (data.length > 0) {
            $("#shipyards-repair").show();
            $("#repair-table").DataTable({
                columns: [
                    { title: '<?php echo app_lang("shipyard_name") ?>'},
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
            });
        } else {
            $("#shipyards-repair").hide();
        }
    };

    loadNewBuildTable = function(selector) {
        const data = <?php echo json_encode($new_build_list); ?>;
        if (data.length > 0) {
            $("#shipyards-new-build").show();
            $("#new-build-table").DataTable({
                columns: [
                    { title: '<?php echo app_lang("shipyard_name") ?>'},
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
            });
        } else {
            $("#shipyards-new-build").hide();
        }
    };

    loadScrappingTable = function(selector) {
        const data = <?php echo json_encode($scrapping_list); ?>;
        if (data.length > 0) {
            $("#shipyards-scrapping").show();
            $("#scrapping-table").DataTable({
                columns: [
                    { title: '<?php echo app_lang("shipyard_name") ?>'},
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
            });
        } else {
            $("#shipyards-scrapping").hide();
        }
    };
</script>