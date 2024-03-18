<?php echo view('projects/export_pdf/layouts/header.php');?>
<img style="width:80%;height:auto;" src="<?php echo encode_img_base64(get_setting("profile_image_path")."/".unserialize($client_info->image)["file_name"]);?>" alt="logo"/>
<h2><?php echo $client_info->charter_name;?> - <?php echo $project_info->title;?></h2>
<h3>Start Date : <?php echo $project_info->start_date;?></h3>
<h3>Deadline : <?php echo $project_info->deadline;?></h3>
<h4>Label : <?php
$label_data=explode("--::--",$project_info->labels_list);
 echo $label_data[1];
 ?></h4>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Vessel Information</h1>
<h2>General Information</h2>
<h2>Dimensions and Capacities</h2>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h2>Propulsion</h2>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h1>Side Thruster</h1>
<div style="page-break-before: always;"></div>
<?php echo view('projects/export_pdf/layouts/header.php');?>
<h3>Project Description</h3>
<div><?php echo $project_info->description;?></div>
<h3>Team Members</h3>
<div><?php echo $project_info->description;?></div>
