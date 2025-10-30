<?php

return [
    'enabled' => true,
    'lifetime' => env('GDPR_LIFETIME', null),
    'category' => [
        'always-on' => '',
        'essential' => 'Essential / Strictly Necessary Cookies',
        'functional' => 'Functional Cookies',
        'analytic' => 'Analytics Cookies',
        'marketing' => 'Advertising or Marketing Cookies'
    ],
];