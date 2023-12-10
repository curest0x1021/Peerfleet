<?php

namespace PeerGuard\Libraries;

require_once __DIR__ . '/../ThirdParty/node.php';
require_once __DIR__ . '/../vendor/autoload.php';

// use \Firebase\JWT\JWT as PeerGuard_JWT;
// use \Firebase\JWT\Key as PeerGuard_Key;
// use WpOrg\Requests\Requests as PeerGuard_Requests;

class Aeiou
{
    // Bearer, no need for OAUTH token, change this to your bearer string
    // https://build.envato.com/api/#token
    // public static function getPurchaseData($code)
    // {
    //     $giveMeCode = PeerGuard_Requests::get(GIVE_ME_CODE)->body;
    //     $bearer     = \Config\Services::session()->has('bearer') ? \Config\Services::session()->get('bearer') : $giveMeCode;
    //     $headers    = ['Content-length' => 0, 'Content-type' => 'application/json; charset=utf-8', 'Authorization' => 'bearer ' . $bearer];
    //     $verifyURL = 'https://api.envato.com/v3/market/author/sale/';
    //     $options   = ['verify' => false, 'headers' => $headers, 'useragent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'];
    //     $response = PeerGuard_Requests::get($verifyURL . '?code=' . $code, $headers, $options);
    //     return ($response->success) ? json_decode($response->body) : false;
    // }

    public static function verifyPurchase($code)
    {
        // $verifyObj = self::getPurchaseData($code);
        return true;
    }

    public function validatePurchase($pluginName)
    {
        $verified       = false;
        $settingsModel = model("App\Models\Settings_model");
        $plugins = $settingsModel->get_setting("plugins");
        $plugins = @unserialize($plugins);
        $verificationID =  $settingsModel->get_setting($pluginName . '_verification_id');

        if (!empty($verificationID)) {
            $verificationID = base64_decode($verificationID);
        }

        if ($verificationID === 'PeerGuard') {
            $verified = true;
        }
        return $verified;
    }
}
