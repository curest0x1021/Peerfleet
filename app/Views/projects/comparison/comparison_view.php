<div class="card" >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-8" >
                <h2>Comparison View</h2>
            </div>
            <div class="col-md-2" >
                <a style="float:right" href="<?php echo get_uri('projects/add_yard/'.$project_info->id,["project_info"=>$project_info]); ?>" class="btn btn-default"  >Add Yard Candidate</a>
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
                        <th>
                            <div class="d-flex" >
                                <div class="flex-grow-1" >First Yard</div>
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
                        <th>
                            <div class="d-flex" >
                                <div class="flex-grow-1" >Second Yard</div>
                                <div class="dropdown" >
                                    <button class="btn btn-sm btn-default dropdown-toggle" data-bs-toggle="dropdown" style="float:right"  >
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
                        <th>
                            <div class="d-flex" >
                                <div class="flex-grow-1" >Third Yard</div>
                                <div class="dropdown" >
                                    <button class="btn btn-sm btn-default dropdown-toggle" data-bs-toggle="dropdown" style="float:right"  >
                                        <i data-feather="more-vertical" ></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Export xlsx</a></li>
                                        <li><a class="dropdown-item" href="#">Import quotation</a></li>
                                        <li><a class="dropdown-item" href="#">Add files</a></li>
                                        <li><a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#select-candidate-modal">Select candidate</a></li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SUMMARY</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>TOTAL COST</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Sum of Yard Quotes</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Sum of Estimates</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
            <!--Owner's Supply-->
            <table class="table table-bordered table-hover"  >
                <thead>
                    <tr>
                        <th>Owner's Supply</th>
                        <th></th>
                        <th></th>
                        <th></th>
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
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Deviation Cost</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Loss of Earnings</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Bunker Cost</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Other addtional expenditures at yard</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Total offhire period</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Total repair period</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Days in dry dock</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Days at berth</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
            <!--Payment Terms-->
            <table class="table table-bordered table-hover"  >
                <thead>
                    <tr>
                        <th>Payment Terms</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Payment before Departure</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Payment within 30 days</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Payment within 60 days</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Payment within 90 days</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-hover"  >
                <thead>
                    <tr>
                        <th>Penalties</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Penalty per day</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Penalty limitations</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-hover"  >
                <thead>
                    <tr>
                        <th>1. Docking & general services</th>
                        <th>0</th>
                        <th>0</th>
                        <th>0</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Docking and undocking</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Agent</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Wharfage dues</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Towage</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Agent</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Garbage removal</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Gas free certificate</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Cooling water supply</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Fire water supply</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Ballast water supply</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Portable water supply</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Compressed air supply</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Crane service</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Heating lamps</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Telephone and Internet</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Power supply</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Sewage disposal</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Ventilation</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Scuppers</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>Cleaning</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                    </tr>
                    <tr>
                        <td>test</td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
                        <td><span class="badge rounded-pill bg-secondary">0/0</span></td>
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