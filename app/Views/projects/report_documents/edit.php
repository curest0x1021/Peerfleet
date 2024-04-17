<link type="text/css" href="<?php echo base_url("assets/ckeditor5-build/");?>sample/styles.css" rel="stylesheet" media="screen" />

<div id="page-content" class="page-wrapper clearfix grid-button">
<a href="<?php echo get_uri("projects/view/".$project_detail->id);?>" ><h3><i data-feather="arrow-left" ></i>Back</h3></a>
    <div class="card" >
        <div class="card-body" >
        <?php echo form_open(get_uri("tasks/save"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
        <?php echo form_close();?>
                <input
                    name="id"
                    id="id"
                    class="form-control report-template-id"
                    hidden
                    value="<?php echo isset($document_info)?$document_info->id:"";?>"
                />
            <div class="form-group" >
                <label>Title : </label>
                <input
                name="title"
                id="title"
                class="form-control report-template-title"
                value="<?php echo isset($document_info)?$document_info->title:"";?>"
                />
            </div>
            <div class="d-flex align-items-center justify-content-around" style="margin-bottom:10px;" >
                <?php echo modal_anchor(get_uri("projects/modal_table_templates/".$project_detail->id),'<button class="btn btn-default" >Table templates</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_chart_templates/".$project_detail->id),'<button class="btn btn-default" >Chart templates</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_project_images/".$project_detail->id),'<button class="btn btn-default" >Project images</button>',array()); ?>
                <?php echo modal_anchor(get_uri("projects/modal_text_templates/".$project_detail->id),'<button class="btn btn-default" >Text templates</button>',array()); ?>
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
                                <?php echo isset($document_info)?$document_info->content:"";?>
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
        
        $(".save-report-template").on("click",function(){
            var title=$(".report-template-title")[0].value;
            var id=$(".report-template-id")[0].value;
            var content=window.watchdog.editor.getData();
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            var myForm=new FormData();
            myForm.append("id",id);
            myForm.append("title",title);
            myForm.append("project_id",<?php echo $project_detail->id;?>);
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
                        window.location="<?php echo get_uri("projects/report_documents/")?>"+JSON.parse(response).saved_id;
                    }
                }
            })
        })
    })
</script>

