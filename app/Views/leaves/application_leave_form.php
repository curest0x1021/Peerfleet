<?php echo form_open(get_uri("leaves/save_live_days"), array("id" => "leave-form", "class" => "general-form", "role" => "form")); ?>
<div id="leaves-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">
            <?php if ($form_type == "assign_leave") { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="applicant_id" class=" col-md-3"><?php echo app_lang('team_member'); ?></label>
                        <div class=" col-md-9">
                            <?php
                            if (isset($team_members_info)) {
                                $image_url = get_avatar($team_members_info->image);
                                echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span>" . $team_members_info->first_name . " " . $team_members_info->last_name;
                                ?>
                                <input type="hidden" name="applicant_id" value="<?php echo $team_members_info->id; ?>" />
                                <?php
                            } else {
                                echo form_dropdown("applicant_id", $team_members_dropdown, "", "class='select2 validate-hidden' id='applicant_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <div class="form-group">
                <div class="row">
                    <label for="leave_days" class=" col-md-3"><?php echo app_lang('leave_days'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "leave_days",
                            "name" => "leave_days",
                            "value" => $team_members_info->leave_days,
                            "class" => "form-control",
                            "placeholder" => app_lang('leave_days'),
                            "autofocus" => true,
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <?php echo view("includes/dropzone_preview"); ?>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#leave-form").appForm({
            onSuccess: function (result) {
                location.reload();
            }
        });

    });
</script>
