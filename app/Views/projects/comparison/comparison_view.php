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
<div class="card" >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-8" >
                <h2>Comparison View</h2>
            </div>
            <div class="col-md-2" >
                <a style="float:right" href="<?php echo get_uri('projects/add_yard/'.$project_info->id,["project_info"=>$project_info]); ?>" class="btn btn-primary"  >Add Yard Candidate</a>
            </div>
            <div class="col-md-2" >
            </div>
        </div>
        <div class="row d-flex justify-content-center" >
            <div class="col-md-8" >
            <!--Main Info-->
            <table class="table table-bordered table-hover"  >
                <thead>
                    <tr>
                        <th></th>
                        <?php
                        for ($i=0; $i <$numberYards ; $i++) { 
                            # code...
                        
                            # code...
                        ?>  
                            <th>
                                <div class="d-flex" >
                                    <div class="flex-grow-1" ><?php echo $allYards[$i]->title;?></div>
                                    <div class="dropdown" >
                                        <button class="btn btn-sm btn-default dropdown-toggle" data-bs-toggle="dropdown" >
                                            <i data-feather="more-vertical" ></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Export xlsx</a></li>
                                            <li><a class="dropdown-item" href="#">Import quotation</a></li>
                                            <li><a class="dropdown-item" href="#">Add files</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#select-candidate-modal">Select candidate</a></li>
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
                            <td></td>
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
                            <td>0</td>
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
                            <td>0</td>
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
                            <td>0</td>
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
                            <th>0</th>
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
                            <th>0</th>
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
                            <td></td>
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
                            <td></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Bunker Cost</td>
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
                        <td>Other addtional expenditures at yard</td>
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
                        <td>Total offhire period</td>
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
                        <td style="max-width:10vh;word-wrap:break-word;" ><?php echo $oneTask->title; ?></td>
                        <?php for ($i=0; $i < $numberYards; $i++) { 
                            ?>
                            <td ><div class="d-flex" style="align-items:center;" ><span class="badge rounded-pill bg-secondary" ><?php echo $taskCosts[$index]['count']; ?></span><div class="flex-grow-1" ></div><?php echo $taskCosts[$index]['cost']; ?></div></td>
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
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="select-candidate-modal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Yard Selection</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="card" >
            <h5>Selecting yard - Varaderos y Talleres de Mediterranea</h5>
            <p><i data-feather="info" ></i> Learn more about selecting yards.</p>
        </div>
        <div class="card" >
            <p>By selecting this yard, the quoted costs for this project. Data from any other yards will be hidden. This action is not reversible, but you can always edit the costs in execution phase.</p>
            <div class="card" style="background-color:lightyellow;border:1px solid brown;" >
                <ul>
                <p>
                    This action will move the project to the pre-Execution phase. This is the phase between yard selection and the actual yard visit(Execution)
                </p>
                <p>
                    Please note that the Deviation cost loss of earnings, Bunker cost and other additional expenditures at yard are not transfered to the cost.
                    In order to include these in the project's total cost, you should add these on the Owner's supply page.
                </p>
                </ul>
            </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Select</button>
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
})

</script>