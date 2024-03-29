<div class="modal-body clearfix" >
    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <input hidden class="input-action-id" value="" />
    <div class="form-group" >
        <label>Corrective Action : </label>
        <?php
        $corrective_action_dropdown=array(
            array("id"=>"Arrange service","text"=>"Arrange service"),
            array("id"=>"Guatantee claim","text"=>"Guatantee claim"),
            array("id"=>"Reconditioning / Redelivery","text"=>"Reconditioning / Redelivery"),
            array("id"=>"Repair by crew","text"=>"Repair by crew"),
            array("id"=>"Repair on dry dock","text"=>"Repair on dry dock"),
            array("id"=>"Request maker information","text"=>"Request maker information"),
            array("id"=>"Supply spare","text"=>"Supply spare"),
            array("id"=>"Support","text"=>"Support"),
        );
        ?>
        <input
        class="form-control corrective-action"
        name="corrective_action"
        id="corrective_action"

        />
    </div>
    <p>The following processes can be linked to this corrective action.</p>
    <!-- <div class="row" > -->
        <button class="w-100 btn btn-lg btn-default mb-2 btn-add-task" style="height:5vh;" disabled  data-act="ajax-modal" data-title="Add Task" data-action-url="<?php echo get_uri("tickets/modal_add_task/".$ticket_id);?>">
            <div class="d-flex" >
                <i data-feather="tool" class="icon-16" ></i>
                <div class="flex-grow-1"></div>
                <i data-feather="plus" class="icon-16" ></i>
            </div>
        </button>
        <button class="w-100 btn btn-lg btn-default mb-2 btn-add-requisition" style="height:5vh;" disabled data-act="ajax-modal" data-title="Connect requisition" data-action-url="<?php echo get_uri("tickets/modal_connect_requisition/".$ticket_id);?>">
            <div class="d-flex" >
                <i data-feather="shopping-cart" class="icon-16" ></i>
                <div class="flex-grow-1"></div>
                <i data-feather="plus" class="icon-16" ></i>
            </div>
        </button>
        <button class="w-100 btn btn-lg btn-default mb-2 btn-add-schedule" style="height:5vh;" disabled data-act="ajax-modal" data-title="Add schedule" data-action-url="<?php echo get_uri("tickets/modal_add_schedule/".$ticket_id);?>">
            <div class="d-flex" >
                <i data-feather="calendar" class="icon-16" ></i>
                <div class="flex-grow-1"></div>
                <i data-feather="plus" class="icon-16" ></i>
            </div>
        </button>
    <!-- </div> -->
    <br/>
    <div class="form-group" >
        <label for="remark" >Remark : </label>
        <textarea
        class="form-control remark"
        id="remark"
        name="remakr"
        placeholder="Enter..."
        style="height:20vh;"
        >

        </textarea>
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default btn-modal-close" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
</div>
<script>
    $(document).ready(function(){
        $(".corrective-action").select2({
            data: <?php echo (json_encode($corrective_action_dropdown)); ?>
        });
        $(".corrective-action").on("change",function(event){
            console.log(event.added.text)
            $.ajax({
                url:"<?php echo get_uri("tickets/save_corrective_action");?>",
                method:"POST",
                data:{
                    id:$(".input-action-id")[0].value,
                    ticket_id:<?php echo $ticket_id;?>,
                    corrective_action:event.added.id
                },
                success:function(response){
                    if(JSON.parse(response).success){
                        $(".input-action-id")[0].value=JSON.parse(response).saved_id;
                        $(".btn-add-task").prop("disabled",false);
                    }
                }
            })
        })
        $(".btn-modal-close").on("click",function(){
            window.location.reload()
        })
    })
</script>