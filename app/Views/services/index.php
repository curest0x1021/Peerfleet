<div id="page-content" class="page-wrapper clearfix">
    <div class="clearfix grid-button">
        <ul id="service-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs title" role="tablist">
            <li><a role="presentation" data-bs-toggle="tab" class="active show"><?php echo app_lang('services'); ?></a></li>
            <?php if ($can_edit_items) { ?>
                <div class="tab-title clearfix no-border">
                    <div class="title-button-group">
                        <?php echo modal_anchor(get_uri("services/import_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
                        <?php echo modal_anchor(get_uri("services/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
                    </div>
                </div>
            <?php } ?>
        </ul>
        <div class="card">
        <div class="table-responsive">
            <table id="services-table" class="display" cellspacing="0" width="100%">
            </table>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $("#services-table").appTable({
            source: '<?php echo_uri("services/search") ?>',
            filterDropdown: [
                {name: "country_id", class: "w200", options:  <?php echo $country_dropdown; ?>},
            ],
            columns: [
                {title: '', "class": "all"},
                {visible: false, searchable: true},
            ],
            printColumns: [2, 3, 4, 6, 8],
            xlsColumns: [2, 3, 4, 6, 8],
            rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).addClass(aData[0]);
            }
        });

        var $searchBox = $("#service-search-box");
        var $spinningBtn = $(".spinning-btn");
        var $servicesitems = $("#services-items")
        $servicesitems.html(<?php echo $services_items; ?>);
        $searchBox.on("keyup", function (e) {
            if (e.which == 13) {
                //show/hide loder icon in searchbox
                if (this.value) {
                    $spinningBtn.addClass("spinning");
                } else {
                    $spinningBtn.removeClass("spinning");
                }

                $.ajax({
                    url: "<?php echo get_uri('services/search'); ?>",
                    data: {search: $searchBox.val()},
                    quietMillis: 250,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        //show a loader icon in search box
                        $spinningBtn.removeClass("spinning");
                        $servicesitems.html(response);
                    }
                });
            }
        });
    })
</script>