<?php
$numberYards=count($allYards);
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
            </table>
            <!--Owner's Supply-->
            <table class="table table-bordered table-hover"  >
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
            </table>
            <!--General-->
            <table class="table table-bordered table-hover"  >
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
            </table>
            <!--Payment Terms-->
            <table class="table table-bordered table-hover"  >
                <thead>
                    <tr>
                        <th>Payment Terms</th>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <th></th>
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
                            <td>0</td>
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
                            <td>0</td>
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
                            <td>0</td>
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
                            <td>0</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-hover"  >
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
                            <td>0</td>
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
                            <td>-</td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-hover"  >
                <thead>
                    <tr>
                        <th>1. Docking & general services</th>
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
                        <td>Docking and undocking</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Agent</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Wharfage dues</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Towage</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Agent</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Garbage removal</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Gas free certificate</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Cooling water supply</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Fire water supply</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Ballast water supply</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Portable water supply</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Compressed air supply</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Crane service</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Heating lamps</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Telephone and Internet</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Power supply</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Sewage disposal</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Ventilation</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Scuppers</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>Cleaning</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>test</td>
                        <?php
                        for ($i=0; $i < $numberYards; $i++) { 
                        ?>
                            <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <?php
                            # code...
                        }
                        ?>
                    </tr>
                </tbody>
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
  <div class="modal-dialog modal-xl">
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