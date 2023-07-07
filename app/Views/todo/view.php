<div class="modal-body clearfix general-form">
    <div class="container-fluid">
        <div class="form-group">
            <div  class="col-md-12 notepad-title">
                <strong><?php echo $model_info->title; ?></strong>
            </div>
        </div>

        <div class="col-md-12 mb15">
            <?php
            $date = "";
            $todo_labels = "";
            $labels_data = make_labels_view_data($model_info->labels_list);
            if ($labels_data) {
                $todo_labels .= "<div class='meta float-start mt5 mr5'>$labels_data</div>";
            }

            $todo_checklist_status = "";
            $checklist_label_color = "#6690F4";

            if ($model_info->total_checklist_checked <= 0) {
                $checklist_label_color = "#E18A00";
            } else if ($model_info->total_checklist_checked == $model_info->total_checklist) {
                $checklist_label_color = "#01B392";
            }

            if ($model_info->total_checklist) {
                $todo_checklist_status .= "<div class='meta float-start badge rounded-pill mr5' style='background-color:$checklist_label_color'><span data-bs-toggle='tooltip' title='" . app_lang("checklist_status") . "'><i data-feather='check' class='icon-14'></i> $model_info->total_checklist_checked/$model_info->total_checklist</span></div>";
            }

            if (is_date_exists($model_info->start_date)) {
                $date = format_to_date($model_info->start_date, false);
            }

            echo $todo_labels . $todo_checklist_status . "<div class='pt5'>" . $date . "</div>";
            ?>
        </div>

        <?php if ($model_info->description) { ?>
            <div class="col-md-12 mb15 notepad">
                <?php
                echo $model_info->description ? nl2br(link_it(process_images_from_content($model_info->description))) : "";
                ?>
            </div>
        <?php } ?>


    </div>
</div>

<div class="modal-footer">
    <?php
    echo modal_anchor(get_uri("todo/modal_form/"), "<i data-feather='edit-2' class='icon-16'></i> " . app_lang('edit'), array("class" => "btn btn-default", "data-post-id" => $model_info->id, "title" => app_lang('edit')));
    ?>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>