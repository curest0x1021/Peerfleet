<?php
$numberYards=count($allYards);
$categorizedTasks=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "Systems machinery main components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);
foreach ($allProjectTasks as $index => $oneTask) {
    $categorizedTasks[$oneTask->category][]=$oneTask;
}
?>
<style>
    
    table{
        min-width:100%;
        border:1px solid lightgray;
        border-collapse: collapse;
        
    }
    tr{
        border:1px solid lightgray;
    }
    th{
        border:1px solid lightgray;
        min-width:15vw;
        max-width:15vw;
        padding:5px;
    }
    .row-body{
        border:1px solid lightgray;
        min-width:15vw;
        max-width:15vw;
        padding:5px;
    }
    .row-header{
        flex-grow:1;
        max-width:80vw;
    }
    
    
</style>
<div class="card" >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-8" >
                <h2>Comparison View</h2>
            </div>
            <div class="col-md-2" >
            </div>
            <div class="col-md-2" >
                <a style="float:right" href="<?php echo get_uri('projects/add_yard/'.$project_info->id,["project_info"=>$project_info]); ?>" class="btn btn-primary"  >Add Yard Candidate</a>
            </div>
            
        </div>
        
        <div class="d-flex" style="overflow-x:auto;padding:10px;" >
            <!--Main Info-->
            
            
            <table class=""  >
                <thead>
                    <tr>
                        <th class="row-header" ></th>
                        <?php
                        for ($i=0; $i <$numberYards ; $i++) { 
                            
                        ?>
                        <th class="row-body">
                            <?php echo modal_anchor(get_uri('projects/modal_select_yard/'.$allYards[$i]->id),'<button class="btn btn-primary btn-select-yard-candidate" >Select candidate</button>',array());?>
                        </th>
                        <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th></th>
                        <?php
                        for ($i=0; $i <$numberYards ; $i++) { 
                            # code...
                        
                            # code...
                        ?>  
                            <th class="row-body" >
                                <div class="d-flex" >
                                    <div class="flex-grow-1" ><?php echo $allYards[$i]->title;?></div>
                                    <div class="dropdown" >
                                        <button class="btn btn-sm btn-default dropdown-toggle" data-bs-toggle="dropdown" >
                                            <i data-feather="more-vertical" ></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo get_uri('projects/download_yard_xlsx/'.$allYards[$i]->id);?>" target="_blank">Export xlsx</a></li>
                                            <li><?php echo modal_anchor(get_uri('projects/modal_import_yard_xlsx/'.$allYards[$i]->id),'<li class="dropdown-item" >Import quotation</l1>',array());?></li>
                                            <li><?php echo modal_anchor(get_uri('projects/modal_yard_add_files/'.$allYards[$i]->id),'<li class="dropdown-item" >Add files</l1>',array());?></li>
                                            <li><?php echo modal_anchor(get_uri('projects/modal_select_yard/'.$allYards[$i]->id),'<li class="dropdown-item" >Select candidate</l1>',array());?></li>
                                        </ul>
                                    </div>
                                </div>
                            </th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SUMMARY</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body"></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>TOTAL COST</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body">0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Sum of Yard Quotes</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body">0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Sum of Estimates</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body">0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </tbody>
            <!-- </table>
            <table class="table table-bordered table-hover"  > -->
                <thead>
                    <tr>
                        <th>Owner's Supply</th>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <th class="row-body">0</th>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            <!-- </table> -->
            <!--General-->
            <!-- <table class="table table-bordered table-hover"  > -->
                <thead>
                    <tr>
                        <th>General</th>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <th class="row-body">0</th>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Deviation Cost</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body"></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Loss of Earnings</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body"></td>
                        <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Bunker Cost</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body"></td>
                        <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Other addtional expenditures at yard</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body"></td>
                        <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Total offhire period</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td class="row-body"></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Total repair period</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Days in dry dock</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Days at berth</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </tbody>
            <!-- </table> -->
            <!--Payment Terms-->
            <!-- <table class="table table-bordered table-hover"  > -->
                <thead>
                    <tr>
                        <th>Payment Terms</th>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <th  ></th>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Payment before Departure</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td data-bs-toggle="modal" data-bs-target="#edit-payment-term-modal">0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Payment within 30 days</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td data-bs-toggle="modal" data-bs-target="#edit-payment-term-modal">0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Payment within 60 days</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td data-bs-toggle="modal" data-bs-target="#edit-payment-term-modal">0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Payment within 90 days</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td data-bs-toggle="modal" data-bs-target="#edit-payment-term-modal">0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </tbody>
            <!-- </table> -->

            <!-- <table class="table table-bordered table-hover"  > -->
                <thead>
                    <tr>
                        <th>Penalties</th>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <th>0</th>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Penalty per day</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td data-bs-toggle="modal" data-bs-target="#edit-penalties-modal" >0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Penalty limitations</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td data-bs-toggle="modal" data-bs-target="#edit-penalties-modal" >-</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </tbody>
            <!-- </table> -->
            <!-- <table class="table table-bordered table-hover"  > -->
                
                <?php
                foreach ($categorizedTasks as $category => $oneList) {
                    $totalTaskCost=0;
                    $taskCosts=array();
                    foreach($oneList as $oneTask){
                        $costItems=json_decode($oneTask->cost_items);
                        if(!$costItems) $costItems=array();
                        $oneTaskCost=0;
                        foreach($costItems as $oneItem){
                            $totalTaskCost+=(float)$oneItem->unit_price*(float)$oneItem->quantity;
                            $oneTaskCost+=(float)$oneItem->unit_price*(float)$oneItem->quantity;
                        }
                        $taskCosts[]=array('count'=>count($costItems),'cost'=>$oneTaskCost);
                    }

                ?>
                <thead>
                    <tr>
                        <th><?php echo $category;?></th>
                        <?php for ($i=0; $i < $numberYards; $i++) {

                        ?>
                        <th><?php echo $totalTaskCost;?></th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($oneList as $index => $oneTask) {

                    ?>
                    <tr>
                        <td ><div style="max-width:10vw;word-wrap:break-word;" ><?php echo $oneTask->title; ?></div></td>
                        <?php for ($i=0; $i < $numberYards; $i++) {
                            $oneYard=$allYards[$i];
                            $oneYardCost=0;
                            $oneYardItems=array_filter($allYardCostItems,function($oneItem)use($oneTask,$oneYard){
                                return $oneTask->id==$oneItem->task_id&&$oneYard->id==$oneItem->shipyard_id;
                            });
                            foreach($oneYardItems as $oneItem){
                                $oneYardCost+= (float)$oneItem->quantity*(float)$oneItem->unit_price;
                            }
                        ?>
                            <td ><div class="d-flex" style="align-items:center;" >
                            <?php
                                echo modal_anchor(get_uri('projects/modal_yard_cost_items/'.$oneTask->id),'<span class="badge rounded-pill bg-secondary" >'.count($oneYardItems).'</span>',array());
                            ?>
                            <div class="flex-grow-1" ></div><?php echo $oneYardCost; ?></div></td>
                        <?php
                        } ?>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
                <?php
                    # code...
                }
                ?>
            </table>
            
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Modal body...
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal" id="edit-payment-term-modal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" class="payment-term-title">Edit Payment terms</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group" >
            <label>Payment before departure</label>
            <input class="form-control" />
        </div>
        <div class="form-group" >
            <label>Payment within 30 days</label>
            <input class="form-control" />
        </div>
        <div class="form-group" >
            <label>Payment within 60 days</label>
            <input class="form-control" />
        </div>
        <div class="form-group" >
            <label>Payment within 90 days</label>
            <input class="form-control" />
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Save</button>
      </div>

    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal" id="edit-penalties-modal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" class="penalties-title" >Edit Penalties</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-groud" >
            <div class="input-group mb-3">
                <span class="input-group-text">$</span>
                <input type="number" class="form-control" value="0.00">
                <input type="text" class="form-control" value="USD" readonly>
            </div>
        </div>
        <div class="form-group" >
            <label>Penalty Limitations</label>
            <input class="form-control" />
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Save</button>
      </div>

    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
    })
    $(".btn-select-yard-candidate").hover(function(){
        $(this).removeClass('btn-primary').addClass('btn-success');
    },function(){
        $(this).removeClass('btn-success').addClass('btn-primary');
    })
})

</script>