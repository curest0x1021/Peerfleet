<div class="card" >
    <div class="card-body" >
        <h4>Requisitions</h4>
        <?php foreach ($allActions as $key => $action) {
        ?>
            <?php if(isset($action)&&$action->task_title){ ?>
                <button class='btn btn-default btn-lg mb-1 w-100' data-act="ajax-modal" data-title="Edit Corrective Action" data-action-url="<?php echo get_uri("tickets/modal_corrective_action/".$action->id);?>"  >
                    <div class="d-flex align-items-center justify-content-around" >
                        <h5>&nbsp;Action : <?php echo $action->task_title;?></h5>
                        <p><?php echo $action->corrective_action;?></p>
                    </div>
                    <div class="row" >
                        <div class="col-md-4" >
                            <h5>
                                Title :
                            </h5>
                            <p><?php if(isset($action)) echo $action->requisition_title;?></p>
                        </div>
                        <div class="col-md-4" >
                            <h5>
                                Number :
                            </h5>
                            <p><?php if(isset($action)) echo $action->requisition_number;?></p>
                        </div>
                    </div>
                </button>
            <?php } ?>
        <?php
        } ?>
    </div>
</div>