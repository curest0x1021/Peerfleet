<?php echo form_open(get_uri("tasks/save_task_from_excel_file"), array("id" => "import-task-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix import-task-modal-body">
    <div class="container-fluid">
    <div class="row">
        <div class=" col-md-6">
            <div class=" card border p-2">
                <div class="card-title  d-flex flex-column align-items-center">
                    <h5><?php echo app_lang('project_form'); ?></h5>
                    <div>The Excel sheet contains task-related information as well as 
                columns where to input the various price related information (for import purposes).
                    </div>
                </div>
                <hr/>
                <div class="card-body d-flex flex-column align-items-center">
                    <img width="100px" src="<?php echo get_file_uri("assets/images/excel.png") ?>" alt="style_1" />
                    <a href="<?php echo get_uri('projects/download_project_form_xlsx/').$project_id;?>" class="btn btn-primary export_project_btn"><span data-feather="download" class="icon-16"></span> <?php echo app_lang('export_project_form'); ?></a>
                </div>
                
            </div>
        </div>
        <div class=" col-md-6">
            <div class=" card border p-2">
                <div class="card-title  d-flex flex-column align-items-center">
                    <h5><?php echo app_lang('quotation_form'); ?></h5>
                    <div>The Excel sheet contains task-related information as well as 
                columns where to input the various price related information (for import purposes).
                    </div>
                </div>
                <hr/>
                <div class="card-body d-flex flex-column align-items-center">
                    <img width="100px" src="<?php echo get_file_uri("assets/images/excel.png") ?>" alt="style_1" />
                    <a type="button" target="_blank" href="<?php echo get_uri("projects/download_quotation_form_xlsx/").$project_id;?>" class="btn btn-primary export_quotation_btn"><span data-feather="download" class="icon-16"></span> <?php echo app_lang('export_quotation_form'); ?></a>
                </div>
                
            </div>
        </div>
        <div class=" col-md-6">
            <div class=" card border p-2">
                <div class="card-title  d-flex flex-column align-items-center">
                    <h5><?php echo app_lang('zip'); ?></h5>
                    <div>All files that are attached to the Task Libraries will be contained in this zip file.

                    </div>
                </div>
                <hr/>
                <div class="card-body d-flex flex-column align-items-center">
                    <img width="100px" src="<?php echo get_file_uri("assets/images/zip.png") ?>" alt="style_1" style="margin-bottom: 30px"/>
                    <a type="button" target="_blank" href="<?php echo get_uri("projects/download_all_zip/").$project_id;?>" class="btn btn-primary export_quotation_btn"><span data-feather="download" class="icon-16"></span> Download zip file</a>
                </div>
                
            </div>
        </div>
        <div class=" col-md-6">
            <div class=" card border p-2">
                <div class="card-title  d-flex flex-column align-items-center">
                    <h5>Cost overview</h5>
                    <div>The Excel sheet contains project-related information about cost overview .
                    </div>
                </div>
                <hr/>
                <div class="card-body d-flex flex-column align-items-center">
                    <img width="100px" src="<?php echo get_file_uri("assets/images/excel.png") ?>" alt="style_1" />
                    <a href="<?php echo get_uri("projects/download_cost_overview_xlsx/").$project_id;?>" target="_blank"  class="btn btn-primary btn_export_cost_overview1"><span data-feather="download" class="icon-16"></span> Export Cost overview XLSX</a>
                </div>
                
            </div>
        </div>
        <div class=" col-md-3"></div>
        <input type="hidden" name="file_name" id="import_file_name" value="" />
        <div id="preview-area"></div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default export_project_all"><span data-feather="download" class="icon-16"></span> <?php echo app_lang('download_all'); ?></button>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function(){
        $(".btn_export_cost_overview").on("click",function(){
            $.ajax({
                url: '<?php echo get_uri("projects/download_cost_overview_xlsx/").$project_id; ?>',
                type: 'POST',
                data:{
                    project_id:<?php echo $project_id;?>,
                    data:$("#table-panel-for-xlsx")[0].innerHTML
                },
                success: function(response,textStatus, jqXHR) {
                    console.log(response)
                    // Create a blob from the response
                    // var blob = new Blob([response], { type: 'application/octet-stream' });

                    // // Create a temporary URL for the blob
                    // var url = window.URL.createObjectURL(blob);

                    // // Create a link element
                    // var link = document.createElement('a');
                    // link.href = url;

                    // var headers = jqXHR.getAllResponseHeaders();
                    // link.download = '<?php echo $project_info->title."_cost_overview.xlsx";?>'; // Specify the filename

                    // // Append the link to the document body
                    // document.body.appendChild(link);

                    // // Trigger a click event on the link to start the download
                    // link.click();

                    // // Remove the link from the document body
                    // document.body.removeChild(link);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                }
            });

        })
    })
    

</script>

