<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="panel-edit-general" >
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
        value="<?php echo $shipyard_info->deviation_cost?$shipyard_info->deviation_cost:0; ?>"
        />
    </div>
    <div class="form-group" >
        <label>Loss of earnings:</label>
        <input
        id="loss_of_earnings"
        name="loss_of_earnings"
        type="number"
        class="form-control"
        value="<?php echo $shipyard_info->loss_of_earnings?$shipyard_info->loss_of_earnings:0; ?>"
        />
    </div>
    <div class="form-group" >
        <label>Bunker cost:</label>
        <input
        id="bunker_cost"
        name="bunker_cost"
        type="number"
        class="form-control"
        value="<?php echo $shipyard_info->bunker_cost?$shipyard_info->bunker_cost:0; ?>"
        />
    </div>
    <div class="form-group" >
        <label>Other additional expenditures at yards:</label>
        <input
        id="other_additional_expenditures"
        name="other_additional_expenditures"
        type="number"
        class="form-control"
        value="<?php echo $shipyard_info->additional_expenditures?$shipyard_info->additional_expenditures:0; ?>"
        />
    </div>
    <div class="form-group" >
        <label>Total offhire period:</label>
        <input
        id="total_offhire_period"
        name="total_offhire_period"
        type="number"
        class="form-control"
        value="<?php echo $shipyard_info->total_offhire_period?$shipyard_info->total_offhire_period:0; ?>"
        />
    </div>
    <div class="form-group" >
        <label>Total repair period:</label>
        <input
        id="total_repair_period"
        name="total_repair_period"
        type="number"
        class="form-control"
        value="<?php echo $shipyard_info->total_repair_period?$shipyard_info->total_repair_period:0; ?>"
        />
    </div>
    <div class="form-group" >
        <label>Days in dry dock:</label>
        <input
        id="days_in_dry_dock"
        name="days_in_dry_dock"
        type="number"
        class="form-control"
        value="<?php echo $shipyard_info->days_in_dry_dock?$shipyard_info->days_in_dry_dock:0; ?>"
        />
    </div>
    <div class="form-group" >
        <label>Days at berth:</label>
        <input
        id="days_at_berth"
        name="days_at_berth"
        type="number"
        class="form-control"
        value="<?php echo $shipyard_info->days_at_berth?$shipyard_info->days_at_berth:0; ?>"
        />
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="button" class="btn btn-primary btn-save-yards-general"><span data-feather="check" class="icon-16"></span> <?php echo app_lang('save'); ?></button> 
</div>
</div>
<script>
$(document).ready(function(){
    $(".btn-save-yards-general").on("click",function(){
        var rise_csrf_token = $('[name="rise_csrf_token"]').val();
        var shipyard_id=<?php echo $shipyard_info->id; ?>;
        var deviation_cost=$(this).parent().parent().find("#deviation_cost")[0].value;
        var loss_of_earnings=$(this).parent().parent().find("#loss_of_earnings")[0].value;
        var bunker_cost=$(this).parent().parent().find("#bunker_cost")[0].value;
        var other_additional_expenditures=$(this).parent().parent().find("#other_additional_expenditures")[0].value;
        var total_offhire_period=$(this).parent().parent().find("#total_offhire_period")[0].value;
        var total_repair_period=$(this).parent().parent().find("#total_repair_period")[0].value;
        var days_in_dry_dock=$(this).parent().parent().find("#days_in_dry_dock")[0].value;
        var days_at_berth=$(this).parent().parent().find("#days_at_berth")[0].value;
        var sendData={
            deviation_cost:deviation_cost,
            loss_of_earnings:loss_of_earnings,
            bunker_cost:bunker_cost,
            other_additional_expenditures:other_additional_expenditures,
            total_offhire_period:total_offhire_period,
            total_repair_period:total_repair_period,
            days_in_dry_dock:days_in_dry_dock,
            days_at_berth:days_at_berth
        };
        $.ajax({
            url:'<?php echo get_uri('projects/save_edit_yards_general');?>',
            method:'POST',
            data:{
                rise_csrf_token:rise_csrf_token,
                shipyard_id:shipyard_id,
                deviation_cost,
                loss_of_earnings,
                bunker_cost,
                other_additional_expenditures,
                total_offhire_period,
                total_repair_period,
                days_in_dry_dock,
                days_at_berth,
                data:sendData
            },
            success:function(response){
                if(JSON.parse(response).success){
                    $maskTarget=$("#ajaxModalContent").find(".modal-body");
                    var padding = $maskTarget.height() - 80;
                    if (padding > 0) {
                        padding = Math.floor(padding / 2);
                    }
                    $maskTarget.after("<div class='modal-mask'><div class='circle-loader'></div></div>");
                    //check scrollbar
                    var height = $maskTarget.outerHeight();
                    $('.modal-mask').css({"width": $maskTarget.width() + 22 + "px", "height": height + "px", "padding-top": padding + "px"});
                    $maskTarget.closest('.modal-dialog').find('[type="submit"]').attr('disabled', 'disabled');
                    $maskTarget.addClass("hide");
                    window.panel_edit_general.closeModal()
                    window.location.reload();
                }
            }
        })
    })
    window.panel_edit_general=$("#panel-edit-general").appForm({
        closeModalOnSuccess:false
    })
})
</script>