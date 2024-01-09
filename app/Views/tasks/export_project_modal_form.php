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
                    <div>All files that are attached to the project will be contained in this zip file.

                    </div>
                </div>
                <hr/>
                <div class="card-body d-flex flex-column align-items-center">
                    <img width="100px" src="<?php echo get_file_uri("assets/images/zip.png") ?>" alt="style_1" style="margin-bottom: 30px"/>
                    <?php echo anchor(get_uri("projects/download_project_file/") . $project_id, "<i data-feather='download' class='icon-16'></i> " . app_lang("export_project_zip"), array("title" => app_lang("export_project_zip"), "id" => "export_project_zip", "class" => "btn btn-primary")); ?>
                </div>
                
            </div>
        </div>
        <div class=" col-md-3"></div>
        <input type="hidden" name="file_name" id="import_file_name" value="" />
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
        <div id="preview-area"></div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default export_project_all"><span data-feather="download" class="icon-16"></span> <?php echo app_lang('download_all'); ?></button>
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.export_project_btn', function (e) {

            $.ajax({
                url: "<?php echo get_uri('tasks/export_project_tasks_data') ?>",
                type: 'POST',
                dataType: 'json',
                data: {project_id:<?php echo $project_id; ?> },
                success: async function (result) {

                    /* dynamically import the scripts in the event listener */
                    const XLSX = await import("https://cdn.sheetjs.com/xlsx-0.20.1/package/xlsx.mjs");
                    const cptable = await import("https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/cpexcel.full.mjs");
                    XLSX.set_cptable(cptable);

                    const wb = XLSX.utils.book_new();
                    const ws = XLSX.utils.json_to_sheet(result);
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                    XLSX.writeFile(wb, "project_name.xlsx");
                }
            });

        })

        $('body').on('click', '.export_quotation_btn', function (e) {

            $.ajax({
                url: "<?php echo get_uri('tasks/export_quotation_project_data') ?>",
                type: 'POST',
                dataType: 'json',
                data: {project_id:<?php echo $project_id; ?> },
                success: async function (result) {

                    /* dynamically import the scripts in the event listener */
                    const XLSX = await import("https://cdn.sheetjs.com/xlsx-0.20.1/package/xlsx.mjs");
                    const cptable = await import("https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/cpexcel.full.mjs");
                    XLSX.set_cptable(cptable);

                    const wb = XLSX.utils.book_new();
                    const ws = XLSX.utils.json_to_sheet(result);
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                    XLSX.writeFile(wb, "project_name.xlsx");
                }
            });

        })
    });
</script>    
