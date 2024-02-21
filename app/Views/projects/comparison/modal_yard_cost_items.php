<div class="modal-body clearfix" >
    <div class="d-flex" style="overflow-x:auto;" >
        
            
        <?php
            foreach ($allProjectYards as $oneYard) {
                $id=$oneYard->id;
        ?>
            <div class="card" style="min-width:30vw;border:1px solid lightgray;margin-right:1vw;" >
                <div class="card-header" ><?php echo $oneYard->title;?></div>
                <div class="card-body" id="yard-cost-items-panel-<?php echo $id;?>" >
                    <table class="table table-hover table-bordered" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity & Unit</th>
                                <th>Quote</th>
                                <th><button class="btn btn-sm btn-default" ><i data-feather="plus-circle" ></i></button></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer" ></div>
            </div>
        <?php
            }
        ?>
        
    </div>
</div>
<div class="modal-footer" >
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>    
</div>
<script>
$(document).ready(function(){
    $(".modal-dialog").addClass('modal-xl').addClass('modal-dialog-centered');
})
</script>
