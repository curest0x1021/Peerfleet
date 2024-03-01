<!-- The Modal -->

<div class="modal-body">
    <h5>Selecting yard - <?php echo $shipyard_info->name;?></h5>
    <!-- <p><i data-feather="info" class="icon-16"></i> Learn more about selecting yards.</p> -->
<div class="card" >
    <div class="card-body" >
        <p>By selecting this yard, the quoted costs for this project. Data from any other yards will be deleted. This action is not reversible, but you can always edit the costs in execution phase.</p>
        <div style="border-radius:10px;background-color:lightyellow;border:1px solid brown;" >
            <ul>
            <p>
                This action will move the project to the only Execution Phase. This is the phase between yard selection and the actual yard visit(Execution)
            </p>
            <!-- <p>
                Please note that the Deviation, cost loss of earnings, Bunker cost and other additional expenditures at yard are not transfered to the cost.
                In order to include these in the project's total cost, you should add these on the Owner's supply page.
            </p> -->
            </ul>
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

