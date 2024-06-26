<div class="card" >
    <!-- <div class="card-header" >

    </div> -->
    <div class="card-body" >
        <?php //if ($login_user->user_type === "staff") { ?>
            <div class="box-title"><span ><?php echo app_lang("activity"); ?></span></div>
            <div class="pl15 pr15 mt15 list-container project-activity-logs-container">
                <?php echo activity_logs_widget(array("limit" => 20, "offset" => 0, "log_type" => array("ticket", "ticket_action"), "log_for_id" => $ticket_id)); ?>
            </div>
        <?php //} ?>
    </div>
</div>

