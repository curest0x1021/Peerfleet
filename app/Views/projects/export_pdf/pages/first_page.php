<?php echo view('projects/export_pdf/layouts/header.php');?>
<?php if(unserialize($client_info->image)){?>
    <img style="width:100%;height:auto;" src="<?php echo encode_img_base64(get_setting("profile_image_path")."/".unserialize($client_info->image)["file_name"]);?>" alt="logo"/>
<?php }else{ ?>
    <img style="width:100%;height:auto;" src="<?php echo encode_img_base64(base_url("assets/images/ship_img.jpg"));?>" alt="logo"/>
<?php } ?>
<h1 style="text-align:center;" ><?php echo $project_info->title;?></h1>
<h2 style="text-align:center;"><?php echo "-".$client_info->charter_name."-";?></h2>
<!-- <table style="width:100%" >
    <tbody>
    <tr>
        <td style="width:50%;text-align:center;" >
        <p>Start Date : <?php 
        // echo $project_info->start_date;
        ?></p>
        </td>
        <td style="width:50%;text-align:center;">
        <p>Deadline : <?php 
        // echo $project_info->deadline;
        ?></p>
        </td>
    </tr>
    </tbody>
</table> -->
<p style="text-align:center;" ><?php echo date("d.m.Y",strtotime($project_info->start_date))." ~ ".date("d.m.Y",strtotime($project_info->deadline));?></p>
<p style="text-align:center;">Labels : <?php
$label_data=explode("--::--",$project_info->labels_list);
if(array_key_exists(1,$label_data)) echo $label_data[1];
 ?></p>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Vessel Information</h1>
<h2>General Information</h2>
<p><?php if($client_info->charter_name) echo "Vessel name : ".$client_info->charter_name; ?></p>
<p><?php if($vessel_info) echo "Vessel type : ".$vessel_info->title; ?></p>
<p><?php if($client_info->imo_number) echo "IMO number : ".$client_info->imo_number; ?></p>
<p><?php if($client_info->flag_state) echo "Flag state : ".$client_info->flag_state; ?></p>
<p><?php if($client_info->port_of_registry) echo "Port of registry : ".$client_info->port_of_registry; ?></p>
<p><?php if($client_info->classification_society) echo "Classification society : ".$client_info->classification_society; ?></p>
<h2>Dimensions and Capacities</h2>
<p><?php  echo "Gross tonnage : ".($client_info->gross_tonnage?$client_info->gross_tonnage:0)." t"; ?></p>
<p><?php echo "Length over all (L.O.A): ".($client_info->length_over_all?$client_info->length_over_all:0)." m"; ?></p>
<p><?php  echo "Length between perpendiculars (L.B.P): ".($client_info->length_between_perpendiculars?$client_info->length_between_perpendiculars:0)." m"; ?></p>
<p><?php  echo "BEAM/Breadth moulded : ".($client_info->breadth_moulded?$client_info->breadth_moulded:0)." m"; ?></p>
<p><?php  echo "Depth moulded : ".($client_info->depth_moulded?$client_info->depth_moulded:0)." m"; ?></p>
<p><?php echo "Draught scantling : ".($client_info->draught_scantling?$client_info->draught_scantling:0)." m"; ?></p>
<p><?php  echo "Hull design : ".($client_info->hull_design?$client_info->hull_design:""); ?></p>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Vessel Information</h1>
<h2>Propulsion</h2>
<div style="" >
<table style="width:100%;" >
    <tbody>
        <tr>
            <td style="width:50%;" >
                <h3>Main engine</h3>
                <p><?php echo "Maker : ".($client_info->main_engine_maker?$client_info->main_engine_maker:""); ?></p>
                <p><?php echo "Model : ".($client_info->main_engine_model?$client_info->main_engine_model:""); ?></p>
                <p><?php echo "Continuous output: ".($client_info->main_engine_continuous_output?$client_info->main_engine_continuous_output:""); ?></p>
                <p><?php echo "Bore : ".($client_info->main_engine_bore?$client_info->main_engine_bore:""); ?></p>
                <p><?php echo "Stroke : ".($client_info->main_engine_stroke?$client_info->main_engine_stroke:0)." m"; ?></p>
                <p><?php echo "Serial number : ".($client_info->main_engine_serial_number?$client_info->main_engine_serial_number:0)." m"; ?></p>
                <p><?php echo "Quantity : ".($client_info->main_engine_quantity?$client_info->main_engine_quantity:""); ?></p>
                <h3>Auxiliary engine</h3>
                <p><?php echo "Maker : ".($client_info->auxiliary_engine_maker?$client_info->auxiliary_engine_maker:""); ?></p>
                <p><?php echo "Model : ".($client_info->auxiliary_engine_model?$client_info->auxiliary_engine_model:""); ?></p>
                <p><?php echo "Output : ".($client_info->auxiliary_engine_output?$client_info->auxiliary_engine_output:""); ?></p>
                <p><?php echo "Serial number : ".($client_info->auxiliary_engine_serial_number?$client_info->auxiliary_engine_serial_number:""); ?></p>
                <p><?php echo "Quantity : ".($client_info->auxiliary_engine_quantity?$client_info->auxiliary_engine_quantity:""); ?></p>
                <h3>Emergency generator</h3>
                <p><?php echo "Maker : ".($client_info->emergency_generator_maker?$client_info->emergency_generator_maker:""); ?></p>
                <p><?php echo "Model : ".($client_info->emergency_generator_model?$client_info->emergency_generator_model:""); ?></p>
                <p><?php echo "Output : ".($client_info->emergency_generator_output?$client_info->emergency_generator_output:""); ?></p>
                <p><?php echo "Serial number : ".($client_info->emergency_generator_serial_number?$client_info->emergency_generator_serial_number:""); ?></p>
                <p><?php echo "Quantity : ".($client_info->emergency_generator_quantity?$client_info->emergency_generator_quantity:""); ?></p>
            </td>
            <td>
                <h3>Shaft generator</h3>
                <p><?php echo "Maker : ".$client_info->shaft_generator_maker; ?></p>
                <p><?php echo "Model : ".$client_info->shaft_generator_model; ?></p>
                <p><?php echo "Output : ".$client_info->shaft_generator_output; ?></p>
                <p><?php echo "Serial number : ".$client_info->shaft_generator_serial_number; ?></p>
                <p><?php echo "Quantity : ".$client_info->shaft_generator_quantity; ?></p>
                <h3>Propeller</h3>
                <p><?php echo "Maker : ".$client_info->propeller_maker; ?></p>
                <p><?php echo "Type : ".$client_info->propeller_type; ?></p>
                <p><?php echo "Number of blades : ".$client_info->propeller_number_of_blades; ?></p>
                <p><?php echo "Diameter : ".($client_info->propeller_diameter?$client_info->propeller_diameter:0)." m"; ?></p>
                <p><?php echo "Pitch : ".$client_info->propeller_pitch; ?></p>
                <p><?php echo "Material : ".$client_info->propeller_material; ?></p>
                <p><?php echo "Weight : ".$client_info->propeller_weight; ?></p>
                <p><?php echo "Output : ".$client_info->propeller_output; ?></p>
                <p><?php echo "Quantity : ".$client_info->propeller_quantity; ?></p>
            </td>
        </tr>
    </tbody>
</table>
    
    
</div>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Vessel Information</h1>
<h2>Side Thruster</h2>
<p><?php  echo "Number of bow thrusters : ".$client_info->bow_thruster_number; ?></p>
<p><?php  echo "Maker of bow thrusters : ".$client_info->bow_thruster_maker; ?></p>
<p><?php  echo "Type of bow thrusters : ".$client_info->bow_thruster_type; ?></p>
<p><?php  echo "Power of bow thrusters : ".$client_info->bow_thruster_power; ?></p>
<p><?php  echo "Number of stern thrusters : ".$client_info->stern_thruster_number; ?></p>
<p><?php  echo "Maker of stern thrusters : ".$client_info->stern_thruster_maker; ?></p>
<p><?php  echo "Type of stern thrusters : ".$client_info->stern_thruster_type; ?></p>
<p><?php  echo "Power of stern thrusters : ".$client_info->stern_thruster_power; ?></p>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Project Information</h1>
<h2>Description</h2>
<div><?php echo $project_info->description;?></div>
<h2>Team Members</h2>
<?php foreach ($members as $key => $member) {
?>
<table style="width:80%;" >
    <tbody>
        <tr>
            <td style="width:60px;" >
                <?php
                    $avatar_path=base_url("assets/images/avatar.jpg");
                    $avatar_data=unserialize($member->member_image);
                    if($avatar_data&&file_exists(get_setting("profile_image_path").$avatar_data['file_name'])){
                        $avatar_path=get_setting("profile_image_path").$avatar_data['file_name'];
                    }
                    ?>
                    <img src="<?php  echo encode_img_base64($avatar_path);?>" style="width:50px;border-radius:50%;" />    
                    
            </td>
            <td style="width:40%" >
                <p style="float:left;" ><?php echo $member->member_name;?></p>
            </td>
            <td  >
                <p style="float:left;"><?php echo $member->member_email;?></p>
            </td>
            <td  >
                <p style="float:left;"><?php  echo $member->member_mobile;?></p>
            </td>
        </tr>
    </tbody>
</table>

<?php
};?>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1><?php if(count($tasks)>0) echo "Task List";?></h1>
<?php
$categorized_tasks=array(
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
foreach ($tasks as $key => $task) {
    # code...
    if($task->category=="") $task->category="Others";
    if(!isset($categorized_tasks[$task->category])) $categorized_tasks[$task->category]=array();
    $categorized_tasks[$task->category][]=$task;
}
foreach ($categorized_tasks as $category=>$list) {
?>
<h2><?php if(count($list)>0) echo $category;?></h2>
<?php foreach ($list as $task) {
?>
<p style="margin-left:40px;" >
    <?php echo (isset($task->dock_list_number)?$task->dock_list_number:"&nbsp;&nbsp;&nbsp;&nbsp;")." ".$task->title; ?>
</p>
<?php
}?>
<?php
}
?>
<!-- <div style="page-break-before: always;"></div> -->

<?php foreach ($tasks as $task) {
?>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<table style="width:100%;" >
    <tbody>
        <tr>
            <td  style="width:50%;">
                Title of task : <b><?php echo $task->title;?></b>
            </td>
            <td  style="width:20%;">
                <?php echo "DLN : <b>".$task->dock_list_number."</b>";?>
            </td>
            <td style="width:30%;" >
                <?php echo "Category : <b>".$task->category."</b>";?>
            </td>
        </tr>
    </tbody>
</table>
<p><?php if($task->supplier) echo "Supplier : ".$task->supplier?></p>
<div>
    <?php echo $task->description;?>
</div>
<div>
    <?php
    $task_cost_items=array_filter($cost_items,function($item)use($task){
        return $item->task_id==$task->id;
    });
    if(count($task_cost_items)>0){
    ?>
    <table style="width:80%;border:1px solid lightgray; border-collapse:collapse;" >
        <thead>
            <tr>
                <th style="border:1px solid lightgray;width:20%;">Name</th>
                <th style="border:1px solid lightgray;width:50%;">Quantity X Unit Price</th>
                <th style="border:1px solid lightgray;width:10%;">Discount</th>
                <th style="border:1px solid lightgray;width:20%;">Quote</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($task_cost_items as $key => $item) {
            ?>
            <tr>
                <td style="border:1px solid lightgray;text-align:center;" >
                    <?php echo $item->name;?>
                </td>
                <td style="border:1px solid lightgray;text-align:center;" >
                    <?php echo $item->quantity." ".$item->measurement." X ".$project_info->currency." ".$item->unit_price;?>
                </td>
                <td style="border:1px solid lightgray;text-align:center;" >
                    <?php echo $item->discount." %";?>
                </td>
                <td style="border:1px solid lightgray;text-align:center;" >
                    <?php echo $item->total_cost;?>
                </td>
            </tr>
            <?php
            } ?>
        </tbody>
    </table>
    <?php } ?>
</div>

<?php
}?>