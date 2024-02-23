<!-- The Modal -->

<div class="modal-body">
<div class="card" >
    <h5>Selecting yard - <?php echo $shipyard_info->title;?></h5>
    <p><i data-feather="info" ></i> Learn more about selecting yards.</p>
</div>
<div class="card" >
    <p>By selecting this yard, the quoted costs for this project. Data from any other yards will be hidden. This action is not reversible, but you can always edit the costs in execution phase.</p>
    <div class="card" style="background-color:lightyellow;border:1px solid brown;" >
        <ul>
        <p>
            This action will move the project to the pre-Execution phase. This is the phase between yard selection and the actual yard visit(Execution)
        </p>
        <p>
            Please note that the Deviation cost loss of earnings, Bunker cost and other additional expenditures at yard are not transfered to the cost.
            In order to include these in the project's total cost, you should add these on the Owner's supply page.
        </p>
        </ul>
    </div>
</div>
</div>

<!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-info btn-confirm-select-yard" data-bs-dismiss="modal">Select</button>
</div>
<script>

</script>

