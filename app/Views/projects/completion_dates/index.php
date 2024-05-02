<div class="card" >
    <div class="card-body" >
        <?php echo form_open(get_uri("projects/save_completion_dates"),array("id"=>"completion_dates_form","class" => "general-form", "role" => "form")); ?>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Contractual delivery date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" name="contractual_delivery_date" id="contractual_delivery_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Yard's estimated completion date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" name="contractual_delivery_date" id="contractual_delivery_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Own estimated completion date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" name="contractual_delivery_date" id="contractual_delivery_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Actual completion date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" name="contractual_delivery_date" id="contractual_delivery_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Contractual delivery date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" name="contractual_delivery_date" id="contractual_delivery_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <button class="btn btn-primary" style="float:right;" > <i data-feather="check-circle" class="icon-16" ></i> Save</button>
        </div>
        
        <?php echo form_close();?>
    </div>
</div>
<script>
    $(document).ready(function(){

    })
</script>