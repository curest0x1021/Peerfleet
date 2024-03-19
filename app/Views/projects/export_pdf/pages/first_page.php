<?php echo view('projects/export_pdf/layouts/header.php');?>
<?php if(unserialize($client_info->image)){?>
    <img style="width:80%;height:auto;" src="<?php echo encode_img_base64(get_setting("profile_image_path")."/".unserialize($client_info->image)["file_name"]);?>" alt="logo"/>
<?php } ?>
<h2><?php echo $client_info->charter_name;?> - <?php echo $project_info->title;?></h2>
<h3>Start Date : <?php echo $project_info->start_date;?></h3>
<h3>Deadline : <?php echo $project_info->deadline;?></h3>
<h4>Label : <?php
$label_data=explode("--::--",$project_info->labels_list);
if(array_key_exists(1,$label_data)) echo $label_data[1];
 ?></h4>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Vessel Information</h1>
<h2>General Information</h2>
<h4><?php if($client_info->charter_name) echo "Vessel name : ".$client_info->charter_name; ?></h4>
<h4><?php if($vessel_info) echo "Vessel type : ".$vessel_info->title; ?></h4>
<h4><?php if($client_info->imo_number) echo "IMO number : ".$client_info->imo_number; ?></h4>
<h4><?php if($client_info->flag_state) echo "Flag state : ".$client_info->flag_state; ?></h4>
<h4><?php if($client_info->port_of_registry) echo "Port of registry : ".$client_info->port_of_registry; ?></h4>
<h4><?php if($client_info->classification_society) echo "Classification society : ".$client_info->classification_society; ?></h4>
<h2>Dimensions and Capacities</h2>
<h4><?php if($client_info->gross_tonnage) echo "Gross tonnage : ".$client_info->gross_tonnage." t"; ?></h4>
<h4><?php if($client_info->length_over_all) echo "Length over all (L.O.A): ".$client_info->length_over_all." m"; ?></h4>
<h4><?php if($client_info->length_between_perpendiculars) echo "Length between perpendiculars (L.B.P): ".$client_info->length_between_perpendiculars." m"; ?></h4>
<h4><?php if($client_info->breadth_moulded) echo "BEAM/Breadth moulded : ".$client_info->breadth_moulded." m"; ?></h4>
<h4><?php if($client_info->depth_moulded) echo "Depth moulded : ".$client_info->depth_moulded." m"; ?></h4>
<h4><?php if($client_info->draught_scantling) echo "Draught scantling : ".$client_info->draught_scantling." m"; ?></h4>
<h4><?php if($client_info->hull_design) echo "Hull design : ".$client_info->hull_design; ?></h4>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>

<h2>Propulsion</h2>
<div style="" >
<table style="width:100%;" >
    <tbody>
        <tr>
            <td style="width:50%;" >
                <h3>Main engine</h3>
                <p><?php if($client_info->main_engine_maker) echo "Maker : ".$client_info->main_engine_maker; ?></p>
                <p><?php if($client_info->main_engine_model) echo "Model : ".$client_info->main_engine_model; ?></p>
                <p><?php if($client_info->main_engine_continuous_output) echo "Continuous output: ".$client_info->main_engine_continuous_output; ?></p>
                <p><?php if($client_info->main_engine_bore) echo "Bore : ".$client_info->main_engine_bore; ?></p>
                <p><?php if($client_info->main_engine_stroke) echo "Stroke : ".$client_info->main_engine_stroke." m"; ?></p>
                <p><?php if($client_info->main_engine_serial_number) echo "Serial number : ".$client_info->main_engine_serial_number." m"; ?></p>
                <p><?php if($client_info->main_engine_quantity) echo "Quantity : ".$client_info->main_engine_quantity; ?></p>
                <h3>Auxiliary engine</h3>
                <p><?php if($client_info->auxiliary_engine_maker) echo "Maker : ".$client_info->auxiliary_engine_maker; ?></p>
                <p><?php if($client_info->auxiliary_engine_model) echo "Model : ".$client_info->auxiliary_engine_model; ?></p>
                <p><?php if($client_info->auxiliary_engine_output) echo "Output : ".$client_info->auxiliary_engine_output; ?></p>
                <p><?php if($client_info->auxiliary_engine_serial_number) echo "Serial number : ".$client_info->auxiliary_engine_serial_number." m"; ?></p>
                <p><?php if($client_info->auxiliary_engine_quantity) echo "Quantity : ".$client_info->auxiliary_engine_quantity; ?></p>
                <h3>Emergency generator</h3>
                <p><?php if($client_info->emergency_generator_maker) echo "Maker : ".$client_info->emergency_generator_maker; ?></p>
                <p><?php if($client_info->emergency_generator_model) echo "Model : ".$client_info->emergency_generator_model; ?></p>
                <p><?php if($client_info->emergency_generator_output) echo "Output : ".$client_info->emergency_generator_output; ?></p>
                <p><?php if($client_info->emergency_generator_serial_number) echo "Serial number : ".$client_info->emergency_generator_serial_number." m"; ?></p>
                <p><?php if($client_info->emergency_generator_quantity) echo "Quantity : ".$client_info->emergency_generator_quantity; ?></p>
            </td>
            <td>
                <h3>Shaft generator</h3>
                <p><?php if($client_info->shaft_generator_maker) echo "Maker : ".$client_info->shaft_generator_maker; ?></p>
                <p><?php if($client_info->shaft_generator_model) echo "Model : ".$client_info->shaft_generator_model; ?></p>
                <p><?php if($client_info->shaft_generator_output) echo "Output : ".$client_info->shaft_generator_output; ?></p>
                <p><?php if($client_info->shaft_generator_serial_number) echo "Serial number : ".$client_info->shaft_generator_serial_number." m"; ?></p>
                <p><?php if($client_info->shaft_generator_quantity) echo "Quantity : ".$client_info->shaft_generator_quantity; ?></p>
                <h3>Propeller</h3>
                <p><?php if($client_info->propeller_maker) echo "Maker : ".$client_info->propeller_maker; ?></p>
                <p><?php if($client_info->propeller_type) echo "Type : ".$client_info->propeller_type; ?></p>
                <p><?php if($client_info->propeller_number_of_blades) echo "Number of blades : ".$client_info->propeller_number_of_blades; ?></p>
                <p><?php if($client_info->propeller_diameter) echo "Diameter : ".$client_info->propeller_diameter." m"; ?></p>
                <p><?php if($client_info->propeller_pitch) echo "Pitch : ".$client_info->propeller_pitch; ?></p>
                <p><?php if($client_info->propeller_material) echo "Material : ".$client_info->propeller_material; ?></p>
                <p><?php if($client_info->propeller_weight) echo "Weight : ".$client_info->propeller_weight; ?></p>
                <p><?php if($client_info->propeller_output) echo "Output : ".$client_info->propeller_output; ?></p>
                <p><?php if($client_info->propeller_quantity) echo "Quantity : ".$client_info->propeller_quantity; ?></p>
            </td>
        </tr>
    </tbody>
</table>
    
    
</div>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h2>Side Thruster</h2>
<p><?php if($client_info->bow_thruster_number) echo "Number of bow thrusters : ".$client_info->bow_thruster_number; ?></p>
<p><?php if($client_info->bow_thruster_maker) echo "Maker of bow thrusters : ".$client_info->bow_thruster_maker; ?></p>
<p><?php if($client_info->bow_thruster_type) echo "Type of bow thrusters : ".$client_info->bow_thruster_type; ?></p>
<p><?php if($client_info->bow_thruster_power) echo "Power of bow thrusters : ".$client_info->bow_thruster_power; ?></p>
<p><?php if($client_info->stern_thruster_number) echo "Number of stern thrusters : ".$client_info->stern_thruster_number; ?></p>
<p><?php if($client_info->stern_thruster_maker) echo "Maker of stern thrusters : ".$client_info->stern_thruster_maker; ?></p>
<p><?php if($client_info->stern_thruster_type) echo "Type of stern thrusters : ".$client_info->stern_thruster_type; ?></p>
<p><?php if($client_info->stern_thruster_power) echo "Power of stern thrusters : ".$client_info->stern_thruster_power; ?></p>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h3>Project Description</h3>
<div><?php echo $project_info->description;?></div>
<h3>Team Members</h3>
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
<h3>Task List</h3>
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
<h4><?php if(count($list)>0) echo $category;?></h4>
<?php foreach ($list as $task) {
?>
<p style="margin-left:40px;" >
    <?php echo $task->title; ?>
</p>
<?php
}?>
<?php
}
?>
<div style="page-break-before: always;"></div>

<?php foreach ($tasks as $task) {
?>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<table style="width:100%;" >
    <tbody>
        <tr>
            <td  style="width:50%;">
                <?php echo $task->title;?>
            </td>
            <td  style="width:10%;">
                <?php echo $task->dock_list_number;?>
            </td>
            <td style="width:40%;" >
                <?php echo $task->category;?>
            </td>
        </tr>
    </tbody>
</table>
<p> <?php echo "Supplier : ".$task->supplier?></p>
<div style="page-break-before: always;"></div>
<?php
}?>