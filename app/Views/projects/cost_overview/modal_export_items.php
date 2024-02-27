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
                    <button type="button" class="btn btn-primary export_project_btn"><span data-feather="download" class="icon-16"></span> <?php echo app_lang('export_project_form'); ?></button>
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
                    <button type="button" class="btn btn-primary export_quotation_btn"><span data-feather="download" class="icon-16"></span> <?php echo app_lang('export_quotation_form'); ?></button>
                </div>
                
            </div>
        </div>
        <div class=" col-md-3"></div>
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

