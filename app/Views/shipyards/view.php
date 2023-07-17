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
                    <div id="map" style="width: 100%; height: 600px;"></div>
                    <div id="data-area" class="row m20"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    load_css(array(
        "assets/css/leaflet.css",
        "assets/css/MarkerCluster.Default.css",
        "assets/css/MarkerCluster.css",
        "assets/css/flag_icons.css",
        "assets/css/shipyards.css"
    ));
    load_js(array(
        "assets/js/shipyards/leaflet.js",
        "assets/js/shipyards/L.Control.Locate.min.js",
        "assets/js/shipyards/leaflet.markercluster.js",
        "assets/js/shipyards/country_geodata.js",
        "assets/js/shipyards/map_on_catalog_item.js"
    ));
?>

<script>
    var companies = [];
    $(document).ready(function() {
        companies = <?php echo json_encode($json_str); ?>;
        initMap(companies);
    });
</script>