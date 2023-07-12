<div class="modal-body clearfix general-form">
    <div class="container-fluid">
        <div class="form-group">
            <div class="col-md-12 notepad-title">
                <span><?php echo app_lang("internal_id") ?>: <strong><?php echo $model_info->internal_id; ?></strong><span>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <p>WLL - Working Load Limit [ts]</p>
                <p>WL - Working Length [m]</p>
                <p>BL - Break Load [kN]</p>
                <p>Internal ID - T-WLL-Group-#</p>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("item_description"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->item_description; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span>WLL [TS]:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->wll; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span>WL [m]:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->wl; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("type"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->type; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span>BL [kN]:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->bl; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span>Qty:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->qty; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("icc"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->icc; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("certificate_number"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->certificate_number; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("certificate_type"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->certificate_type; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("tag_marking"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->tag_marking; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("manufacturer"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->manufacturer; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("supplied_date"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->supplied_date; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("supplied_place"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->supplied_place; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("lifts"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->lifts; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("date_of_discharged"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->date_of_discharged; ?></strong>
            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <?php
    echo modal_anchor(get_uri("misc/info_modal_form/" . $model_info->client_id), "<i data-feather='edit-2' class='icon-16'></i> " . app_lang('edit'), array("class" => "btn btn-default", "data-post-id" => $model_info->id, "title" => app_lang('edit_item')));
    ?>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>