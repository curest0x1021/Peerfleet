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
            <div class="d-flex align-items-center justify-content-around" style="margin-bottom:10px;" >
                <?php echo modal_anchor(get_uri("projects/modal_table_templates/".$project_detail->id),'<button class="btn btn-default" >Table templates</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_chart_templates/".$project_detail->id),'<button class="btn btn-default" >Chart templates</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_project_images/".$project_detail->id),'<button class="btn btn-default" >Project images</button>',array()); ?>
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
        src="<?php echo encode_img_base64(get_setting("profile_image_path")."/".unserialize($client_info->image)["file_name"]);?>"
        />`)
        var report_content=replaceWord(report_content,"{{project.currency}}","<?php echo $project_detail->currency;?>")
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

