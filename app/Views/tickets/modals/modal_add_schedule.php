<?php echo form_open(get_uri("tickets/save_schedule"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

    <div id="link-of-new-view" class="hide">
        <?php
        echo modal_anchor(get_uri("tasks/view"), "", array("data-modal-lg" => "1"));
        ?>
    </div>
    <input hidden class='input-id' value="<?php if (isset($action_info))
        echo $action_info->id; ?>" />
    <div class="form-group">
        <label for="schedule_port">Port : </label>
        <!-- <input 
        name="schedule_port"
        id="schedule_port"
        class="form-control schedule_port"
        placeholder="Start typing to get suggestions"
        value="<?php //if(isset($action_info)) echo $action_info->schedule_port; ?>"
        /> -->
        <?php
        echo form_dropdown("schedule_port", $ports_dropdown, $action_info->schedule_port, "class='select2' id='schedule_port'");
        ?>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="schedule_eta">ETA : </label>
                <?php
                echo form_input(
                    array(
                        "id" => "schedule_eta",
                        "name" => "schedule_eta",
                        "autocomplete" => "off",
                        "value" => is_date_exists($action_info->schedule_eta) ? date("Y-m-d", strtotime($action_info->schedule_eta)) : "",
                        "class" => "form-control input-eta",
                        "placeholder" => "YYYY-MM-DD"
                    )
                );
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="schedule_etd">ETD : </label>
                <?php
                echo form_input(
                    array(
                        "id" => "schedule_etd",
                        "name" => "schedule_etd",
                        "autocomplete" => "off",
                        "value" => is_date_exists($action_info->schedule_eta) ? date("Y-m-d", strtotime($action_info->schedule_etd)) : "",
                        "class" => "form-control input-etd",
                        "placeholder" => "YYYY-MM-DD"
                    )
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="schedule_agent">Agent : </label>
            <input name="schedule_agent" id="schedule_agent" class="form-control input-agent" value="<?php if (isset($action_info))
                echo $action_info->schedule_agent; ?>" />
        </div>
        <div class="form-group">
            <label for="schedule_remarks">Remarks : </label>
            <textarea name="schedule_remarks" id="schedule_remarks" class="form-control input-remarks"
                style="height:20vh;"><?php if (isset($action_info))
                    echo $action_info->schedule_remarks; ?></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-default btn-cancel-schedule"><i data-feather="x" class="icon-16"></i>Close</button>
        <button class="btn btn-primary btn-save-schedule"><i data-feather="check" class="icon-16"></i>Save</button>
    </div>
    <?php echo form_close(); ?>
    <script>
        $(document).ready(function () {
            var portsDropdown = <?php echo json_encode($ports_dropdown); ?>;
            setDatePicker("#schedule_eta");
            setDatePicker("#schedule_etd");
            $(".btn-cancel-schedule").on("click", function () {
                var $newViewLink = $("#link-of-new-view").find("a");
                $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_corrective_action/" . $action_info->id); ?>");
                // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
                $newViewLink.attr("data-post-id", <?php echo $ticket_id; ?>);
                $newViewLink.trigger("click");
            })
            $(".btn-save-schedule").on("click", function (e) {
                e.preventDefault()
                var rise_csrf_token = $('[name="rise_csrf_token"]').val();
                const id = "<?php echo $action_info->id; ?>";

                const port = $("#schedule_port")[0].value;
                const eta = $(".input-eta")[0].value;
                const etd = $(".input-etd")[0].value;
                const agent = $(".input-agent")[0].value;
                const remarks = $(".input-remarks")[0].value;
                var myForm = new FormData();
                myForm.append("rise_csrf_token", rise_csrf_token);
                myForm.append("id", id);
                myForm.append("port", portsDropdown[port]);
                myForm.append("eta", eta);
                myForm.append("etd", etd);
                myForm.append("agent", agent);
                myForm.append("remarks", remarks);
                $.ajax({
                    url: "<?php echo get_uri("tickets/save_schedule"); ?>",
                    type: "POST",
                    data: myForm,
                    processData: false, // Prevent jQuery from automatically processing the data
                    contentType: false,
                    success: function (response) {
                        if (JSON.parse(response).success) {
                            var $newViewLink = $("#link-of-new-view").find("a");
                            $newViewLink.attr("data-action-url", "<?php echo get_uri("tickets/modal_corrective_action/" . $action_info->id); ?>");
                            // $taskViewLink.attr("data-title", taskShowText + " #" + JSON.parse(response).saved_id);
                            $newViewLink.attr("data-post-id", <?php echo $ticket_id; ?>);
                            $newViewLink.trigger("click");
                        }
                    }
                })
            })
            // $(".schedule_port").select2({
            //     data: <?php //echo (json_encode($ports_dropdown)); ?>
            // })
            $("#schedule_port").select2();
        })
    </script>