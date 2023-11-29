<?php
load_css(array(
    "assets/js/fullcalendar/fullcalendar.min.css"
));

load_js(array(
    "assets/js/fullcalendar/fullcalendar.min.js",
    "assets/js/fullcalendar/locales-all.min.js"
));

$client = "";
if (isset($client_id)) {
    $client = $client_id;
}
?>
<div class="row">
    <div class=" col-md-12">
        <div class="table-responsive">
            <table id="leave-summary-table" class="display" cellspacing="0" width="100%">
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div id="page-content<?php echo $client; ?>" class="page-wrapper<?php echo $client; ?> clearfix">
        <div class="card mb0 full-width-button">
            <div class="page-title clearfix">

                <div class="title-button-group custom-toolbar events-title-button">


                    <?php
                    if (get_setting("enable_google_calendar_api") && (get_setting("google_calendar_authorized") || get_setting('user_' . $login_user->id . '_google_calendar_authorized'))) {
                        echo modal_anchor(get_uri("events/google_calendar_settings_modal_form"), "<i data-feather='settings' class='icon-16'></i> " . app_lang('google_calendar_settings'), array("class" => "btn btn-default", "title" => app_lang('google_calendar_settings')));
                    }
                    ?>

                    <?php echo modal_anchor(get_uri("leaves/application_details"), "", array("class" => "hide", "data-post-id" => "", "id" => "show_leave_hidden")); ?>
                </div>
            </div>
            <div class="card-body">
                <div id="event-calendar"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#leave-summary-table").appTable({
            source: '<?php echo_uri("leaves/summary_list_data") ?>',
            filterDropdown: [{
                    name: "leave_type_id",
                    class: "w200",
                    options: <?php echo $leave_types_dropdown; ?>
                },
                {
                    name: "applicant_id",
                    class: "w200",
                    options: <?php echo $team_members_dropdown; ?>
                }
            ],
            dateRangeType: "yearly",
            columns: [{
                    title: '<?php echo app_lang("applicant") ?>',
                    "class": "w30p"
                },
                {
                    title: '<?php echo app_lang("total_leave_yearly") ?>'
                },
                {title: '<i data-feather="menu" class="icon-16"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2],
            xlsColumns: [0, 1, 2]
        });

        var client = "<?php echo $client; ?>";
        if (client) {
            setTimeout(function () {
                window.fullCalendar.today();
            });
        }

        //autoload the event popover
        var encrypted_event_id = "<?php echo isset($encrypted_event_id) ? $encrypted_event_id : ''; ?>";
        if (encrypted_event_id) {
            $("#show_event_hidden").attr("data-post-id", encrypted_event_id);
            $("#show_event_hidden").trigger("click");
        }

        $("#event-labels-dropdown").select2({
            data: []
        }).on("change", function () {
            eventLabel = $(this).val();
            loadCalendar();
        });

        $("#event-calendar .fc-header-toolbar .fc-button").click(function () {
            feather.replace();
        });
        loadCalendar();
    });

    var filterValues = "leave",
            eventLabel = "";

    var loadCalendar = function() {
        var filter_values = filterValues || "events",
            $eventCalendar = document.getElementById('event-calendar'),
            event_label = eventLabel || "0";

        appLoader.show();

        window.fullCalendar = new FullCalendar.Calendar($eventCalendar, {
            locale: AppLanugage.locale,
            height: $(window).height() - 210,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            events: "<?php echo_uri("events/calendar_events/"); ?>" + filter_values + "/" + event_label,
            dayMaxEvents: false,
            dateClick: function(date, jsEvent, view) {
                $("#add_event_hidden").attr("data-post-start_date", moment(date.date).format("YYYY-MM-DD"));
                var startTime = moment(date.date).format("HH:mm:ss");
                if (startTime === "00:00:00") {
                    startTime = "";
                }
                $("#add_event_hidden").attr("data-post-start_time", startTime);
                var endDate = moment(date.date).add(1, 'hours');

                $("#add_event_hidden").attr("data-post-end_date", endDate.format("YYYY-MM-DD"));
                var endTime = "";
                if (startTime != "") {
                    endTime = endDate.format("HH:mm:ss");
                }

                $("#add_event_hidden").attr("data-post-end_time", endTime);
                $("#add_event_hidden").trigger("click");
            },
            eventClick: function(calEvent) {
                calEvent = calEvent.event.extendedProps;
                if (calEvent.event_type === "leave") {
                    $("#show_leave_hidden").attr("data-post-id", calEvent.leave_id);
                    $("#show_leave_hidden").trigger("click");

                }
            },
            eventContent: function(element) {
                var icon = element.event.extendedProps.icon;
                var title = element.event.title;
                var status = element.event.extendedProps.status;
                if (icon) {
                    title = "<span class='clickable w100p inline-block' style='background-color: " + element.event.backgroundColor + "; color: #fff'><span><i data-feather='" + icon + "' class='icon-16'></i> " + title + "(" + status + ")" + "</span></span>";
                }

                return {
                    html: title
                };
            },
            loading: function(state) {
                if (state === false) {
                    appLoader.hide();
                    setTimeout(function() {
                        feather.replace();
                    }, 100);
                }
            },
            firstDay: AppHelper.settings.firstDayOfWeek
        });

        window.fullCalendar.render();
    };
</script>