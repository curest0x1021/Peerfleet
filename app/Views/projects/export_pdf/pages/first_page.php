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
<div></div>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h2>Propulsion</h2>
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
<p><?php if($client_info->auxiliary_engine_output) echo "Output: ".$client_info->auxiliary_engine_output; ?></p>
<p><?php if($client_info->auxiliary_engine_serial_number) echo "Serial number : ".$client_info->auxiliary_engine_serial_number." m"; ?></p>
<p><?php if($client_info->auxiliary_engine_quantity) echo "Quantity : ".$client_info->auxiliary_engine_quantity; ?></p>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Side Thruster</h1>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h3>Project Description</h3>
<div><?php echo $project_info->description;?></div>
<h3>Team Members</h3>
<div><?php echo $project_info->description;?></div>
