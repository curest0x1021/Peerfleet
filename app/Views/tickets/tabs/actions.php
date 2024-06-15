<div class="card" >
    <div class="card-body" >
        <div class="box-title"><span>Actions</span></div>
        <?php foreach ($allActions as $key => $action) {
        ?>
            <button class='btn btn-default btn-lg mb-1 w-100' data-act="ajax-modal" data-title="Edit Corrective Action" data-action-url="<?php echo get_uri("tickets/modal_corrective_action/".$action->id);?>"  >
                <div class="d-flex align-items-center justify-content-around" >
                    <p><?php echo $action->corrective_action;?></p>
                    <div class="flex-grow-1" ></div>
                    <span class="badge <?php if($action->task_title){?>bg-secondary<?php }?>" style="margin-left:10px;" ><i data-feather="tool" class="icon-16" ></i></span>
                    <span class="badge <?php if($action->requisition_title){?>bg-secondary<?php }?>" style="margin-left:10px;" ><i data-feather="shopping-cart" class="icon-16" ></i></span>
                    <span class="badge <?php if($action->schedule_port){?>bg-secondary<?php }?>" style="margin-left:10px;" ><i data-feather="calendar" class="icon-16" ></i></span>
                </div>
            </button>
        <?php
        } ?>
        <?php for($i=0;$i<3-count($allActions);$i++){ ?>
            <?php echo modal_anchor(get_uri("tickets/modal_add_corrective_action/".$ticket_id),"<button class='btn btn-default btn-lg mb-1 w-100' ><i data-feather='plus' class='icon-16' ></i></button>",array("title"=>"Add corrective action"));?>
        <?php }?>
        
    </div>
</div>