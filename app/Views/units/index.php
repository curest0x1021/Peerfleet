<div id="page-content" class="page-wrapper clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "units";
            echo view("settings/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="card">
                <div class="page-title clearfix">
                    <h4> <?php echo app_lang('units'); ?></h4>
                    <div class="title-button-group">
                        <?php echo modal_anchor(get_uri("units/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_unit'), array("class" => "btn btn-default", "title" => app_lang('add_unit'))); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="unit-table" class="display" cellspacing="0" width="100%">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#unit-table").appTable({
            source: '<?php echo_uri("units/list_data") ?>',
            order: [[1, "asc"]],
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo app_lang("code") ?>'},
                {title: '<?php echo app_lang("name") ?>'},
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [1, 2],
            xlsColumns: [1, 2]
        });
    });
</script>