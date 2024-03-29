<!-- The Modal -->

<div class="modal-body">
    <h5>Selecting candidate - <?php echo $shipyard_info->name;?></h5>
    <!-- <p><i data-feather="info" class="icon-16"></i> Learn more about selecting yards.</p> -->
<div class="card" >
    <div class="card-body" >
        <p>By selecting this yard, the quoted costs for this project. Data from any other yards will be deleted. This action is not reversible, but you can always edit the costs in execution phase.</p>
        <div  class="card bg-warning"  >
            <div class="card-body" >
                <h5><i data-feather="alert-triangle" class="icon-16" ></i>Warning</h5>
            <!-- <p>
                This action will move the project to the only Execution Phase. The status of your project will automatically change to the Execution phase.
            </p> -->
            <p>
                This action moves your project to the execution phase and will change the status of your project.
                <br/>
                <br/>
                Please note that the deviation cost, loss of earnings, bunker cost and other additional expenses in the yard are not transferred to the cost overview. In order to include these in the project's total cost overview, you should add these as Owner's supply to a designated task.
            </p>
            </div>
        </div>
    </div>
    
</div>
</div>

<!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary btn-confirm-select-yard" data-bs-dismiss="modal">Select</button>
</div>
<script>
$(document).ready(function(){
    $(".modal-dialog").removeClass('modal-xl');
    $(".btn-confirm-select-yard").on('click',function(){
        $.ajax({
            url:'<?php echo get_uri('projects/select_yard/'.$project_yard_info->id);?>',
            method:"GET",
            success:function(response){
                console.log(response)
                if(JSON.parse(response).success)
                    window.location.reload();
            }
        });
    });
})
</script>

