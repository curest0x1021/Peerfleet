<div class="card" >
    <div class="card-body" >
        <h3>Available Report templates</h3>
        <br/>
        <div class="row" >
            <?php foreach ($allTemplates as $key => $template) {
            ?>
                <div class="col-md-1" >
                    <a href="<?php echo get_uri("projects/report_templates/".$project_info->id."/".$template->id);?>" >
                        <div class="d-flex align-items-center justify-content-center" >
                            <i data-feather="book" class="icon-64" ></i>
                        </div>
                        <p class="text-center" ><?php echo $template->title;?></p>
                    </a>
                </div>
            <?php
            } ?>
        </div>
        <br/>
        <h3>Report Documents</h3>
        <div class="table-responsive">
            <table id="budget-groups-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#budget-groups-table").appTable({
            source: '<?php echo_uri("projects/report_documents_list_data/".$project_info->id) ?>',
            order: [[0, 'desc']],
            columns: [
                {title: '<?php echo app_lang("id"); ?>', "class": "w200"},
                {title: '<?php echo app_lang("title"); ?>', "class": "all"},
                {title: 'Number', "class": "w250"},
                {title: "<i data-feather='menu' class='icon-16'></i>", "class": "text-center option w100"}
            ]
        });
    });
</script>
