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
        "assets/js/shipyards/sailingarea_geodata.js",
        "assets/js/shipyards/map_on_catalog.js"
    ));
?>

<script>
    $(document).ready(function() {
        generateData();
        initMap();
    });

    function generateData() {
        var htmlData = "";
        var features = geoData.features.sort((a, b) => {
            if (a.properties.name < b.properties.name) {
                return -1;
            } else if (a.properties.name > b.properties.name) {
                return 1;
            }
            return 0;
        });
        features.forEach(k => {
            const sailingarea = k.properties.name;
            htmlData += `
                <div class="col-sm-3 mt10">
                    <a href="sailingarea/${k.id}" data-id="${k.id}" class="shipyard-text">${sailingarea}</a>
                </div>`;
        });

        $("#data-area").html(htmlData);
    }

    function lowercaseName(name) {
        const lower = name.toLowerCase().replace(/\s/g, '-');
    }
</script>