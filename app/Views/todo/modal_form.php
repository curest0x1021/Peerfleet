<?php echo form_open(get_uri("todo/save"), array("id" => "todo-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group row">
            <label for="title" class="<?php echo $label_column; ?>"><?php echo app_lang('title'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "title",
                    "name" => "title",
                    "value" => $model_info->title ?? "",
                    "class" => "form-control",
                    "placeholder" => app_lang('title'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => app_lang("field_required"),
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="<?php echo $label_column; ?>"><?php echo app_lang('description'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <div class="notepad">
                    <?php
                    echo form_textarea(array(
                        "id" => "description",
                        "name" => "description",
                        "value" => $model_info->description ? process_images_from_content($model_info->description, false) : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('description') . "...",
                        "data-rich-text-editor" => true
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="client_id" class="<?php echo $label_column; ?>"><?php echo app_lang('vessel'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "client_id",
                    "name" => "client_id",
                    "value" => $model_info->client_id ? $model_info->client_id : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('vessel'),
                    "autocomplete" => "off"
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="<?php echo $label_column; ?>"><?php echo app_lang('status'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "status",
                    "name" => "status",
                    "value" => $model_info->status ? $model_info->status : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('status'),
                    "autocomplete" => "off"
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="priority_id" class="<?php echo $label_column; ?>"><?php echo app_lang('priority'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "priority_id",
                    "name" => "priority_id",
                    "value" => $model_info->priority_id ? $model_info->priority_id : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('priority'),
                    "autocomplete" => "off"
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="labels" class="<?php echo $label_column; ?>"><?php echo app_lang('labels'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <div class="notepad">
                    <?php
                    echo form_input(array(
                        "id" => "todo_labels",
                        "name" => "labels",
                        "value" => $model_info->labels ? $model_info->labels : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('labels')
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="start_date" class="<?php echo $label_column; ?>"><?php echo app_lang('start_date'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "start_date",
                    "name" => "start_date",
                    "value" => is_date_exists($model_info->start_date) ? $model_info->start_date : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('start_date'),
                    "autocomplete" => "off"
                ));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="deadline" class="<?php echo $label_column; ?>"><?php echo app_lang('deadline'); ?></label>
            <div class="<?php echo $field_column; ?>">
                <?php
                echo form_input(array(
                    "id" => "deadline",
                    "name" => "deadline",
                    "value" => is_date_exists($model_info->deadline) ? $model_info->deadline : "",
                    "class" => "form-control",
                    "placeholder" => app_lang('deadline'),
                    "autocomplete" => "off"
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<!--checklist-->
<?php echo form_open(get_uri("todo/save_checklist_item"), array("id" => "checklist_form", "class" => "general-form", "role" => "form")); ?>
<div id="todo-checklist" class="m20">
    <div class="pb10 pt10">
        <strong class="float-start mr10"><?php echo app_lang("checklist"); ?></strong><span class="chcklists_status_count">0</span><span>/</span><span class="chcklists_count"></span>
    </div>
    <input type="hidden" name="todo_id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" id="is_checklist_group" name="is_checklist_group" value="" />

    <div class="checklist-items" id="checklist-items">

    </div>
    <div class="mb5 mt5 btn-group checklist-options-panel hide" role="group">
        <button id="type-new-item-button" type="button" class="btn btn-default checklist_button active"> <?php echo app_lang('type_new_item'); ?></button>
        <button id="select-from-template-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_template'); ?></button>
        <button id="select-from-checklist-group-button" type="button" class="btn btn-default checklist_button"> <?php echo app_lang('select_from_checklist_group'); ?></button>
    </div>
    <div class="form-group">
        <div class="mt5 p0">
            <?php
            echo form_input(array(
                "id" => "checklist-add-item",
                "name" => "checklist-add-item",
                "class" => "form-control",
                "placeholder" => app_lang('add_item'),
                "data-rule-required" => true,
                "data-msg-required" => app_lang("field_required"),
                "autocomplete" => "off"
            ));
            ?>
        </div>
    </div>
    <div class="mb10 p0 checklist-options-panel hide">
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('add'); ?></button>
        <button id="checklist-options-panel-close" type="button" class="btn btn-default ms-2"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#todo-form").appForm({
            onSuccess: function (result) {
                $("#todo-table").appTable({newData: result.data, dataId: result.id});
                //reload kanban
                $("#reload-kanban-button:visible").trigger("click");
            }
        });
        setTimeout(function () {
            $("#title").focus();
        }, 200);
        $("#todo_labels").select2({multiple: true, data: <?php echo json_encode($label_suggestions); ?>});
        $("#client_id").select2({ data: <?php echo $vessels_dropdown; ?>});
        $("#priority_id").select2({ data: <?php echo $priorities_dropdown; ?>});
        $("#status").select2({ data: <?php echo $status_dropdown; ?>});

        setDatePicker("#start_date");
        setDatePicker("#deadline");

        const id = '<?php echo $model_info->id; ?>';
        if (!id) {
            $("#todo-checklist").hide();
        }

        //make the checklist items sortable
        var $selector = $("#checklist-items");
        Sortable.create($selector[0], {
            animation: 150,
            chosenClass: "sortable-chosen",
            ghostClass: "sortable-ghost",
            onUpdate: function (e) {
                appLoader.show();
                //prepare checklist items indexes
                var data = "";
                $.each($selector.find(".checklist-item-row"), function (index, ele) {
                    if (data) {
                        data += ",";
                    }

                    data += $(ele).attr("data-id") + "-" + parseInt(index + 1);
                });

                //update sort indexes
                $.ajax({
                    url: '<?php echo_uri("todo/save_checklist_items_sort") ?>',
                    type: "POST",
                    data: {sort_values: data},
                    success: function () {
                        appLoader.hide();
                    }
                });
            }
        });

        //show the items in checklist
        $("#checklist-items").html(<?php echo $checklist_items; ?>);

        //show save & cancel button when the checklist-add-item-form is focused
        $("#checklist-add-item").focus(function () {
            $(".checklist-options-panel").removeClass("hide");
            $("#checklist-add-item-error").removeClass("hide");
        });

        $("#checklist-options-panel-close").click(function () {
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

            //reload kanban
            $("#reload-kanban-button:visible").trigger("click");
        }

        var checklists = $(".checklist-items .checklist-item-row").length;
        $(".delete-checklist-item").click(function () {
            checklists--;
            $(".chcklists_count").text(checklists);
        });

        count_checklists();

        var checklist_complete = $(".checklist-items .checkbox-checked").length;
        $(".chcklists_status_count").text(checklist_complete);

        $("#checklist_form").appForm({
            isModal: false,
            onSuccess: function (response) {
                $("#checklist-add-item").val("");
                $("#checklist-add-item").focus();
                $("#checklist-items").append(response.data);

                count_checklists();
            }
        });

        $('body').on('click', '[data-act=update-checklist-item-status-checkbox]', function () {
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
                url: '<?php echo_uri("todo/save_checklist_item_status") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {value: $(this).attr('data-value')},
                success: function (response) {
                    if (response.success) {
                        status_checkbox.closest("div").html(response.data);
                        //reload kanban
                        $("#reload-kanban-button:visible").trigger("click");
                    }
                }
            });
        });
    });
</script>