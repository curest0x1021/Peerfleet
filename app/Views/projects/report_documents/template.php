<link type="text/css" href="<?php echo base_url("assets/ckeditor5-build/");?>sample/styles.css" rel="stylesheet" media="screen" />
<div id="page-content" class="page-wrapper clearfix grid-button">
<a href="<?php echo get_uri("projects/view/".$project_detail->id);?>" ><h3><i data-feather="arrow-left"   ></i>Back</h3></a>
    <div class="card" >
        <div class="card-body" >
        <?php echo form_open(get_uri("tasks/save"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
        <?php echo form_close();?>
            <div class="form-group" >
                <label>Title : </label>
                <input
                name="title"
                id="title"
                class="form-control report-template-title"
                value="<?php echo isset($template_info)?$template_info->title:"";?>"
                />
            </div>
            <div class="position-fixed d-flex flex-column align-items-center justify-content-around" style="z-index:1000;width:8vw;top:35vh;bottom:35vh;right:5vh;border-radius:15px;background-color:rgba(0,0,0,0.5);" >
                <div class="text-white" >Digital Shelf</div>    
                <?php echo modal_anchor(get_uri("projects/modal_table_templates/".$project_detail->id),'<button class="btn btn-default" style="margin-left:5px;margin-right:5px;" >Table templates</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_chart_templates/".$project_detail->id),'<button class="btn btn-default" style="margin-left:5px;margin-right:5px;"  >Chart templates</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_project_images/".$project_detail->id),'<button class="btn btn-default" style="margin-left:5px;margin-right:5px;"  >Project images</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_text_templates/".$project_detail->id),'<button class="btn btn-default" style="margin-left:5px;margin-right:5px;"  >Text templates</button>',array()); ?>
            </div>
            <main>
                <div class="centered">
                    <div class="row">
                        <div class="document-editor__toolbar"></div>
                    </div>
                    <div class="document-editor">
                        <div class="toolbar-container"></div>
                        <div class="content-container">
                            <div id="editor">
                                <?php echo isset($template_info)?$template_info->content:"";?>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </main>
        </div>
        <div class="card-footer" >
            <a class="btn btn-default" ><i data-feather="x" class="icon-16" ></i>Cancel</a>
            <button class="btn btn-primary save-report-template" ><i data-feather="check-circle" class="icon-16" ></i>save</button>
        </div>
    </div>
</div>


<script src="<?php echo base_url("assets/ckeditor5-build/");?>build/ckeditor.js"></script>
<?php echo view("report_templates/editor_script");?>
<script>
	$(document).ready(function(){
        var project_detail=<?php echo json_encode($project_detail);?>;
        var client_info=<?php echo json_encode($client_info);?>;
        function replaceWord(text, oldWord, newWord) {
            // Create a regular expression with the 'g' flag to replace all occurrences
            const regex = new RegExp( oldWord , 'gi');
            // Replace all occurrences of the old word with the new word
            return text.replace(regex, newWord);
        }
        function getImageBase64Sync(imageUrl) {
            // Make a synchronous XMLHttpRequest to fetch the image
            const xhr = new XMLHttpRequest();
            xhr.open('GET', imageUrl, false);  // Make the request synchronous
            xhr.overrideMimeType('text/plain; charset=x-user-defined');
            xhr.send(null);

            // Check if the request was successful
            if (xhr.status === 200) {
                // Convert the binary data to a base64-encoded string
                const base64Data = btoa(xhr.responseText);
                // Determine the image mime type
                const mimeType = xhr.getResponseHeader('Content-Type');
                // Construct the data URL
                const dataURL = `data:${mimeType};base64,${base64Data}`;
                return dataURL;
            } else {
                throw new Error('Failed to fetch image');
            }
        }
        var report_content=document.getElementById("editor").innerHTML;
        var report_content=replaceWord(report_content,"{{project.title}}","<?php echo $project_detail->title;?>")
        var report_content=replaceWord(report_content,"{{project.charter_name}}","<?php echo $project_detail->charter_name;?>")
        var report_content=replaceWord(report_content,"{{project.start_date}}","<?php echo date('d.m.Y', strtotime($project_detail->start_date));?>")
        var report_content=replaceWord(report_content,"{{project.deadline}}","<?php echo date('d.m.Y', strtotime($project_detail->deadline));?>")
        var report_content=replaceWord(report_content,"{{project.description}}","<div><?php echo $project_detail->description;?></div>")
        var report_content=replaceWord(report_content,"{{vessel.image}}",`<img 
        style="width:300px;"
        src="<?php if(unserialize($client_info->image)) {echo encode_img_base64(get_setting("profile_image_path")."/".unserialize($client_info->image)["file_name"]);}
        else {echo encode_img_base64(base_url("assets/images/ship_img.jpg"));}?>"
        />`)
        var report_content=replaceWord(report_content,"{{project.currency}}","<?php echo $project_detail->currency;?>")
        var report_content=replaceWord(report_content,"{{project.members}}",`
        <div>
        <h2 style="color:#3270b8;text-align:center;" >Team Members</h2>
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
        </div>
        `)
        var report_content=replaceWord(report_content,"{{team_members}}",`
        <div>
        <h2 style="color:#3270b8;text-align:center;" >Team Members</h2>
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
        </div>
        `)
        window.watchdog.editor.setData(report_content)
        $(".save-report-template").on("click",function(){
            var title=$(".report-template-title")[0].value;
            var content=window.watchdog.editor.getData();
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            var myForm=new FormData();
            myForm.append("title",title);
            myForm.append("project_id",<?php echo $project_detail->id;?>);
            myForm.append("id","");
            myForm.append("content",content);
            myForm.append("rise_csrf_token",rise_csrf_token);
            $.ajax({
                url:"<?php echo get_uri("projects/save_report_document");?>",
                method:"POST",
                data:myForm,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false, 
                success:function(response){
                    if(JSON.parse(response).success){
                        window.location="<?php echo get_uri("projects/view/".$project_detail->id);?>";
                    }
                }
            })
        })
    })
</script>

