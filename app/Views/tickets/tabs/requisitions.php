<div class="card" >
    <div class="card-body" >
        <!-- <h4>Requisitions</h4> -->
        <div class="box-title"><span>Requisitions</span></div>
        <?php foreach ($allActions as $key => $action) {
        ?>
            <?php if(isset($action)&&$action->requisition_number){ ?>
                <button class='btn btn-default btn-lg mb-1 w-100' data-act="ajax-modal" data-title="Edit Corrective Action" data-action-url="<?php echo get_uri("tickets/modal_corrective_action/".$action->id);?>"  >
                    <div class="text-start" >
                        <!-- <h5>&nbsp;Action : <?php echo $action->task_title;?></h5> -->
                        <h5><?php echo $action->corrective_action;?></h5>
                    </div>
                    <div class="row text-start" >
                        <div class="col-md-4" >
                            <p>
                                Title : <?php echo $action->requisition_title;?>
                            </p>
                        </div>
                        <div class="col-md-4" >
                            <p>
                                Number : <?php echo $action->requisition_number;?>
                            </p>
                        </div>
                    </div>
                </button>
            <?php }?>
        <?php
        } ?>
    </div>
</div>