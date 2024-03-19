<?php
$categorizedCostItems=array();
foreach ($allProjectYards as $oneYard) {
    $categorizedCostItems[$oneYard->id]=array();
    foreach(array_filter($allYardCostItems,function($element) use($oneYard){
        return (string)$element->shipyard_id == (string)$oneYard->id;
    }) as $oneItem){
        $categorizedCostItems[$oneYard->id][]=$oneItem;
    }
    
    
}
?>
<div class="modal-body clearfix"  >
    <div class="d-flex" style="overflow-x:auto; min-height:40vh;" >
        
    
        <?php
            foreach ($allProjectYards as $oneYard) {
                $id=$oneYard->id;
                $itemList=$categorizedCostItems[$oneYard->id];
        ?>
                
            <div class="card" style="min-width:30vw;" >
                <div class="card-header" ><?php echo $oneYard->title;?></div>
                <div class="card-body" id="yard-cost-items-panel-<?php echo $id;?>" >

                
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity & Unit</th>
                                <th>Discount</th>
                                <th>Quote</th>
                                <th><button class="btn btn-sm btn-default btn-start-edit-panel" ><i data-feather="plus-circle" class="icon-16" ></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($itemList as $oneItem) {
                            ?>
                            <tr>
                                <td><?php echo $oneItem->name;?></td>
                                <td><?php echo $oneItem->quantity;?> <?php echo $oneItem->measurement;?> X <?php echo $project_info->currency." ".$oneItem->unit_price;?> (Per unit) </td>
                                <td><?php echo $oneItem->discount;?> %</td>
                                <td><?php echo $project_info->currency." ".(double)$oneItem->total_cost;?> </td>
                                <td><input hidden value='<?php echo $oneItem->id;?>' /><button class="btn btn-sm delete-cost-item"><i data-feather="trash" class="icon-16" ></i></button></td>
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
                        <input hidden value=<?php echo $oneYard->id;?> name="shipyard_id" id="shipyard_id" />
                        <input hidden name="item_id" id="item_id" value="" />
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
                                    value="pcs"
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
                                        <option value="Per unit">Per unit</option>
                                        <option value="Lump sum" >Lump sum</option>
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
    $(".start-edit-cost-item").on('click',function(){
        $(this).parent().parent().parent().parent().parent().find(".edit-panel").prop('hidden',false);

    });
    $(".delete-cost-item").on("click",function(){
        
        console.log($(this).parent().find('input')[0].value);
        var trEl=$(this);
        $.ajax({
            url:'<?php echo get_uri('projects/delete_yard_cost_item');?>/'+trEl.parent().find('input')[0].value,
            method:"GET",
            success:function(response){
                if(JSON.parse(response).success) trEl.closest('tr').remove();
            }
        })
        
    });
    $(".btn-save-yard-cost-item").on("click",function(){
        var editPanelEl=$(this).parent().parent().parent();
        if(!editPanelEl.find("#name")[0].value) return;
        if(!editPanelEl.find("#unit_price")[0].value) return;
        if(!editPanelEl.find("#quantity")[0].value) return;
        var tbodyEl=$(this).parent().parent().parent().parent().find('table tbody');
        var data={
            shipyard_id:editPanelEl.find("#shipyard_id")[0].value,
            task_id:editPanelEl.find("#task_id")[0].value,
            project_id:editPanelEl.find("#project_id")[0].value,
            name:editPanelEl.find("#name")[0].value,
            description:editPanelEl.find("#description")[0].value,
            quantity:editPanelEl.find("#quantity")[0].value,
            unit_price:editPanelEl.find("#unit_price")[0].value,
            // currency:editPanelEl.find("#currency")[0].value,
            measurement:editPanelEl.find("#measurement")[0].value,
            quote_type:editPanelEl.find("#quote_type")[0].value,
            discount:editPanelEl.find("#discount")[0].value,
            yard_remarks:editPanelEl.find("#yard_remarks")[0].value,
        };
        $.ajax({
            url:'<?php echo get_uri('projects/save_yard_cost_item'); ?>',
            method:"POST",
            data:data,
            success:function(response){
                
                console.log(tbodyEl)
                var newRow = $(`
                <tr>
                <td>${editPanelEl.find("#name")[0].value}</td>
                <td>${editPanelEl.find("#quantity")[0].value} ${editPanelEl.find("#measurement")[0].value} X<?php echo " ".$project_info->currency." ";?> ${editPanelEl.find("#unit_price")[0].value} (per unit)</td>
                <td>${editPanelEl.find("#discount")[0].value} %</td>
                <td><?php echo " ".$project_info->currency." ";?>${parseFloat(editPanelEl.find("#quantity")[0].value)*parseFloat(editPanelEl.find("#unit_price")[0].value)*(100-parseFloat(editPanelEl.find("#discount")[0].value))/100}</td>
                <td><input hidden value="" /><button onclick="delete_cost_item(event)" class="btn btn-sm delete-cost-item" ><i data-feather="trash" class="icon-16"></i></button></td>
                </tr>`);
                tbodyEl.append(newRow);
                editPanelEl.find("#name")[0].value="";
                editPanelEl.find("#description")[0].value="";
                editPanelEl.find("#quantity")[0].value="";
                editPanelEl.find("#unit_price")[0].value="";
                editPanelEl.find("#measurement")[0].value="";
                editPanelEl.find("#discount")[0].value="";
                editPanelEl.find("#yard_remarks")[0].value="";
            }
        })

    })
})
function start_edit_cost_item(e){
    e.target.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector('.edit-panel').hidden=false;
}
function delete_cost_item(e){
    var tr=e.target.parentNode.parentNode;
    e.target.parentNode.parentNode.parentNode.removeChild(tr);
}
var all_cost_items=[];
<?php if(isset($allYardCostItems)) echo 'all_cost_items='.json_encode($allYardCostItems).';'; ?>
console.log(all_cost_items)
</script>
