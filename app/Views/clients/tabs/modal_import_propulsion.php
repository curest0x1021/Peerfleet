<div id="ajaxModalContent" >
<style>
    .dragover{
        background-color:lightgray;
    }
</style>
<div class="modal-body clearfix" id="panel-import-yard-xlsx">
    <div class="container-fluid">
        <?php echo form_open(get_uri("clients/import_propulsion"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
        <?php echo form_close();?>
        <div id="upload-area-cost-overview">
            
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
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
       $(".panel-drop-zone").on("click",function(){
        $(".input-file-yard-items").click();
       });
       $('#upload-area-task-cost-items').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
        })
        .on('dragover dragenter', function() {
            $(this).addClass('dragover');
        })
        .on('dragleave dragend drop', function() {
            $(this).removeClass('dragover');
        })
        .on('drop', function(e) {
            console.log(e.originalEvent.dataTransfer.files)
            if(e.originalEvent.dataTransfer.files.length<1) return;
            var myForm=new FormData();
            myForm.append("client_id",<?php echo $client_id?>);
            myForm.append("file",e.originalEvent.dataTransfer.files[0]);
            var rise_csrf_token = $('[name="rise_csrf_token"]').val();
            myForm.append("rise_csrf_token",rise_csrf_token);
            $.ajax({
                url:"<?php echo get_uri('clients/import_propulsion');?>",
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
                        appAlert.error("That was an unvalid file.", {duration: 10000});
                    }
                
                },
                error:function(data){
                    console.log(data)
                    appAlert.error("That was an unvalid file.", {duration: 10000});
                }
            })
        })
       $(".input-file-yard-items").on('change',function(){
        var myForm=new FormData();
        myForm.append("client_id",<?php echo $client_id?>);
        myForm.append("file",$(this)[0].files[0]);
        var rise_csrf_token = $('[name="rise_csrf_token"]').val();
        myForm.append("rise_csrf_token",rise_csrf_token);
        $.ajax({
            url:"<?php echo get_uri('clients/import_propulsion');?>",
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
                    appAlert.error("That was an unvalid file.", {duration: 10000});
                }
            
            },
            error:function(data){
                appAlert.error("That was an unvalid file.", {duration: 10000});
            }
        })
       })
       window.panel_import_yard_xlsx=$("#panel-import-yard-xlsx").appForm({
        closeModalOnSuccess: false,
       })
    });
</script>    
