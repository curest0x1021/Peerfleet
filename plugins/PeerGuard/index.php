<?php

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
  Plugin Name: PeerGuard
  Description: The powerful security toolset plugin
  Version: 1.0.0
  Requires at least: 3.5.2
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Libraries/Apiinit.php';

use WpOrg\Requests\Requests as PeerGuard_Requests;
use PeerGuard\Libraries\Apiinit;

Apiinit::the_da_vinci_code('PeerGuard');
Apiinit::ease_of_mind('PeerGuard');

app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {
    return $sidebar_menu;
});

//add admin setting menu item
app_hooks()->add_filter('app_filter_admin_settings_menu', function ($settings_menu) {
    $settings_menu["plugins"][] = array("name" => "PeerGuard", "url" => "peerguard/peerguard_log");
    return $settings_menu;
});

register_installation_hook("PeerGuard", function ($item_purchase_code) {
    include PLUGINPATH . "PeerGuard/install/do_install.php";
});

register_uninstallation_hook('PeerGuard', function () {
    $dbprefix = get_db_prefix();
    $db = db_connect('default');

    $sql_query = "DELETE FROM `" . $dbprefix . "settings` WHERE `" . $dbprefix . "settings`.`setting_name` IN ('PeerGuard_verification_id', 'PeerGuard_last_verification', 'PeerGuard_product_token', 'PeerGuard_heartbeat');";
    $db->query($sql_query);
});

app_hooks()->add_action('app_hook_layout_main_view_extension', function () {
    echo '
        <script src="' . base_url(PLUGIN_URL_PATH . 'PeerGuard/assets/js/peerguard.js?v=' . get_setting('app_version')) . '"></script>
    ';
});

app_hooks()->add_action('app_hook_before_signout', function () {
    $request = request();
    $userAgent = $request->getUserAgent();
    $session = \Config\Services::session();

    // Set the user ID based on whether the user is a client or staff member
    $id = $session->get('user_id');

    // Get the user's device details (IP address, platform, and browser)
    $deviceDetails = [
        'ip_address' => getClientIp(),
        'platform'   => $userAgent->getPlatform(),
        'browser'    => $userAgent->getBrowser()
    ];

    // Set the data to update in the database (device details and is_logged_in status)
    $updateData = [
        'device_details' => serialize($deviceDetails),
        'is_logged_in'   => '0'
    ];

    // Update the user's data in the database
    $db = db_connect('default');
    $db->table('users')->where(['id' => $id])->update($updateData);
});

// hook for logout track => app_hook_before_signout
app_hooks()->add_action('app_hook_signin_extension', function () {
    echo '<div class="mt15"><a href="' . site_url('PeerGuard/reset_session') . '" title="">' . app_lang('reset_session') . '</a></div>';
});

app_hooks()->add_action("app_hook_after_cron_run", function () {
    // Get an array of expired staff members.
    $expiredStaff = getExpiredStaff();

    // If there are expired staff members, mark them as inactive in the database.
    if (!empty($expiredStaff)) {
        $expiredStaffIds = array_column($expiredStaff, 'id');
        $db = db_connect('default');
        $user_builder = $db->table("users");
        $staffDetails = $user_builder->whereIn('id', $expiredStaffIds)->update(['disable_login' => '1']);
    }
});

app_hooks()->add_filter("app_filter_email_templates", function ($templates_array) {
    $templates_array["PeerGuard"] = array(
        "unrecognized_login_detected_staff" => array("USER_FIRST_NAME", "USER_LAST_NAME", "USER_LOGIN_EMAIL", "RECIPIENTS_EMAIL_ADDRESS", "ISP", "IP_ADDRESS", "COUNTRY"),
        "multiple_failed_login_attempts" => array("USER_FIRST_NAME", "USER_LAST_NAME", "USER_LOGIN_EMAIL", "RECIPIENTS_EMAIL_ADDRESS", "ISP", "IP_ADDRESS", "COUNTRY"),
        "unrecognized_login_detected_to_admin" => array("USER_FIRST_NAME", "USER_LAST_NAME", "USER_LOGIN_EMAIL", "RECIPIENTS_EMAIL_ADDRESS", "ISP", "IP_ADDRESS", "COUNTRY"),
    );
    return $templates_array;
});

app_hooks()->add_action('app_hook_before_app_access', 'PeerGuard_actLib');
function PeerGuard_actLib()
{
    $aeiou = new \PeerGuard\Libraries\Aeiou();
    $envato_res = $aeiou->validatePurchase('PeerGuard');
}
