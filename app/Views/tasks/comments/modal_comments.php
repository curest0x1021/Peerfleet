<div class="modal-body clearfix task-comments-modal-body">
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
            <?php echo view("tasks/comments/comment_form"); ?>
            
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".task-comments-modal-body").parent().parent().parent().parent().on('hidden.bs.modal',function(){
            window.location.reload()
        })
    })
</script>