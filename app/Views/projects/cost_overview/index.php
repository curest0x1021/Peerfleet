<?php
$categorizedTasks=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);
$categorizedOwnerSupplies=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);
$categorizedCostItems=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);
$categorizedShipyardCostItems=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);
$categorizedVariationOrders=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);

$categorizedComments=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);
$categorizedStats=array(
    "General & Docking"=>array(),
    "Hull"=>array(),
    "Equipment for Cargo"=>array(),
    "Ship Equipment"=>array(),
    "Safety & Crew Equipment"=>array(),
    "Machinery Main Components"=>array(),
    "System Machinery Main Components"=>array(),
    "Common systems"=>array(),
    "Others"=>array(),
);

foreach ($allTasks as $index => $oneTask) {
    if(isset($categorizedTasks[$oneTask->category]))
        $categorizedTasks[$oneTask->category][]=$oneTask;
    else $categorizedTasks["Others"][]=$oneTask;

    if(isset($categorizedOwnerSupplies[$oneTask->category]))
        $categorizedOwnerSupplies[$oneTask->category]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
            return $oneTask->id==$oneSupply->task_id;
        });
    else $categorizedOwnerSupplies["Others"]+=array_filter($allOwnerSupplies,function($oneSupply)use($oneTask){
        return $oneTask->id==$oneSupply->task_id;
    });

    if(isset($categorizedCostItems[$oneTask->category]))
        $categorizedCostItems[$oneTask->category]+=array_filter($allCostItems,function($oneItem)use($oneTask){
            return $oneTask->id==$oneItem->task_id;
        });
    else $categorizedCostItems["Others"]+=array_filter($allCostItems,function($oneItem)use($oneTask){
        return $oneTask->id==$oneItem->task_id;
    });

    if(isset($categorizedShipyardCostItems[$oneTask->category]))
        $categorizedShipyardCostItems[$oneTask->category]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
            return $oneTask->id==$oneItem->task_id;
        });
    else $categorizedShipyardCostItems["Others"]+=array_filter($allShipyardCostItems,function($oneItem)use($oneTask){
        return $oneTask->id==$oneItem->task_id;
    });

    if(isset($categorizedVariationOrders[$oneTask->category]))
        $categorizedVariationOrders[$oneTask->category]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
            return $oneTask->id==$oneOrder->task_id;
        });
    else $categorizedVariationOrders["Others"]+=array_filter($allVariationOrders,function($oneOrder)use($oneTask){
        return $oneTask->id==$oneOrder->task_id;
    });

    if(isset($categorizedComments[$oneTask->category]))
        $categorizedComments[$oneTask->category]+=array_filter($allComments,function($oneComment)use($oneTask){
            return $oneTask->id==$oneComment->task_id;
        });
    else $categorizedComments["Others"]+=array_filter($allComments,function($oneComment)use($oneTask){
        return $oneTask->id==$oneComment->task_id;
    });
}

$totalOwnerSupplies=0;
$totalVariationOrders=0;
$totalCostItems=0;
$totalShipyardCostItems=0;
$totalComments=0;
$totalEstimatedCost=0;
$totalPrice=0;
?>
<style>
    .collapse-arrow {
      
      margin-left: 5px;
      transition: transform 0.3s ease;
    }
    .collapse-active.collapse-arrow {
      transform: rotate(180deg);
    }
    .category-title{
        color:#eef1f9;
    }
</style>
<?php echo form_open(get_uri("projects/save_general")); ?>
<?php echo form_close(); ?>
<div class="card" >
    <div class="card-header" >
        <h4>Docking-related expenses</h4>
    </div>
    <div class="card-body"  >
        
        <div class="row" >
            <div class="col-md-5" >
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Estimated cost</th>
                            <th>Final cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Deviation cost</th>
                            <td  >
                                <p class="text-end"  ><?php
                                    if($project_info->status_id==4){
                                        echo $selectedYards[0]->deviation_cost . " " . ($project_info->currency?$project_info->currency:"USD");
                                    }else echo "-";
                                ?></p>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input value="<?php echo $project_info->deviation_costs?$project_info->deviation_costs:0;?>" class="form-control text-end input-general-deviation-costs" type="number" />
                                    <span class="input-group-text"><?php echo $project_info->currency?$project_info->currency:"USD";?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Loss of earnings</th>
                            <td>
                                <p class="text-end"  >
                                <?php
                                    if($project_info->status_id==4){
                                        echo $selectedYards[0]->loss_of_earnings . " " . ($project_info->currency?$project_info->currency:"USD");
                                    }else echo "-";
                                ?>
                                </p>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input value="<?php echo $project_info->loss_of_earnings?$project_info->loss_of_earnings:0;?>" class="form-control text-end input-general-loss-of-earnings" type="number" />
                                    <span class="input-group-text"><?php echo $project_info->currency?$project_info->currency:"USD";?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Bunker cost</th>
                            <td>
                                <p class="text-end" >
                                <?php
                                    if($project_info->status_id==4){
                                        echo $selectedYards[0]->bunker_cost . " " . ($project_info->currency?$project_info->currency:"USD");
                                    }else echo "-";
                                ?>
                                </p>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input value="<?php echo $project_info->bunker_costs?$project_info->bunker_costs:0;?>" class="form-control text-end input-general-bunker-costs" type="number" />
                                    <span class="input-group-text"><?php echo $project_info->currency?$project_info->currency:"USD";?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Other additional expenditures of yards</th>
                            <td>
                                <p class="text-end"  >
                                <?php
                                    if($project_info->status_id==4){
                                        echo $selectedYards[0]->additional_expenditures . " " . ($project_info->currency?$project_info->currency:"USD");
                                    }else echo "-";
                                ?>
                                </p>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input value="<?php echo $project_info->additional_expenditures?$project_info->additional_expenditures:0;?>" class="form-control text-end input-general-additional-expenditures" type="number" />
                                    <span class="input-group-text"><?php echo $project_info->currency?$project_info->currency:"USD";?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><button class="btn btn-default btn-small btn-save-general-costs" ><i data-feather="save" class="icon-16" ></i>Save</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1" ></div>
            <?php if($project_info->status_id>=4){ ?>
            <div class="col-md-5" id="card-general-costs">
                <div style="width:80%" >
                    <canvas id="general-costs-chart"></canvas>
                </div>
                
                <div class="w-full" >
                    <div class="d-flex align-items-center" >
                        <div style="width:30%" >Estimated costs : </div>
                        <div class="estimated-general-costs" >0</div>&nbsp;
                        <div style="width:30%" ><?php echo $project_info->currency?$project_info->currency:"USD";?></div>
                    </div>
                    <div  class="d-flex align-items-center" >
                        <div style="width:30%" >Final costs : </div>
                        <div  class="final-general-costs" >0</div>&nbsp;
                        <div style="width:30%" ><?php echo $project_info->currency?$project_info->currency:"USD";?></div>
                    </div>
                    <div class="d-flex align-items-center" >
                        <div style="width:30%" >Delta costs : </div>
                        <div  class="delta-general-costs" >0</div>&nbsp;
                        <div style="width:30%" ><?php echo $project_info->currency?$project_info->currency:"USD";?></div>
                    </div>
                </div>
                
            </div>
            <?php } ?>
        </div>
    </div>

</div>

<div class="card" >
    <div class="card-header" >
        <div class="d-flex align-items-center" >
            <h4>Repair-related expenses</h4>
            <div class="flex-grow-1" ></div>
            <?php echo modal_anchor(get_uri('projects/modal_import_cost_overview/').$project_id,'<button style="margin-right:10px;" class="btn btn-default" ><i class="icon-16"  data-feather="upload" ></i>Import</button>',array());?>
            <?php //echo modal_anchor(get_uri('projects/modal_export_cost_overview/').$project_id,'<button class="btn btn-default" ><i class="icon-16"  data-feather="download" ></i>Export</button>',array());?>
            <?php echo modal_anchor(get_uri("tasks/export_project_modal_form"), "<i data-feather='external-link' class='icon-16'></i> " . app_lang('export'), array("class" => "btn btn-default export-excel-btn", "title" => app_lang('export_project'), "data-post-project_id" => $project_id));?>
        </div>
    </div>
    <div class="card-body" >
        <!-- <div class="d-flex" style="margin-bottom:10px;" >
            <button class="btn btn-default" ><i class="icon-16"  data-feather="plus" ></i>Add filter</button>
            <div class="flex-grow-1" ></div>
            
            <div><label><input type="text" id="search-messages" class="datatable-search" placeholder="Search"></label></div>
        </div> -->
        
        <div id="table-panel-for-xlsx" >
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th class="col" style="min-width:15vw;max-width:15vw;width:15vw;" >Name</th>
                    <th class="col"  >Estimated cost</th>
                    <th class="col"  >Owner's supply</th>
                    <th class="col"   >Quoted</th>
                    <th class="col" >Variation orders</th>
                    <th class="col" >Total</th>
                    <th class="col"  >Total yard</th>
                    <th class="col" class=""  >Billed yard</th>
                    <th class="col" class=""  >Final yard</th>
                    <th class="col" class=""  >Comment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Total cost:</th>
                    <td class="total-estimated-cost" ></td>
                    <td class="total-owner-supplies"><?php if(isset($project_info->currency)) echo $project_info->currency;?> 0</td>
                    <td class="total-cost-items"><?php if(isset($project_info->currency)) echo $project_info->currency;?> 0</td>
                    <td class="total-variation-orders" ><?php if(isset($project_info->currency)) echo $project_info->currency;?> 0</td>
                    <td class="total-cost"><?php if(isset($project_info->currency)) echo $project_info->currency;?> 0</td>
                    <td class="total-shipyard-cost-items"><?php if(isset($project_info->currency)) echo $project_info->currency;?> 0</td>
                    <td>-</td>
                    <td>-</td>
                    <td class="">
                        <?php echo modal_anchor(get_uri("task_comments/modal_project_comments/".$project_id),'<span class="badge pill bg-secondary total-comments" >0</span>',array());?>
                    </td>
                </tr>
                <tr></tr>
            </tbody>
            <?php
                foreach ($categorizedTasks as $category=>$oneList) {
                    $categoryOwnerSupply=0;
                    $categoryCostItems=0;
                    $categoryShipyardCostItems=0;
                    $categoryVariationOrder=0;
                    $categoryComments=0;
                    $categoryTotalPrice=0;
                    $categoryEstimatedCost=0;
            ?>
            <tbody>
                <tr  data-bs-toggle="collapse" data-bs-target="#<?php echo explode(" ",$category)[0]."-tasks-panel";?>" aria-expanded="false" aria-controls="<?php echo explode(" ",$category)[0]."-tasks-panel";?>">
                    <td><i data-feather="chevron-down" style="word-wrap:break-word;" class="collapse-arrow icon-16"></i><b class="" ><?php echo $category;?></b></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-estimated-cost" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-owner-supplies" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-cost-items" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-variation-orders" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-total-costs" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-shipyard-cost-items" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-billed-yard" >-</td>
                    <td class="<?php echo explode(" ",$category)[0];?>-final-yard" >-</td>
                    <td class="<?php echo explode(" ",$category)[0];?>-comments" ></td>
                </tr>
            </tbody>
            <tbody  id="<?php echo explode(" ",$category)[0]."-tasks-panel";?>" class="collapse">
                    <?php foreach ($oneList as $key => $oneTask) {
                        $oneTaskSupplies=array_filter($categorizedOwnerSupplies[$category],function($oneSupply)use($oneTask){
                            return $oneSupply->task_id==$oneTask->id;
                        });
                        $oneTaskCostItems=array_filter($categorizedCostItems[$category],function($oneItem)use($oneTask){
                            return $oneItem->task_id==$oneTask->id;
                        });
                        $oneTaskShipyardCostItems=array_filter($categorizedShipyardCostItems[$category],function($oneItem)use($oneTask){
                            return $oneItem->task_id==$oneTask->id;
                        });
                        $oneTaskVariationOrders=array_filter($categorizedVariationOrders[$category],function($oneOrder)use($oneTask){
                            return $oneOrder->task_id==$oneTask->id;
                        });
                        $oneTaskComments=array_filter($categorizedComments[$category],function($oneComment)use($oneTask){
                            return $oneComment->task_id==$oneTask->id;
                        });
                        $oneTaskTotalSupplies=0;
                        foreach ($oneTaskSupplies as $oneSupply) {
                            $oneTaskTotalSupplies+=$oneSupply->cost;
                        }
                        // $categoryOwnerSupply+=$oneTaskTotalSupplies;
                        $categoryOwnerSupply+=$oneTask->owner_supply;

                        $oneTaskTotalCostItems=0;
                        foreach ($oneTaskCostItems as $oneItem) {
                            $oneTaskTotalCostItems+=$oneItem->total_cost;
                        }
                        $categoryCostItems+=$oneTaskTotalCostItems;

                        $oneTaskTotalShipyardCostItems=0;
                        foreach ($oneTaskShipyardCostItems as $oneItem) {
                            $oneTaskTotalShipyardCostItems+=$oneItem->total_cost;
                        }
                        $categoryShipyardCostItems+=$oneTaskTotalShipyardCostItems;

                        $oneTaskTotalVariationOrders=0;
                        foreach ($oneTaskVariationOrders as $oneOrder) {
                            $oneTaskTotalVariationOrders+=$oneOrder->cost;
                        }
                        $categoryVariationOrder+=$oneTaskTotalVariationOrders;

                        $oneTaskTotalPrice=$oneTaskTotalCostItems+$oneTaskTotalSupplies+$oneTaskTotalVariationOrders;
                        $categoryTotalPrice+=$oneTaskTotalPrice;

                        $oneTaskTotalComments=count($oneTaskComments);
                        $categoryComments+=$oneTaskTotalComments;

                        $categoryEstimatedCost+=($oneTask->estimated_cost?$oneTask->estimated_cost:0);

                        
                        // $totalOwnerSupplies+=$oneTaskTotalSupplies;
                        $totalOwnerSupplies+=$oneTask->owner_supply;
                        $totalCostItems+=$oneTaskTotalCostItems;
                        $totalShipyardCostItems+=$oneTaskTotalShipyardCostItems;
                        $totalVariationOrders+=$oneTaskTotalVariationOrders;
                        $totalPrice+=$oneTaskTotalPrice;
                        $totalComments+=$oneTaskTotalComments;
                        $totalEstimatedCost+=($oneTask->estimated_cost?$oneTask->estimated_cost:0);

                    ?>
                    <tr>
                        <td style="word-wrap:break-word;max-width:12vw;" >
                            <?php echo "<span style='color:gray;' >".$oneTask->dock_list_number."</span> ".$oneTask->title;?>
                        </td>
                        <td><?php if($oneTask->estimated_cost>0) echo ($project_info->currency?$project_info->currency:"USD")." ".number_format($oneTask->estimated_cost,1); else echo "-";?></td>
                        <!-- <td><?php //if(isset($project_info->currency)) echo $project_info->currency;?> <?php //echo number_format($oneTaskTotalSupplies);?></td> -->
                        <td><?php if($oneTask->owner_supply>0) echo ($project_info->currency?$project_info->currency:"USD")." ".number_format($oneTask->owner_supply,1); else echo "-";?></td>
                        <!-- <td><?php //if(isset($project_info->currency)) echo $project_info->currency;?> <?php //echo number_format( $oneTaskTotalCostItems);?></td> -->
                        <td><?php if($oneTaskTotalCostItems>0) echo ($project_info->currency?$project_info->currency:"USD")." ".number_format($oneTaskTotalCostItems,1); else echo "-";?></td>
                        <!-- <td><?php //if(isset($project_info->currency)) echo $project_info->currency;?> <?php //echo number_format($oneTaskTotalVariationOrders);?></td> -->
                        <td><?php if($oneTaskTotalVariationOrders>0) echo ($project_info->currency?$project_info->currency:"USD")." ".number_format($oneTaskTotalVariationOrders,1); else echo "-";?></td>
                        <!-- <td><?php //if(isset($project_info->currency)) echo $project_info->currency;?> <?php //echo number_format($oneTaskTotalPrice);?></td> -->
                        <td><?php if($oneTaskTotalPrice>0) echo ($project_info->currency?$project_info->currency:"USD")." ".number_format($oneTaskTotalPrice,1); else echo "-";?></td>
                        <!-- <td><?php //if(isset($project_info->currency)) echo $project_info->currency;?> <?php //echo number_format($oneTaskTotalShipyardCostItems);?></td> -->
                        <td><?php if($oneTaskTotalShipyardCostItems>0) echo ($project_info->currency?$project_info->currency:"USD")." ".number_format($oneTaskTotalShipyardCostItems,1); else echo "-";?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            
                            <?php echo modal_anchor(get_uri("task_comments/modal_task_comments/".$oneTask->id),'<span class="badge pill bg-secondary" >'. $oneTaskTotalComments.'</span>',array());?>
                        </td>
                    </tr>
                    <?php
                        }
                        $categorizedStats[$category]["owner_supplies"]=( $categoryOwnerSupply);
                        $categorizedStats[$category]["cost_items"]=($categoryCostItems);
                        $categorizedStats[$category]["variation_orders"]=($categoryVariationOrder);
                        $categorizedStats[$category]["shipyard_cost_items"]=($categoryShipyardCostItems);
                        $categorizedStats[$category]["total_price"]=($categoryTotalPrice);
                        $categorizedStats[$category]["estimated_cost"]=($categoryEstimatedCost);
                        $categorizedStats[$category]["comments"]=$categoryComments;
                    ?>
            </tbody>

            <?php
                }
            ?>
                
            
        </table>
        
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        <?php if(isset($totalOwnerSupplies)) echo 'totalOwnerSupplies="'. ($totalOwnerSupplies).'";'; ?>
        <?php if(isset($totalVariationOrders)) echo 'totalVariationOrders="'.($totalVariationOrders).'";'; ?>
        <?php if(isset($totalCostItems)) echo 'totalCostItems="'.($totalCostItems).'";'; ?>
        <?php if(isset($totalShipyardCostItems)) echo 'totalShipyardCostItems="'.($totalShipyardCostItems).'";'; ?>
        <?php if(isset($totalPrice)) echo 'totalCosts="'.($totalPrice).'";'; ?>
        <?php if(isset($totalEstimatedCost)) echo 'totalEstimatedCost="'.($totalEstimatedCost).'";'; ?>
        <?php if(isset($totalComments)) echo 'totalComments='.$totalComments.';'; ?>
        <?php if(isset($categorizedStats)) echo 'categorizedStats='.json_encode($categorizedStats).';'; ?>
        $("[data-bs-toggle=collapse]").on("click",function(){
            if(!$(this).find(".collapse-arrow").hasClass('collapse-active')) $(this).find(".collapse-arrow").addClass('collapse-active');
            else $(this).find(".collapse-arrow").removeClass('collapse-active')
        });
        // console.log($(".total-owner-supplies"))
        $(".total-estimated-cost")[0].innerHTML=Number(totalEstimatedCost)>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+totalEstimatedCost.toLocaleString():"-";
        // $(".total-owner-supplies")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+totalOwnerSupplies;
        $(".total-owner-supplies")[0].innerHTML=Number(totalOwnerSupplies)>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+totalOwnerSupplies.toLocaleString():"-";
        // $(".total-cost-items")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+totalCostItems;
        $(".total-cost-items")[0].innerHTML=Number(totalCostItems)>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+totalCostItems.toLocaleString():"-";
        // $(".total-shipyard-cost-items")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+totalShipyardCostItems;
        $(".total-shipyard-cost-items")[0].innerHTML=Number(totalShipyardCostItems)>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+totalShipyardCostItems.toLocaleString():"-";
        // $(".total-variation-orders")[0].innerHTML='<?php //if(isset($project_info->currency))  echo $project_info->currency;?> '+totalVariationOrders;
        $(".total-variation-orders")[0].innerHTML=Number(totalVariationOrders)>0?'<?php if(isset($project_info->currency))  echo $project_info->currency;?> '+totalVariationOrders.toLocaleString():"-";
        // $(".total-cost")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+totalCosts;
        $(".total-cost")[0].innerHTML=Number(totalCosts)>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+totalCosts.toLocaleString():"-";
        $(".total-comments")[0].innerHTML=totalComments;
        for(var category of [
            "General & Docking",
            "Hull",
            "Equipment for Cargo",
            "Ship Equipment",
            "Safety & Crew Equipment",
            "Machinery Main Components",
            "System Machinery Main Components",
            "Common systems",
            "Others",
        ]){
            $("."+category.split(" ")[0]+"-estimated-cost")[0].innerHTML=Number(categorizedStats[category]['estimated_cost'])>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['estimated_cost'].toLocaleString():"-";
            // $("."+category.split(" ")[0]+"-owner-supplies")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['owner_supplies'];
            $("."+category.split(" ")[0]+"-owner-supplies")[0].innerHTML=Number(categorizedStats[category]['owner_supplies'])>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['owner_supplies'].toLocaleString():"-";
            // $("."+category.split(" ")[0]+"-variation-orders")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['variation_orders'];
            $("."+category.split(" ")[0]+"-variation-orders")[0].innerHTML=Number(categorizedStats[category]['variation_orders'])>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['variation_orders'].toLocaleString():"-";
            // $("."+category.split(" ")[0]+"-cost-items")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['cost_items'];
            $("."+category.split(" ")[0]+"-cost-items")[0].innerHTML=Number(categorizedStats[category]['cost_items'])>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['cost_items'].toLocaleString():"-";
            // $("."+category.split(" ")[0]+"-total-costs")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['total_price'];
            $("."+category.split(" ")[0]+"-total-costs")[0].innerHTML=Number(categorizedStats[category]['total_price'])>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['total_price'].toLocaleString():"-";
            // $("."+category.split(" ")[0]+"-shipyard-cost-items")[0].innerHTML='<?php //if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['shipyard_cost_items'];
            $("."+category.split(" ")[0]+"-shipyard-cost-items")[0].innerHTML=Number(categorizedStats[category]['shipyard_cost_items'])>0?'<?php if(isset($project_info->currency)) echo $project_info->currency;?> '+categorizedStats[category]['shipyard_cost_items'].toLocaleString():"-";
            $("."+category.split(" ")[0]+"-comments")[0].innerHTML=`<span class="badge pill bg-secondary" >${categorizedStats[category]['comments']}</span>`;
        }
        
        $(".btn-save-general-costs").on("click",function(){
            var deviation_costs=$(".input-general-deviation-costs")[0].value;
            var loss_of_earnings=$(".input-general-loss-of-earnings")[0].value;
            var bunker_costs=$(".input-general-bunker-costs")[0].value;
            var additional_expenditures=$(".input-general-additional-expenditures")[0].value;
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            $.ajax({
                url:"<?php echo get_uri("projects/save_general_costs");?>",
                method:"POST",
                data:{
                    deviation_costs,
                    loss_of_earnings,
                    bunker_costs,
                    additional_expenditures,
                    rise_csrf_token,
                    project_id:<?php echo $project_id;?>
                },
                success:function(response){
                    if(JSON.parse(response).success){
                        appAlert.success("Saved successfully!", {duration: 4000});
                    }
                }
            })
        })
        <?php if($project_info->status_id>=4){ ?>
        /////////////////////////////////
        var yard_info=<?php echo json_encode($selectedYards);?>;
        var project_info=<?php echo json_encode($project_info);?>;
        var estimated_general_costs=0;
        var final_general_costs=0
        if(project_info.status_id>=4&&yard_info.length>0){
            estimated_general_costs=Number(yard_info[0].deviation_cost)+Number(yard_info[0].loss_of_earnings)+Number(yard_info[0].bunker_cost)+Number(yard_info[0].additional_expenditures);
        }
        
        final_general_costs=Number(project_info.deviation_costs)+Number(project_info.loss_of_earnings)+Number(project_info.bunker_costs)+Number(project_info.additional_expenditures);
        console.log(estimated_general_costs,final_general_costs)
        var delta_costs=final_general_costs-estimated_general_costs;
        var general_costs_chart = document.getElementById("general-costs-chart");
        $(".estimated-general-costs").html(estimated_general_costs);
        $(".final-general-costs").html(final_general_costs);
        $(".delta-general-costs").html(Math.abs(delta_costs));
        new Chart(
            general_costs_chart,{
                type:"bar",
                data:{
                    datasets: [
                        {
                            label: 'Estimated costs',
                            data: [estimated_general_costs],
                            backgroundColor: [
                            '#00B393',//green
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Final costs',
                            data: [final_general_costs],
                            backgroundColor: [
                            '#e74c3c',
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Delta',
                            data: [Math.abs(delta_costs)],
                            backgroundColor: [
                            '#F9A52D',
                            ],
                            borderWidth: 1
                        }
                    ]

                },
                options: {
                    animation: {
                        animateScale: true
                    },
                    title:{
                        text:"Estimated costs VS Final costs",
                        position:"top",
                        display:true

                    },
                    legend: {
                        position: 'bottom',
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    },
                },
            }
        )
        ///////
        <?php } ?>
    });
    var totalCostItems;
    var totalVariationOrders;
    var totalShipyardCostItems;
    var totalOwnerSupplies;
    var totalComments;
    var totalCosts;
    var categorizedStats;
</script>