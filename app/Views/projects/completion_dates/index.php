<div class="card" >
    <div class="card-body" >
        <?php echo form_open(get_uri("projects/save_completion_dates"),array("id"=>"completion_dates_form","class" => "general-form", "role" => "form")); ?>
        <input hidden name="project_id" value="<?php echo $project_info->id;?>" />
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Contractual delivery date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control"value="<?php echo isset($project_info)?($project_info->contractual_delivery_date?date('d.m.Y', strtotime($project_info->contractual_delivery_date)):""):"";?>"  name="contractual_delivery_date" id="contractual_delivery_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Yard's estimated completion date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" value="<?php echo isset($project_info)?($project_info->yard_estimated_completion_date?date('d.m.Y', strtotime($project_info->yard_estimated_completion_date)):""):"";?>" name="yard_estimated_completion_date" id="yard_estimated_completion_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Own estimated completion date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" value="<?php echo isset($project_info)?($project_info->deadline?date('d.m.Y', strtotime($project_info->deadline)):""):"";?>" name="own_estimated_completion_date" id="own_estimated_completion_date" />
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-2" >
                    <label>Actual completion date : </label>
                </div>
                <div class="col-md-3" >
                    <input class="form-control" value="<?php echo isset($project_info)?($project_info->actual_completion_date?date('d.m.Y', strtotime($project_info->actual_completion_date)):""):"";?>" name="actual_completion_date" id="actual_completion_date" />
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
        setDatePicker("#contractual_delivery_date");
        setDatePicker("#yard_estimated_completion_date");
        setDatePicker("#own_estimated_completion_date");
        setDatePicker("#actual_completion_date");

        window.project_completion_dates_form=$("#completion_dates_form").appForm({
            // isModal: false,
            closeModalOnSuccess: true,
            onSuccess:function(response){
                appAlert.success("Saved successfully!", {duration: 4000});
            }
        })
    })
</script>