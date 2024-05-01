<table style="width:100%" >
    <tbody>
        <tr>
            <td style="width:40%" >
                <img src="<?php echo encode_img_base64(get_logo_url());?>" alt="logo"/>
            </td>
            <td style="width:20%">
                <p><?php echo $project_info->title?></p>
            </td>
            <td style="width:10%" ></td>
            <td style="width:30%">
                <p><?php echo date("d.m.Y",strtotime($project_info->start_date))." ~ ".date("d.m.Y",strtotime($project_info->deadline));?></p>
            </td>
            <!-- <td style="width:10%" >
            <?php 
            //echo date('d.m.Y');
            ?>
            </td> -->
        </tr>
    </tbody>
</table>
<div style="background-color:#3270b8; width:100%; height:5px;" ></div>
<br/>
