<?php echo view('projects/export_pdf/layouts/header.php');?>

<h2><?php echo $client_info->charter_name;?> - <?php echo $project_info->title;?></h2>
<h3>Start Date : <?php echo $project_info->start_date;?></h3>
<h3>Deadline : <?php echo $project_info->deadline;?></h3>
<div style="page-break-before: always;"></div>