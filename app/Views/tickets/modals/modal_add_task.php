<div class="modal-body clearfix" >
    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <div>

    </div>
</div>
<div class="modal-footer" >
    <!-- <button  class="btn btn-default" data-bs-dismiss="modal" >Close</button> -->
    <button  class="btn btn-default btn-cancel-task"  ><i data-feather="x" class="icon-16" ></i>Cancel</button>
    <button  class="btn btn-primary btn-save-task"  ><i data-feather="check-cirlce" class="icon-16" ></i>Save</button>
</div>
<script>
    $(document).ready(function(){
        $(".btn-cancel-task").on("click",function(){
            var $newViewLink = $("#link-of-new-view").find("a");
            $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_add_corrective_action/".$ticket_id); ?>");
            // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
            $newViewLink.attr("data-post-id", <?php echo $ticket_id;?>);
            $newViewLink.trigger("click");
        })
    })
</script>