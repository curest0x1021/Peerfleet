<?php
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
$categorizedOwnerSupplies=array(
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
$categorizedCostItems=array(
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
$categorizedShipyardCostItems=array(
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
$categorizedVariationOrders=array(
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

$categorizedComments=array(
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
$categorizedStats=array(
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
<div class="card" >
    <div class="card-header" >
        <div class="d-flex align-items-center" >
            <h4>Cost overview</h4>
            <div class="flex-grow-1" ></div>
            <?php echo modal_anchor(get_uri('projects/modal_import_cost_overview'),'<button style="margin-right:10px;" class="btn btn-default" ><i class="icon-16"  data-feather="upload" ></i>Import</button>',array());?>
            <?php echo modal_anchor(get_uri('projects/modal_export_cost_overview/').$project_id,'<button class="btn btn-default" ><i class="icon-16"  data-feather="download" ></i>Export</button>',array());?>
        </div>
    </div>
    <div class="card-body" >
        <div class="d-flex" style="margin-bottom:10px;" >
            <button class="btn btn-default" ><i class="icon-16"  data-feather="plus" ></i>Add filter</button>
            <div class="flex-grow-1" ></div>
            
            <div><label><input type="text" id="search-messages" class="datatable-search" placeholder="Search"></label></div>
        </div>
        <div id="table-panel-for-xlsx" >
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th class="col" style="min-width:15vw;max-width:15vw;width:15vw;" >Name</th>
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
                    <td class="total-owner-supplies">0</td>
                    <td class="total-cost-items">0</td>
                    <td class="total-variation-orders" >0</td>
                    <td class="total-cost">0</td>
                    <td class="total-shipyard-cost-items">0</td>
                    <td>0</td>
                    <td>0</td>
                    <td class="">
                        <?php echo modal_anchor(get_uri("projects/modal_comments/".$project_id),'<span class="badge pill bg-secondary total-comments" >0</span>',array());?>
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
            ?>
            <tbody>
                <tr  data-bs-toggle="collapse" data-bs-target="#<?php echo explode(" ",$category)[0]."-tasks-panel";?>" aria-expanded="false" aria-controls="<?php echo explode(" ",$category)[0]."-tasks-panel";?>">
                    <td><i data-feather="chevron-down" style="word-wrap:break-word;" class="collapse-arrow icon-16"></i><b class="" ><?php echo $category;?></b></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-owner-supplies" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-cost-items" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-variation-orders" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-total-costs" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-shipyard-cost-items" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-billed-yard" ></td>
                    <td class="<?php echo explode(" ",$category)[0];?>-final-yard" ></td>
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
                        $categoryOwnerSupply+=$oneTaskTotalSupplies;

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

                        $oneTaskTotalComments=count($oneTaskComments);
                        $categoryComments+=$oneTaskTotalComments;

                        
                        $totalOwnerSupplies+=$oneTaskTotalSupplies;
                        $totalCostItems+=$oneTaskTotalCostItems;
                        $totalShipyardCostItems+=$oneTaskTotalShipyardCostItems;
                        $totalVariationOrders+=$oneTaskTotalVariationOrders;
                        $totalComments+=$oneTaskTotalComments;

                    ?>
                    <tr>
                        <td style="word-wrap:break-word;max-width:12vw;" >
                            <?php echo $oneTask->title;?>
                        </td>
                        <td><?php echo $oneTaskTotalSupplies;?></td>
                        <td><?php echo $oneTaskTotalCostItems?></td>
                        <td><?php echo $oneTaskTotalVariationOrders;?></td>
                        <td>0</td>
                        <td><?php echo $oneTaskTotalShipyardCostItems;?></td>
                        <td>0</td>
                        <td>0</td>
                        <td>
                            
                            <?php echo modal_anchor(get_uri("projects/modal_task_comments/".$oneTask->id),'<span class="badge pill bg-secondary" >'. $oneTaskTotalComments.'</span>',array());?>
                        </td>
                    </tr>
                    <?php
                        }
                        $categorizedStats[$category]["owner_supplies"]=$categoryOwnerSupply;
                        $categorizedStats[$category]["cost_items"]=$categoryCostItems;
                        $categorizedStats[$category]["variation_orders"]=$categoryVariationOrder;
                        $categorizedStats[$category]["shipyard_cost_items"]=$categoryShipyardCostItems;
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
        <?php if(isset($totalOwnerSupplies)) echo 'totalOwnerSupplies='.$totalOwnerSupplies.';'; ?>
        <?php if(isset($totalVariationOrders)) echo 'totalVariationOrders='.$totalVariationOrders.';'; ?>
        <?php if(isset($totalCostItems)) echo 'totalCostItems='.$totalOwnerSupplies.';'; ?>
        <?php if(isset($totalShipyardCostItems)) echo 'totalShipyardCostItems='.$totalShipyardCostItems.';'; ?>
        <?php if(isset($totalComments)) echo 'totalComments='.$totalComments.';'; ?>
        <?php if(isset($categorizedStats)) echo 'categorizedStats='.json_encode($categorizedStats).';'; ?>
        $("[data-bs-toggle=collapse]").on("click",function(){
            if(!$(this).find(".collapse-arrow").hasClass('collapse-active')) $(this).find(".collapse-arrow").addClass('collapse-active');
            else $(this).find(".collapse-arrow").removeClass('collapse-active')
        });
        console.log($(".total-owner-supplies"))
        $(".total-owner-supplies")[0].innerHTML=totalOwnerSupplies;
        $(".total-cost-items")[0].innerHTML=totalCostItems;
        $(".total-shipyard-cost-items")[0].innerHTML=totalShipyardCostItems;
        $(".total-variation-orders")[0].innerHTML=totalVariationOrders;
        $(".total-comments")[0].innerHTML=totalComments;
        for(var category of [
            "General & Docking",
            "Hull",
            "Equipment for Cargo",
            "Ship Equipment",
            "Safety & Crew Equipment",
            "Machinery Main Components",
            "Systems machinery main components",
            "Common systems",
            "Others",
        ]){
            $("."+category.split(" ")[0]+"-owner-supplies")[0].innerHTML=categorizedStats[category]['owner_supplies'];
            $("."+category.split(" ")[0]+"-variation-orders")[0].innerHTML=categorizedStats[category]['variation_orders'];
            $("."+category.split(" ")[0]+"-cost-items")[0].innerHTML=categorizedStats[category]['cost_items'];
            $("."+category.split(" ")[0]+"-shipyard-cost-items")[0].innerHTML=categorizedStats[category]['shipyard_cost_items'];
            $("."+category.split(" ")[0]+"-comments")[0].innerHTML=`<span class="badge pill bg-secondary" >${categorizedStats[category]['comments']}</span>`;
        }
        
    });
    var totalCostItems;
    var totalVariationOrders;
    var totalShipyardCostItems;
    var totalOwnerSupplies;
    var totalComments;
    var categorizedStats;
</script>