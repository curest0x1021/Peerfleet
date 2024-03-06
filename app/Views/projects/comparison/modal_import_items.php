<div id="ajaxModalContent" >
<div class="modal-body clearfix" id="panel-import-yard-xlsx">
    <div class="container-fluid">
        <?php echo form_open(get_uri("projects/import_yard_xlsx"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
        <?php echo form_close();?>
        <div id="upload-area">
            
            <div class="d-flex justify-content-center align-items-center panel-drop-zone" style="height:20vh;border:1px dashed lightgray;" >
                <div class="text-center" >    
                    <p>Drag-and-drop documents here</p>
                    <p>(or click to browse...)</p>
                </div>
            </div>
        </div>
        <input type="hidden" name="file_name" id="import_file_name" value="" />
        <input type="file" hidden class="input-file-yard-items" />
        <div id="preview-area"></div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default cancel-upload" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <!-- <button id="form-previous" type="button" class="btn btn-default hide"><span data-feather="arrow-left-circle" class="icon-16"></span> <?php //echo app_lang('back'); ?></button>
    <button id="form-next" type="button" disabled="true" class="btn btn-info text-white"><span data-feather="arrow-right-circle" class="icon-16"></span> <?php //echo app_lang('next'); ?></button>
    <button id="form-submit" type="button" disabled="true" class="btn btn-primary start-upload hide"><span data-feather="check-circle" class="icon-16"></span> <?php// echo app_lang('upload'); ?></button> -->
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
       $(".panel-drop-zone").on("click",function(){
        $(".input-file-yard-items").click();
       });
       $("#upload-area").on("drag",function(e){
        e.preventDefault();
       });
       $("#upload-area").on("drop",function(e){
        e.preventDefault();
        console.log(e)
       });
       $(".input-file-yard-items").on('change',function(){
        var myForm=new FormData();
        myForm.append("shipyard_id",<?php echo $shipyard_id?>);
        myForm.append("file",$(this)[0].files[0]);
        var rise_csrf_token = $('[name="rise_csrf_token"]').val();
        myForm.append("rise_csrf_token",rise_csrf_token);
        $.ajax({
            url:"<?php echo get_uri('projects/import_task_cost_items');?>",
            method:"POST",
            data:myForm,
            contentType: false, // Set contentType to false, as FormData will automatically set the correct type
            processData: false,
            success:function(response){
                if(JSON.parse(response).success) {
                    $maskTarget=$("#ajaxModalContent").find(".modal-body");
                    var padding = $maskTarget.height() - 80;
                    if (padding > 0) {
                        padding = Math.floor(padding / 2);
                    }
                    $maskTarget.after("<div class='modal-mask'><div class='circle-loader'></div></div>");
                    //check scrollbar
                    var height = $maskTarget.outerHeight();
                    $('.modal-mask').css({"width": $maskTarget.width() + 22 + "px", "height": height + "px", "padding-top": padding + "px"});
                    $maskTarget.closest('.modal-dialog').find('[type="submit"]').attr('disabled', 'disabled');
                    $maskTarget.addClass("hide");
                    window.panel_import_yard_xlsx.closeModal()
                    window.location.reload();
                }else{
                    
                }
            
            },
            error:function(data){
                console.log(data)
            }
        })
       })
       window.panel_import_yard_xlsx=$("#panel-import-yard-xlsx").appForm({
        closeModalOnSuccess: false,
       })
    });
</script>    
