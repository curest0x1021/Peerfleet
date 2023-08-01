<div class="modal-body clearfix" style="height: 768px; position: relative; overflow: auto;">
    <div class="container-fluid">
        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("id"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->id;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("name"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->name;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("country"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->country;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("description"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <span><?php echo $model_info->description;?></span>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("services"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <?php
                    $services = $model_info->services;
                    $services = str_replace("service-1", app_lang("new_buildings"), $services);
                    $services = str_replace("service-2", app_lang("repairs"), $services);
                    $services = str_replace("service-3", app_lang("scrapping"), $services);
                    $services = str_replace(",", ", ", $services);
                ?>
                <strong><?php echo $services;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("score"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->score;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("maxLength"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->maxLength;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("maxWidth"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->maxWidth;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("maxDepth"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->maxDepth;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("docksCount"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->docksCount;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("cranesCount"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->cranesCount;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("dock"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->dock;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("email"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->email;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("phone"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->phone;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("fax"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->fax;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("only_new_build"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->only_new_build == "1" ? app_lang("yes") : app_lang("no");?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("published"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->published == "1" ? app_lang("yes") : app_lang("no");?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("city"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->city;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("street"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->street;?></strong>
            </div>
        </div>

        <div class="form-group row">
            <div class="<?php echo $label_column; ?>">
                <span><?php echo app_lang("zip"); ?>:</span>
            </div>
            <div class="<?php echo $field_column; ?>">
                <strong><?php echo $model_info->zip;?></strong>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <?php
        if ($can_edit_items) {
            echo modal_anchor(get_uri("shipyards/modal_form"), "<i data-feather='edit-2' class='icon-16'></i> " . app_lang('edit'), array("class" => "btn btn-default", "data-post-id" => $model_info->id, "title" => app_lang('edit')));
        }
    ?>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>
