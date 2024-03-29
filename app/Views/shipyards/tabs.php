<ul id="shipyard-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
    <li class="<?php echo ($active_tab == 'country') ? 'active' : ''; ?>"><a id="country_tab" role="presentation" data-bs-toggle="tab" href="<?php echo get_uri("shipyards/country"); ?>"> <?php echo app_lang('by_country'); ?></a></li>
    <li class="<?php echo ($active_tab == 'region') ? 'active' : ''; ?>"><a id="region_tab" role="presentation" data-bs-toggle="tab" href="<?php echo get_uri("shipyards/region"); ?>"> <?php echo app_lang('by_region'); ?></a></li>
    <li class="<?php echo ($active_tab == 'sailingarea') ? 'active' : ''; ?>"><a id="sailingarea_tab" role="presentation" data-bs-toggle="tab" href="<?php echo get_uri("shipyards/sailingarea"); ?>"> <?php echo app_lang('by_sailing_area'); ?></a></li>
    <?php if ($show_checkboxs) { ?>
        <div class="tab-title clearfix no-border">
            <div class="title-button-group  d-flex align-items-center shipyards-title">
                <div class="checkbox">
                    <input id="service-2" type="checkbox" name="service-2" checked="checked">
                    <label for="service-2"><img src="/assets/images/shipyards/repair.png" title="Repairs" class="icon-service"/></label>
                </div>
                <div class="checkbox">
                    <input id="service-1" type="checkbox" name="service-1" checked="checked">
                    <label for="service-1"><img src="/assets/images/shipyards/newbuilding.png" title="New Buildings" class="icon-service"/></label>
                </div>
                <div class="checkbox">
                    <input id="service-3" type="checkbox" name="service-3" checked="checked">
                    <label for="service-3"><img src="/assets/images/shipyards/recycling.png" title="Scrapping" class="icon-service"/></label>
                </div>
            </div>
        </div>
    <?php } ?>
</ul>


<script>
    $(document).ready(function () {
        const active_tab = "<?php echo $active_tab; ?>";
        $("#country_tab").click(function(e) {
            window.location.href = "<?php echo_uri('shipyards/country'); ?>";
        });

        $("#region_tab").click(function(e) {
            window.location.href = "<?php echo_uri('shipyards/region'); ?>";
        });

        $("#sailingarea_tab").click(function(e) {
            window.location.href = "<?php echo_uri('shipyards/sailingarea'); ?>";
        });
    });
</script>