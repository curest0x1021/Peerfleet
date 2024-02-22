
<div class="modal-body clearfix" >
    <h2>Bulk add Quotes</h2>
    <?php echo form_open(get_uri("projects/import_yard_xlsx"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
    <?php echo form_close(); ?>
    <div class="card" style="border:1px dashed gray; min-height:30vh;" >
        <div class="card-body" >
            <div class="d-flex align-items-center" >
                <div class="row" >
                    <div class="col-md-4" >
                            <button class="btn btn-lg btn-success btn-select-yard-xlsx" >Upload data from file</button>
                            <p>.csv, .tsv, .xls, .xlsx, .xml, .txt spreadsheets accepted.</p>
                    </div>
                    <div class="col-md-8" >
                        <p>You can upload any .csv, .tsv, .xls, .xlsx, .xml, .txt file with any set of columns as long as it has 1 record per row. The next step will allow you to match your spreadsheet columns to the right data points. You'll be able to clean up or remove any corrupted data before finalizing your report.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>    
</div>
<input hidden type="file" class="yard-xlsx-file-selector" />
<script>
$(document).ready(function(){
    $(".modal-dialog").addClass('modal-xl').addClass('modal-dialog-centered');
    
    $(".btn-select-yard-xlsx").on("click",function(){
        $(".yard-xlsx-file-selector").click()
    })
    $(".yard-xlsx-file-selector").on("change",function(e){
        if(e.target.files.length>0){
            var myForm=new FormData();
            myForm.append('file',e.target.files[0]);
            myForm.append('shipyard_id','<?php echo $shipyard_id;?>');
            myForm.append("rise_csrf_token",$('[name="rise_csrf_token"]').val())
            $.ajax({
                url:'<?php echo get_uri("projects/import_yard_xlsx");?>',
                method:'POST',
                data:myForm,
                contentType: false, // Set contentType to false, as FormData will automatically set the correct type
                processData: false,
                success:function(response){
                    console.log(response)
                    window.location.reload();
                }
            })
        }
    })
})
</script>
