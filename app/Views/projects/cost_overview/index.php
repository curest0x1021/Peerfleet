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
}

$totalOwnerSupplies=0;
$totalVariationOrders=0;
$totalCostItems=0;
$totalShipyardCostItems=0;
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
        <h3>Expenses</h3>
    </div>
    <div class="card-body" >
        <table class="table table-hover table-bordered" >
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
                    <td>0</td>
                </tr>
                <tr></tr>
            </tbody>
            <?php
                foreach ($categorizedTasks as $category=>$oneList) {
            ?>
            <tbody>
                <tr  data-bs-toggle="collapse" data-bs-target="#<?php echo explode(" ",$category)[0]."-tasks-panel";?>" aria-expanded="false" aria-controls="<?php echo explode(" ",$category)[0]."-tasks-panel";?>">
                    <td><i data-feather="chevron-down" style="word-wrap:break-word;" class="collapse-arrow icon-16"></i><b class="" ><?php echo $category;?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                        $oneTaskTotalSupplies=0;
                        foreach ($oneTaskSupplies as $oneSupply) {
                            $oneTaskTotalSupplies+=$oneSupply->cost;
                        }
                        $oneTaskTotalCostItems=0;
                        foreach ($oneTaskCostItems as $oneItem) {
                            $oneTaskTotalCostItems+=$oneItem->total_cost;
                        }
                        $oneTaskTotalShipyardCostItems=0;
                        foreach ($oneTaskShipyardCostItems as $oneItem) {
                            $oneTaskTotalShipyardCostItems+=$oneItem->total_cost;
                        }
                        $oneTaskTotalVariationOrders=0;
                        foreach ($oneTaskVariationOrders as $oneOrder) {
                            $oneTaskTotalVariationOrders+=$oneOrder->cost;
                        }
                        $totalOwnerSupplies+=$oneTaskTotalSupplies;
                        $totalCostItems+=$oneTaskTotalCostItems;
                        $totalShipyardCostItems+=$oneTaskTotalShipyardCostItems;
                        $totalVariationOrders+=$oneTaskTotalVariationOrders;

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
                        <td>0</td>
                    </tr>
                    <?php
                        }
                    ?>
            </tbody>

            <?php
                }
            ?>
                
            
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        <?php if(isset($totalOwnerSupplies)) echo 'totalOwnerSupplies='.$totalOwnerSupplies.';'; ?>
        <?php if(isset($totalVariationOrders)) echo 'totalVariationOrders='.$totalVariationOrders.';'; ?>
        <?php if(isset($totalCostItems)) echo 'totalCostItems='.$totalOwnerSupplies.';'; ?>
        <?php if(isset($totalShipyardCostItems)) echo 'totalShipyardCostItems='.$totalShipyardCostItems.';'; ?>
        $("[data-bs-toggle=collapse]").on("click",function(){
            if(!$(this).find(".collapse-arrow").hasClass('collapse-active')) $(this).find(".collapse-arrow").addClass('collapse-active');
            else $(this).find(".collapse-arrow").removeClass('collapse-active')
        });
        console.log($(".total-owner-supplies"))
        $(".total-owner-supplies")[0].innerHTML=totalOwnerSupplies;
        $(".total-cost-items")[0].innerHTML=totalCostItems;
        $(".total-shipyard-cost-items")[0].innerHTML=totalShipyardCostItems;
        $(".total-variation-orders")[0].innerHTML=totalVariationOrders;
        
    });
    var totalCostItems;
    var totalVariationOrders;
    var totalShipyardCostItems;
    var totalOwnerSupplies;
</script>