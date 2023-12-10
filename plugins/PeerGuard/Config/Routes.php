<?php

namespace Config;

$routes = Services::routes();

$PeerGuardNamespace = ['namespace' => 'PeerGuard\Controllers'];

$routes->match(['get'], 'peerguard', 'PeerGuardController::settings', $PeerGuardNamespace);
$routes->match(['get', 'post'], 'peerguard/settings', 'PeerGuardController::settings', $PeerGuardNamespace);
$routes->match(['get', 'post'], 'peerguard/addloginexpiry', 'PeerGuardController::addLoginExpiry', $PeerGuardNamespace);
$routes->match(['get', 'post'], 'peerguard/add_ip_email', 'PeerGuardController::addIpOrEmailToBlacklist', $PeerGuardNamespace);
$routes->match(['get', 'post'], 'peerguard/peerguard_log', 'PeerGuardController::PeerGuardLog', $PeerGuardNamespace);
$routes->match(['get', 'post'], 'peerguard/remove_staff_expiry/(:any)', 'PeerGuardController::removeStaffExpiry/$1', $PeerGuardNamespace);

$routes->match(['get', 'post'], 'peerguard/remove_ip_email/(:any)/(:any)', 'PeerGuardController::removeIpOrEmailFromBlacklist/$1/$2', $PeerGuardNamespace);

$routes->post('peerguard/peerguardlog_table', 'PeerGuardController::PeerGuardLogTable', $PeerGuardNamespace);
$routes->post('peerguard/user_expiry_table', 'PeerGuardController::staffExpiryTable', $PeerGuardNamespace);
$routes->post('peerguard/blacklistip_table/(:any)', 'PeerGuardController::blackListIpTable/$1', $PeerGuardNamespace);

$routes->match(['get', 'post'], 'peerguard/reset_session', 'PeerGuardAuthController::resetSession', $PeerGuardNamespace);

$routes->match(['get', 'post'], 'peerguard/peerguard_clear_log', 'PeerGuardController::PeerGuardClearLog', $PeerGuardNamespace);
