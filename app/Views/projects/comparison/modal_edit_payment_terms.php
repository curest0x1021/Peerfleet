<div class="modal-body">
    <h3>Edit payment terms of <?php echo $shipyard_info->title;?></h3>
    <div class="form-group" >
        <label>Payment before departure</label>
        <input type="number" class="form-control payment_before_departure" />
    </div>
    <div class="form-group" >
        <label>Payment within 30 days</label>
        <input type="number" class="form-control payment_within_30" />
    </div>
    <div class="form-group" >
        <label>Payment within 60 days</label>
        <input type="number" class="form-control payment_within_60" />
    </div>
    <div class="form-group" >
        <label>Payment within 90 days</label>
        <input type="number" class="form-control payment_within_90" />
    </div>
</div>

    <!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary save_payment_terms" >Save</button>
</div>
<script>
    $(document).ready(function(){

    })
</script>]