<div class="modal-body clearfix" >
    <?php echo form_open(get_uri("tickets/save_requisition"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
    <?php echo form_close();?>
    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <input hidden class='input-id' value="<?php if(isset($action_info)) echo $action_info->id;?>" />
    <div class="form-group" >
        <label for="requisition_title" >Requisition title : </label>
        <input 
        name="requisition_title"
        id="requisition_title"
        class="form-control input-title"
        value="<?php if(isset($action_info)) echo $action_info->requisition_title;?>"
        />
    </div>
    <div class="form-group" >
        <label for="requisition_number" >Requisition number : </label>
        <input 
        name="requisition_number"
        id="requisition_number"
        class="form-control input-number"
        value="<?php if(isset($action_info)) echo $action_info->requisition_number;?>"
        />
    </div>
    <div class="form-group" >
        <label for="remarks" >Remarks : </label>
        <textarea
        name="remarks"
        id="remarks"
        class="form-control input-remarks"
        style="height:20vh;"
        value=""
        ><?php if(isset($action_info)) echo $action_info->requisition_remarks;?>
        </textarea>
    </div>
</div>
<div class="modal-footer" >
<button class="btn btn-default btn-cancel-requisition"  ><i data-feather="x" class="icon-16" ></i>Close</button>
<button class="btn btn-primary btn-save-requisition"  ><i data-feather="check" class="icon-16" ></i>Save</button>
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
    $(".btn-save-requisition").on("click",function(){
        var rise_csrf_token = $('[name="rise_csrf_token"]').val();
        const id="<?php echo $action_info->id;?>";
        const title=$(".input-title")[0].value;
        const number=$(".input-number")[0].value;
        const remarks=$(".input-remarks")[0].value;
        var myForm=new FormData();
        myForm.append("rise_csrf_token",rise_csrf_token);
        myForm.append("id",id);
        myForm.append("title",title);
        myForm.append("number",number);
        myForm.append("remarks",remarks);
        $.ajax({
            url:"<?php echo get_uri("tickets/save_requisition");?>",
            type:"POST",
            data:myForm,
            processData: false, // Prevent jQuery from automatically processing the data
            contentType: false, 
            success:function(response){
                if(JSON.parse(response).success)
                    {
                        var $newViewLink = $("#link-of-new-view").find("a");
                        $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_corrective_action/".$action_info->id); ?>");
                        // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
                        $newViewLink.attr("data-post-id", <?php echo $ticket_id;?>);
                        $newViewLink.trigger("click");
                    }
            }
        })
    })
</script>