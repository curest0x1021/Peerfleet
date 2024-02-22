
<div class="modal-body clearfix"  >
    <h2>Bulk add Quotes</h2>
    <div class="card" style="border:1px dashed gray; min-height:30vh;" >
        <div class="d-flex align-items-center" >
            <div class="row" >
                <div class="col-md-4" >
                        <button class="btn btn-lg btn-success" >Upload data from file</button>
                        <p>.csv, .tsv, .xls, .xlsx, .xml, .txt spreadsheets accepted.</p>
                </div>
                <div class="col-md-8" >
                    <p>You can upload any .csv, .tsv, .xls, .xlsx, .xml, .txt file with any set of columns as long as it has 1 record per row. The next step will allow you to match your spreadsheet columns to the right data points. You'll be able to clean up or remove any corrupted data before finalizing your report.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>    
</div>
<script>
$(document).ready(function(){
    $(".modal-dialog").addClass('modal-xl').addClass('modal-dialog-centered');
   
})
</script>
