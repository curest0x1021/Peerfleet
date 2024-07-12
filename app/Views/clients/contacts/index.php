<div class="card">
    <div class="page-title clearfix">
        <h4> <?php echo app_lang('communication'); ?></h4>
        <div class="title-button-group">
            <?php
            if ($login_user->is_admin || get_array_value($login_user->permissions, "can_add_or_invite_new_team_members")) {
                // echo
                echo modal_anchor(get_uri("clients/client_general_modal_form") . "?client_id=" . $client_id, "<i data-feather='plus-circle' class='icon-16'></i> " . "Add crew", array("class" => "btn btn-default", "title" => "Add crew"));
            }
            ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="contact-table" class="display" width="100%">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var showCharterName = true;
        if ("<?php echo $client_id ?>") {
            showCharterName = false;
        }

        var showOptions = true;
        if (!"<?php echo $can_edit_clients; ?>") {
            showOptions = false;
        }

        var quick_filters_dropdown = <?php echo view("clients/contacts/quick_filters_dropdown"); ?>;
        if (window.selectedContactQuickFilter) {
            var filterIndex = quick_filters_dropdown.findIndex(x => x.id === window.selectedContactQuickFilter);
            if ([filterIndex] > -1) {
                //match found
                quick_filters_dropdown[filterIndex].isSelected = true;
            }
        }

        $("#contact-table").appTable({
            source: '<?php echo_uri("clients/contacts_list_data/" . $client_id) ?>',
            serverSide: true,
            order: [
                [1, "asc"]
            ],
            columns: [{
                title: '',
                "class": "w50 text-center"
            },
            {
                title: "<?php echo app_lang("name") ?>",
                "class": "w150",
                order_by: "first_name"
            },
            {
                visible: showCharterName,
                title: "<?php echo app_lang("client_name") ?>",
                "class": "w150",
                order_by: "charter_name"
            },
            {
                title: "<?php echo app_lang("email") ?>",
                "class": "w20p",
                order_by: "email"
            },
            {
                title: "<?php echo app_lang("sat") ?>",
                "class": "w100",
                order_by: "sat"
            },
            {
                title: "<?php echo app_lang("mobile") ?>",
                "class": "w100",
                order_by: "phone"
            },
            {
                title: "<?php echo app_lang("iridium_phone") ?>",
                "class": "w100",
                order_by: "mobile"
            },
            {
                title: '<i data-feather="menu" class="icon-16"></i>',
                "class": "text-center option w50",
                visible: showOptions
            }
            ],
            printColumns: [0, 1, 2, 3, 4, 5, 6],
            xlsColumns: [0, 1, 2, 3, 4, 5, 6]
        });
    });
</script>