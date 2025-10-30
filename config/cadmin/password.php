<?php

return [
    'login-captcha' => env('CADMIN_LOGIN_CAPTCHA', false),
    'captcha-version' => env('CADMIN_CAPTCHA_VERSION', 'v2'),
    'weak-password' => true,
    'password-expiry' => 0,
    'password-expiry-notify' => 0,
    'unique-password-history' => 0,
];