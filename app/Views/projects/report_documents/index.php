<div class="card" >
    <div class="card-body" >
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
    </div>
</div>
