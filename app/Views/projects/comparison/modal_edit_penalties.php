<div class="modal-body">
    <h3>Set Penalties of <?php echo $shipyard_info->title;?></h3>
    <div class="row" >
        <div class="col-md-6" >
            <div class="form-groud" >
                <div class="input-group mb-3">
                    <input type="number" class="form-control" value="0.00">
                    <span class="input-group-text" ><?php echo $project_info->currency?$project_info->currency:"USD"; ?></span>
                </div>
            </div>
            <div class="form-group" >
                <label>Penalty Limitations</label>
                <div class="input-group">
                    <input type="number" max="100" min="0" class="form-control input-penality-limitation" value="0.00">
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
<script>
    $(document).ready(function(){
        $(".save-penalties-<?php echo $shipyard_info->id;?>").on("click",function(){
            console.log($(this))
        })
    })
</script>