<div class="modal-body clearfix general-form">
    <div class="container-fluid">
        <div class="form-group">
            <div class="col-md-12 notepad-title">
                <span><strong><?php echo $model_info->name . " (" . $model_info->description . ")"; ?></strong><span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group row">
                    <div class="col-md-5">
                        <span>No:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->no; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("category"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->category; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("name"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->name; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("description"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->description; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span>Qty:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->qty; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span>Length [mm]:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->length; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span>Width [mm]:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->width; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span>Height [mm]:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->height; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span>MSL [kN]:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->msl; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span>BL [kN]:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->bl; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("icc"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->icc; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("manufacturer"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->manufacturer; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("supplied_date"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->supplied_date; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("supplied_place"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->supplied_place; ?></strong>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <span><?php echo app_lang("property"); ?>:</span>
                    </div>
                    <div class="col-md-7">
                        <strong><?php echo $model_info->property; ?></strong>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <span>Length - Work Length or Total Length [mm]</span>
                </div>
                <div class="form-group">
                    <span>Width - Width / Diameter [mm]</span>
                </div>
                <div class="form-group">
                    <span>Height - Height [mm]</span>
                </div>
                <div class="form-group">
                    <span>MSL - Max Securing Load [kN]</span>
                </div>
                <div class="form-group">
                    <span>BL - Break Load [kN]</span>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <?php
    echo modal_anchor(get_uri("lashing/info_modal_form/" . $model_info->client_id), "<i data-feather='edit-2' class='icon-16'></i> " . app_lang('edit'), array("class" => "btn btn-default", "data-post-id" => $model_info->id, "title" => app_lang('edit_item')));
    ?>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>