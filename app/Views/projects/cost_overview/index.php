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
foreach ($allTasks as $index => $oneTask) {
    if(isset($categorizedTasks[$oneTask->category]))
        $categorizedTasks[$oneTask->category][]=$oneTask;
    else $categorizedTasks["Others"][]=$oneTask;
}
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
                    <th class="col" >Owner's supply</th>
                    <th class="col" >Quoted</th>
                    <th class="col" >Variation orders</th>
                    <th class="col" >Total</th>
                    <th class="col" >Total yard</th>
                    <th class="col" >Billed yard</th>
                    <th class="col" >Final yard</th>
                    <th class="col" >Comment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Total cost:</th>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
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
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </tbody>
            <tbody  id="<?php echo explode(" ",$category)[0]."-tasks-panel";?>" class="collapse">
                    <?php foreach ($oneList as $key => $oneTask) {

                    ?>
                    <tr>
                        <td style="word-wrap:break-word;max-width:12vw;" >
                            <?php echo $oneTask->title;?>
                        </td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
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
        $("[data-bs-toggle=collapse]").on("click",function(){
            if(!$(this).find(".collapse-arrow").hasClass('collapse-active')) $(this).find(".collapse-arrow").addClass('collapse-active');
            else $(this).find(".collapse-arrow").removeClass('collapse-active')
        });
        var allCostItems;
        var allVariationOrders;
        var allTasks;
        <?php
        if(isset($allCostItems)) echo "allCostItems=JSON.parse('".json_encode($allCostItems)."');";
        if(isset($allVariationOrders)) echo "allVariationOrders=JSON.parse('".json_encode($allVariationOrders)."');";
        ?>
    });
</script>