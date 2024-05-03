<div class="clearfix default-bg">

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <?php echo view("projects/project_progress_chart_info"); ?>
                </div>
                <div class="col-md-6 col-sm-12" >
                    <?php echo view("projects/project_task_pie_chart"); ?>
                </div>

                <div class="col-md-12 col-sm-12">
                    <?php echo view("projects/project_description"); ?>
                </div>

                <div class="col-md-12 col-sm-12 project-custom-fields">
                    <?php echo view('projects/custom_fields_list', array("custom_fields_list" => $custom_fields_list)); ?>
                </div>

                <?php if ($project_info->estimate_id) { ?>
                    <div class="col-md-12 col-sm-12">
                        <?php echo view("projects/estimates/index"); ?>
                    </div> 
                <?php } ?>

                <?php if ($project_info->order_id) { ?>
                    <div class="col-md-12 col-sm-12">
                        <?php echo view("projects/orders/index"); ?>
                    </div>
                <?php } ?>

                <?php if ($can_add_remove_project_members) { ?>
                    <div class="col-md-12 col-sm-12">
                        <?php echo view("projects/project_members/index"); ?>
                    </div>  
                <?php } ?>

                <?php if ($can_access_clients && $project_info->project_type === "client_project") { ?>
                    <div class="col-md-12 col-sm-12">
                        <?php echo view("projects/supplier_contacts/index"); ?>
                    </div>  
                <?php } ?>

            </div>
        </div>
        <div class="col-md-6">
            <?php echo view("projects/overview/completion_dates"); ?>
            <!--checklist-->
            <?php echo form_open(get_uri("tasks/save_checklist_item"), array("id" => "checklist_form", "class" => "general-form", "role" => "form")); ?>
            <div class="col-md-12 mb15 b-t p10 card" style="min-height:20vh;">
                <div class="pb10 pt10">
                    <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count">0</span><span>/</span><span class="chcklists_count"></span>
                </div>
                <input type="hidden" id="is_checklist_group" name="is_checklist_group" value="" />

                <div class="checklist-items" id="checklist-items">

                </div>
            </div>
            <?php echo form_close(); ?>
            <div class="card project-activity-section mt10" style="min-height:20vh;">
                <div class="card-header">
                    <h4><?php echo app_lang('activity'); ?></h4>
                </div>
                <?php echo view("projects/history/index"); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    RELOAD_PROJECT_VIEW_AFTER_UPDATE = true;

    $(document).ready(function () {
        //make the checklist items sortable
        var $selector = $("#checklist-items");
        Sortable.create($selector[0], {
            animation: 150,
            chosenClass: "sortable-chosen",
            ghostClass: "sortable-ghost",
            onUpdate: function(e) {
                appLoader.show();
                //prepare checklist items indexes 
                var data = "";
                $.each($selector.find(".checklist-item-row"), function(index, ele) {
                    if (data) {
                        data += ",";
                    }

                    data += $(ele).attr("data-id") + "-" + parseInt(index + 1);
                });

                //update sort indexes
                $.ajax({
                    url: '<?php echo_uri("tasks/save_checklist_items_sort") ?>',
                    type: "POST",
                    data: {
                        sort_values: data
                    },
                    success: function() {
                        appLoader.hide();
                    }
                });
            }
        });

        //add a clickable link in task title.

        //show the items in checklist
        $("#checklist-items").html(<?php echo $checklist_items; ?>);

        //show save & cancel button when the checklist-add-item-form is focused
        $("#checklist-add-item").focus(function() {
            $(".checklist-options-panel").removeClass("hide");
            $("#checklist-add-item-error").removeClass("hide");
        });

        $("#checklist-options-panel-close").click(function() {
            $(".checklist-options-panel").addClass("hide");
            $("#checklist-add-item-error").addClass("hide");
            $("#checklist-add-item").val("");

            $("#checklist-add-item").select2("destroy").val("");
            $("#checklist-template-toggle-button").html("<?php echo "<i data-feather='hash' class='icon-16'></i> " . app_lang('select_from_template'); ?>");
            $("#checklist-template-toggle-button").addClass('checklist-template-button');
            feather.replace();

            $(".checklist_button").removeClass("active");
            $("#type-new-item-button").addClass("active");
        });

        //count checklists
        function count_checklists() {
            var checklists = $(".checklist-items .checklist-item-row").length;
            $(".chcklists_count").text(checklists);
        }

        var checklists = $(".checklist-items .checklist-item-row").length;
        $(".delete-checklist-item").click(function() {
            checklists--;
            $(".chcklists_count").text(checklists);
        });

        count_checklists();

        var checklist_complete = $(".checklist-items .checkbox-checked").length;
        $(".chcklists_status_count").text(checklist_complete);

        $("#checklist_form").appForm({
            isModal: false,
            onSuccess: function(response) {
                $("#checklist-add-item").val("");
                $("#checklist-add-item").focus();
                $("#checklist-items").append(response.data);

                count_checklists();
                window.reloadKanban = true;
            }
        });

        $('body').on('click', '[data-act=update-checklist-item-status-checkbox]', function() {
            var status_checkbox = $(this).find("span");
            status_checkbox.removeClass("checkbox-checked");
            status_checkbox.addClass("inline-loader");

            if ($(this).attr('data-value') == 0) {
                checklist_complete--;
                $(".chcklists_status_count").text(checklist_complete);
            } else {
                checklist_complete++;
                $(".chcklists_status_count").text(checklist_complete);
            }

            $.ajax({
                url: '<?php echo_uri("tasks/save_checklist_item_status") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {
                    value: $(this).attr('data-value')
                },
                success: function(response) {
                    if (response.success) {
                        status_checkbox.closest("div").html(response.data);
                        window.reloadKanban = true;
                    }
                }
            });
        });

        //change the add checklist input box type
        $("#select-from-template-button").click(function () {
            $(".checklist_button").removeClass("active");
            applySelect2OnChecklistTemplate();
            $(this).addClass("active");
            $("#is_checklist_group").val("0");
        });

        $("#select-from-checklist-group-button").click(function () {
            $(".checklist_button").removeClass("active");
            applySelect2OnChecklistGroup();
            $(this).addClass("active");
            $("#is_checklist_group").val("1");
        });

        $("#type-new-item-button").click(function () {
            $(".checklist_button").removeClass("active");
            $("#checklist-add-item").select2("destroy").val("").focus();
            $("#is_checklist_group").val("0");
            $(this).addClass("active");
        });

        function applySelect2OnChecklistTemplate() {
            $("#checklist-add-item").select2({
                showSearchBox: true,
                ajax: {
                    url: "<?php echo get_uri("checklist_template/get_checklist_template_suggestion"); ?>",
                    type: 'POST',
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term, page) {
                        return {
                            q: term, // search term
                            project_id: "<?php echo $project_id; ?>"
                        };
                    },
                    results: function (data, page) {
                        return {results: data};
                        $("#checklist-add-item").val("");
                    }
                }
            });
        }

        function applySelect2OnChecklistGroup() {
            $("#checklist-add-item").select2({
                showSearchBox: true,
                ajax: {
                    url: "<?php echo get_uri("checklist_groups/get_checklist_group_suggestion"); ?>",
                    type: 'POST',
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term, page) {
                        return {
                            q: term, // search term
                            project_id: "<?php echo $project_id; ?>"
                        };
                    },
                    results: function (data, page) {
                        return {results: data};
                        $("#checklist-add-item").val("");
                    }
                }
            });
        }
    });
</script>