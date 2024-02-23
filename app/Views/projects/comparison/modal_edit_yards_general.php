
<div class="modal-body clearfix" >
    <h3> <?php echo 'Edit general information about '.$shipyard_info->title;  ?></h3>
    <?php echo form_open(get_uri("projects/save_edit_yards_general"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
    <?php echo form_close(); ?>
    <div class="form-group" >
        <label>Deviation cost:</label>
        <input
        id="deviation_cost"
        name="deviation_cost"
        type="number"
        class="form-control"
        />
    </div>
    <div class="form-group" >
        <label>Loss of earnings:</label>
        <input
        id="loss_of_earnings"
        name="loss_of_earnings"
        type="number"
        class="form-control"
        />
    </div>
    <div class="form-group" >
        <label>Bunker cost:</label>
        <input
        id="bunker_cost"
        name="bunker_cost"
        type="number"
        class="form-control"
        />
    </div>
    <div class="form-group" >
        <label>Other additional expenditures at yards:</label>
        <input
        id="other_additional_expenditures"
        name="other_additional_expenditures"
        type="number"
        class="form-control"
        />
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>    
</div>