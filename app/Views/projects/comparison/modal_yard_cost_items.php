<?php
$categorizedCostItems=array();
foreach ($allProjectYards as $oneYard) {
    $categorizedCostItems[$oneYard->title]=array_filter($allYardCostItems,function($element){
        return $element->shipyard_id== $oneYard->id;
    });
}

?>
<div class="modal-body clearfix"  >
    <div class="d-flex" style="overflow-x:auto; min-height:40vh;" >
        
            
        <?php
            foreach ($allProjectYards as $oneYard) {
                $id=$oneYard->id;
                // $project_id=$oneYard->project_id;
                $itemList=$categorizedCostItems[$oneYard->title];
        ?>
            <div class="card" style="min-width:30vw;border:1px solid lightgray;margin-right:1vw;" >
                <div class="card-header" ><?php echo $oneYard->title;?></div>
                <div class="card-body" id="yard-cost-items-panel-<?php echo $id;?>" >
                    <table class="table table-hover table-bordered" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity & Unit</th>
                                <th>Quote</th>
                                <th><button class="btn btn-sm btn-default btn-start-edit-panel" ><i data-feather="plus-circle" ></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($itemList as $oneItem) {
                            ?>
                            <tr>

                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div hidden class="edit-panel" >
                        <input hidden name="id" id="id" />
                        <input hidden value="<?php echo $task_id;?>" name="task_id" id="task_id" />
                        <input hidden value="<?php echo $project_id;?>" name="project_id" id="project_id" />
                        <input hidden name="shipyard_id" id="shipyard_id" />
                        <div class="form-group" >
                            <label>Name:</label>
                            <input
                            id="name"
                            name="name"
                            class="form-control"
                            />
                        </div>
                        <div class="form-group" >
                            <label>Description:</label>
                            <textarea
                            id="description"
                            name="description"
                            class="form-control"
                            >
                            </textarea>
                        </div>
                        <div class="row" >
                            <div class="col-md-3" >
                                <div class="form-group" >
                                    <label>Quantity:</label>
                                    <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    class="form-control"
                                    value="1.0"
                                    />
                                </div>
                            </div>
                            <div class="col-md-3" >
                                <div class="form-group" >
                                    <label>Measurement:</label>
                                    <input
                                    id="measurement"
                                    name="measurement"
                                    class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group" >
                                    <label>Unit Price:</label>
                                    <input
                                    id="unit_price"
                                    name="unit_price"
                                    class="form-control"
                                    value="0.00"
                                    type="number"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-4" >
                                <div class="form-group" >
                                    <label>Quote Type:</label>
                                    <select id="quote_type" name="quote_type" class="form-control" >
                                        <option>Per unit</option>
                                        <option>Lump sum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2" >
                                <div class="form-group" >
                                    <label>discount:</label>
                                    <input
                                    id="discount"
                                    name="discount"
                                    class="form-control"
                                    type="number"
                                    value="0.00"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group" >
                                    <label>Yard Remarks:</label>
                                    <textarea
                                    id="yard_remarks"
                                    name="yard_remarks"
                                    class="form-control"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-2" >
                                <button class="btn-save-yard-cost-item btn btn-primary" >Save</button>
                            </div>
                            <div class="col-md-2" >
                                <button class="btn btn-default" >Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" ></div>
            </div>
        <?php
            }
        ?>
        
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>    
</div>
<script>
$(document).ready(function(){
    $(".modal-dialog").addClass('modal-xl').addClass('modal-dialog-centered');
    $(".btn-start-edit-panel").on("click",function(){
        if($(this).parent().parent().parent().parent().parent().find(".edit-panel").prop('hidden'))
            $(this).parent().parent().parent().parent().parent().find(".edit-panel").prop('hidden',false);
        else
            $(this).parent().parent().parent().parent().parent().find(".edit-panel").prop('hidden',true);
    });
    $(".btn-save-yard-cost-item").on("click",function(){
        var editPanelEl=$(this).parent().parent().parent();
        if(!editPanelEl.find("#name")[0].value) return;
        if(!editPanelEl.find("#unit_price")[0].value) return;
        if(!editPanelEl.find("#quantity")[0].value) return;
        var data={
            name:editPanelEl.find("#name")[0].value,
            description:editPanelEl.find("#description")[0].value,
            quantity:editPanelEl.find("#quantity")[0].value,
            unit_price:editPanelEl.find("#unit_price")[0].value,
            // currency:editPanelEl.find("#currency")[0].value,
            measurement_unit:editPanelEl.find("#measurement")[0].value,
            quote_type:editPanelEl.find("#quote_type")[0].value,
            discount:editPanelEl.find("#discount")[0].value,
        };
        $.ajax({
            url:'<?php echo get_uri('projects/save_yard_cost_item'); ?>',
            method:"POST",
            data:data,
            success:function(response){
                console.log($(this).parent().parent().parent().find('tbody'))
            }
        })

    })
})
</script>
