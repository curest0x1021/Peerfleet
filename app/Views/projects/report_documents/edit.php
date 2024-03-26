<link type="text/css" href="<?php echo base_url("assets/ckeditor5-document/");?>sample/css/sample.css" rel="stylesheet" media="screen" />
<div id="page-content" class="page-wrapper clearfix grid-button">
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
            <main>
                <div class="centered">
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


<script src="<?php echo base_url("assets/ckeditor5-document/");?>ckeditor.js"></script>
<?php echo view("report_templates/editor_script");?>
<script>
	$(document).ready(function(){
        var project_detail=<?php echo json_encode($project_detail);?>;
        console.log(project_detail)
        DecoupledEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            extraPlugins: [ MyCustomUploadAdapterPlugin ]
		} )
		.then( editor => {
			const toolbarContainer = document.querySelector( 'main .toolbar-container' );

			toolbarContainer.prepend( editor.ui.view.toolbar.element );

			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
        $(".save-report-template").on("click",function(){
            var title=$(".report-template-title")[0].value;
            var id=$(".report-template-id")[0].value;
            var content=window.editor.getData();
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            var myForm=new FormData();
            myForm.append("id",id);
            myForm.append("title",title);
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

