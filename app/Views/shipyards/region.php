<?php
    $htmlContent = "";
    foreach ($regions as $k) {
        $htmlContent .= '<div class="d-flex align-items-center col-sm-3 mt10">';
        $htmlContent .= '<a href="' . get_uri("shipyards/region/" . $k->id) . '" data-id="' . $k->id . '" class="shipyard-text">' . $k->name . '</a>';
        $htmlContent .= '</div>';
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
        "assets/css/shipyards.css"
    ));
    load_js(array(
        "assets/js/shipyards/leaflet.js",
        "assets/js/shipyards/region_geodata.js",
        "assets/js/shipyards/map_on_catalog.js"
    ));
?>

<script>
    $(document).ready(function() {
        $("#data-area").html('<?php echo $htmlContent; ?>');
        initMap();
    });
</script>