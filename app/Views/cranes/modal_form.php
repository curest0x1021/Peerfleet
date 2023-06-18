<?php echo form_open(get_uri("cranes/save"), array("id" => "crane-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("crane1", "1", true, "id='crane1' class='form-check-input'");
                            ?>
                        </div>
                        <label for="crane1" class="col-10"><?php echo app_lang('crane1') . app_lang('has_3_ropes'); ?></label>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("provision", "0", false, "id='provision' class='form-check-input'");
                            ?>
                        </div>
                        <label for="provision" class="col-10"><?php echo app_lang('provision') . app_lang('has_1_rope'); ?></label>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("crane2", "1", true, "id='crane2' class='form-check-input'");
                            ?>
                        </div>
                        <label for="crane2" class="col-10"><?php echo app_lang('crane2') . app_lang('has_3_ropes'); ?></label>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("rescueboat", "1", true, "id='rescueboat' class='form-check-input'");
                            ?>
                        </div>
                        <label for="rescueboat" class="col-10"><?php echo app_lang('rescueboat') . app_lang('has_2_ropes'); ?></label>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("crane3", "0", false, "id='crane3' class='form-check-input'");
                            ?>
                        </div>
                        <label for="crane3" class="col-10"><?php echo app_lang('crane3') . app_lang('has_3_ropes'); ?></label>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("liferaft", "1", true, "id='liferaft' class='form-check-input'");
                            ?>
                        </div>
                        <label for="liferaft" class="col-10"><?php echo app_lang('liferaft') . app_lang('has_1_rope'); ?></label>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("gangway", "1", true, "id='gangway' class='form-check-input'");
                            ?>
                        </div>
                        <label for="gangway" class="col-10"><?php echo app_lang('gangway') . app_lang('has_1_rope'); ?></label>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <?php
                            echo form_checkbox("freefallboat", "1", true, "id='freefallboat' class='form-check-input'");
                            ?>
                        </div>
                        <label for="freefallboat" class="col-10"><?php echo app_lang('freefallboat') . app_lang('has_2_ropes'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#crane-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {
                    duration: 10000
                });
                $("#crane-table").appTable({
                    reload: true
                });
            }
        });
    });
</script>