<div class="modal-body clearfix" >
    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <div class="form-group" >
        <label for="requisition_title" >Requisition title : </label>
        <input 
        name="requisition_title"
        id="requisition_title"
        class="form-control"
        />
    </div>
    <div class="form-group" >
        <label for="requisition_number" >Requisition number : </label>
        <input 
        name="requisition_number"
        id="requisition_number"
        class="form-control"
        />
    </div>
    <div class="form-group" >
        <label for="remarks" >Remarks : </label>
        <textarea
        name="remarks"
        id="remarks"
        class="form-control"
        style="height:20vh;"
        >
        </textarea>
    </div>
</div>
<div class="modal-footer" >
<button class="btn btn-default btn-cancel-requisition"  ><i data-feather="x" class="icon-16" ></i>Close</button>
<button class="btn btn-primary"  ><i data-feather="check" class="icon-16" ></i>Save</button>
</div>
<script>
    $(document).ready(function(){
        $(".btn-cancel-requisition").on("click",function(){
            var $newViewLink = $("#link-of-new-view").find("a");
            $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_corrective_action/".$action_info->id); ?>");
            // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
            $newViewLink.attr("data-post-id", <?php echo $ticket_id;?>);
            $newViewLink.trigger("click");
        })
    })
</script>