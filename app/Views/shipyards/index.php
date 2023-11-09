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
                    <div id="data-area" class="row m20"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    load_css(array(
        "assets/css/leaflet.css",
        "assets/css/leaflet-gesture-handling.min.css",
        "assets/css/flag_icons.css",
        "assets/css/shipyards.css"
    ));
    load_js(array(
        "assets/js/leaflet/leaflet.js",
        "assets/js/leaflet/leaflet-gesture-handling.min.js"
    ));

    if ($active_tab == "region") {
        load_js(array("assets/js/shipyards/region_geodata.js"));
    } else if ($active_tab == "sailingarea") {
        load_js(array("assets/js/shipyards/sailingarea_geodata.js"));
    } else {
        load_js(array("assets/js/shipyards/country_geodata.js"));
    }
    load_js(array("assets/js/shipyards/map_on_catalog.js"));
?>

<script>
    $(document).ready(function() {
        $("#data-area").html('<?php echo $htmlContent; ?>');
        initMap();
    });
</script>