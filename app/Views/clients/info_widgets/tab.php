<?php
$card = "";
$icon = "";
$value = "";
$link = "";

$view_type = "client_dashboard";
if ($login_user->user_type == "staff") {
    $view_type = "";
}

if (!is_object($client_info)) {
    $client_info = new stdClass();
    $client_info->id = 0;
    $client_info->total_projects = 0;
    $client_info->total_tickets = 0;
    $client_info->notes = 0;
}


if ($tab == "total_projects") {
    $card = "bg-info";
    $icon = "grid";
    if (property_exists($client_info, "total_projects")) {
        $value = to_decimal_format($client_info->total_projects);
    }
    if ($view_type == "client_dashboard") {
        $link = get_uri('projects/index');
    } else {
        $link = get_uri('clients/view/' . $client_info->id . '/projects');
    }
} else if ($tab == "open_tickets") {
    $card = "bg-primary";
    $icon = "file-text";
    if (property_exists($client_info, "open_tickets")) {
        $value = to_decimal_format($client_info->open_tickets);
    }
    if ($view_type == "client_dashboard") {
        $link = get_uri('tickets/index');
    } else {
        $link = get_uri('clients/view/' . $client_info->id . '/tickets');
    }
} else if ($tab == "total_vessels") {
    $card = "bg-success";
    $icon = "check-square";
    if (property_exists($client_info, "total_vessels")) {
        $value = to_decimal_format($client_info->total_vessels);
    }
    $link = get_uri('clients/index');
} else if ($tab == "last_announcement") {
    // $card = "bg-coral";
    // $icon = "compass";
    if (property_exists($client_info, "last_announcement") && !empty($client_info->last_announcement)) {
        $value = $client_info->last_announcement->title;
        $link = get_uri('announcements/view/' . $client_info->last_announcement->id);
    } else {
        $value = app_lang("no_announcement_yet");
        $link = get_uri('announcements/index');
    }
}
?>

<a href="<?php echo $link; ?>" class="white-link">
    <div class="card dashboard-icon-widget">
        <?php if ($tab == 'last_announcement') { ?>
            <div class="card-body dark">
                <i data-feather="mic" class="icon" stroke-width="2.5"></i><span class="ml10"><?php echo app_lang("last_announcement"); ?></span>
                <div class="mt15 ms-1 text-truncate" title="<?php echo $value; ?>">
                    <?php echo $value; ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="card-body">
                <div class="widget-icon <?php echo $card ?>">
                    <i data-feather="<?php echo $icon; ?>" class="icon"></i>
                </div>
                <div class="widget-details">
                    <h1><?php echo $value; ?></h1>
                    <span class="bg-transparent-white"><?php echo app_lang($tab); ?></span>
                </div>
            </div>
        <?php } ?>
    </div>
</a>