<div id="ajaxModalContent" >
<div class="modal-body" id="panel-edit-penalties">
    <h3>Set Penalties of <?php echo $shipyard_info->title;?></h3>
    <?php echo form_open(get_uri("projects/edit_penalties"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
    <?php echo form_close();?>
    <div class="row" >
        <div class="col-md-6" >
            <div class="form-groud" >
                <div class="input-group mb-3">
                    <input type="number" value="<?php echo $shipyard_info->penalty_per_day?$shipyard_info->penalty_per_day:0;?>" class="form-control input-penalty-price">
                    <span class="input-group-text" ><?php echo $project_info->currency?$project_info->currency:"USD"; ?></span>
                </div>
            </div>
            <div class="form-group" >
                <label>Penalty Limitations</label>
                <div class="input-group">
                    <input type="number" max="100" min="0" value="<?php echo $shipyard_info->penalty_limit?$shipyard_info->penalty_limit:0;?>" class="form-control input-penalty-limitation" value="0.00">
                    <span class="input-group-text" >%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary save-penalties-<?php echo $shipyard_info->id;?>" >Save</button>
</div>
</div>
<script>
    $(document).ready(function(){
        $(".save-penalties-<?php echo $shipyard_info->id;?>").on("click",function(){
            var penalty_price=$(".input-penalty-price")[0].value;
            var penalty_limit=$(".input-penalty-limitation")[0].value;
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            $.ajax({
                url:'<?php echo get_uri("projects/save_penalty");?>',
                method:"POST",
                data:{
                    price:penalty_price,
                    limit:penalty_limit,
                    rise_csrf_token:rise_csrf_token,
                    shipyard_id:<?php echo $shipyard_info->id;?>
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
                        window.panel_edit_penalties.closeModal()
                        window.location.reload();
                    }
                }
            })
        })
    })
    window.panel_edit_penalties=$("#panel-edit-penalties").appForm({
        closeModalOnSuccess:false
    })
</script>