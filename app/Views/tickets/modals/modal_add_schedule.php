<div class="modal-body clearfix" >
    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <div class="form-group" >
        <label for="schedule_port" >Port : </label>
        <input 
        name="schedule_port"
        id="schedule_port"
        class="form-control"
        placeholder="Start typing to get suggestions"
        />
    </div>
    <div class="row" >
        <div class="col-md-6" >
            <div class="form-group" >
                <label for="schedule_eta" >ETA : </label>
                <input 
                name="schedule_eta"
                id="schedule_eta"
                class="form-control"
                />
            </div>
        </div>
        <div class="col-md-6" >
            <div class="form-group" >
                <label for="schedule_etd" >ETD : </label>
                <input 
                name="schedule_etd"
                id="schedule_etd"
                class="form-control"
                />
            </div>
        </div>
    </div>
    <div class="form-group" >
        <label for="schedule_agent" >Agent : </label>
        <input 
        name="schedule_agent"
        id="schedule_agent"
        class="form-control"
        />
    </div>
    <div class="form-group" >
        <label for="schedule_remarks" >Remarks : </label>
        <textarea
        name="schedule_remarks"
        id="schedule_remarks"
        class="form-control"
        style="height:20vh;"
        ></textarea>
    </div>
</div>
<div class="modal-footer" >
    <button class="btn btn-default btn-cancel-schedule "  ><i data-feather="x" class="icon-16" ></i>Close</button>
    <button class="btn btn-primary btn-save-schedule"  ><i data-feather="check-circle" class="icon-16" ></i>Save</button>
</div>
<script>
    $(document).ready(function(){
        setDatePicker("#schedule_eta");
        setDatePicker("#schedule_etd");
        $(".btn-cancel-schedule").on("click",function(){
            var $newViewLink = $("#link-of-new-view").find("a");
            $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_add_corrective_action/".$ticket_id); ?>");
            // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
            $newViewLink.attr("data-post-id", <?php echo $ticket_id;?>);
            $newViewLink.trigger("click");
        })
    })
</script>