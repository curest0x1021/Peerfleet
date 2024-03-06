<div class="modal-body clearfix import-task-modal-body">
    <div class="box-title"><span ><?php echo app_lang("comments"); ?></span></div>
    <!--Task comment section-->
    <div class="clearfix">
        <div class="mb5">
            <strong>Write a comment. </strong>
        </div>
        <div class="b-t pt10 list-container">
            <?php 
            echo view("tasks/comments/comment_list_text"); 
            ?>
            <?php //if ($can_comment_on_tasks) { ?>
                <?php echo view("tasks/comments/comment_form"); ?>
            <?php// } ?>
            
        </div>
    </div>
</div>