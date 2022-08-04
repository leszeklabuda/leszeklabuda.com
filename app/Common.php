<?php

use Config\Services;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */

function rn($line)
{
    return $line . "\r\n";
}

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function validateRecaptcha($recaptchaResponse)
{
    // Captcha on 192.168.1.4
    $environment = env('CI_ENVIRONMENT');
    $appBaseURL = env('app.baseURL');   // https://127.0.0.1/ | https://leszeklabuda.com/
    if ($environment === 'development' && preg_match('/127.0.0.1/', $appBaseURL)) {
        $request = Services::request();
        $httpHost = $request->getServer('HTTP_HOST');    // 127.0.0.1 | 192.168.1.4
        if(preg_match('/192.168.1.4/', $httpHost)) {
            return [
                'success' => true
            ];
        }
    }

    $credential = array(
        'secret' => env('RECAPTCHAV2_SECRET'),
        'response' => $recaptchaResponse
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $default = [
        'success' => false,
        'error-codes' => [
            'no-response'
        ]
    ];
    $status = !$response ? $default : json_decode($response, true);

    return $status;
}
