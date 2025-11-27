<?php

use Cactuar\Admin\Helpers\admin;

$arr = [
    'user' => [
        'label' => 'User',
        'fa' => 'user',
        'controller' => 'Cactuar\Admin\Http\Controllers\UserController',
        'routes' => admin::moduleRoutes(['index','create','edit','delete','email-template']),
    ],
    'privilege' => [
        'label' => 'Privilege',
        'fa' => 'key',
        'controller' => 'Cactuar\Admin\Http\Controllers\PrivilegeController',
        'routes' => admin::moduleRoutes(['index','create','edit','delete']),
    ],

    'logviewer' => [
        'label' => 'Log Viewer',
        'fa' => 'tags',
        'controller' => 'Cactuar\Admin\Http\Controllers\LogViewerController',
        'routes' => admin::moduleRoutes(['index','download','delete'],['view']),
    ]
];

if (config('cadmin.cadmin.logviewer') == false)
    unset($arr['logviewer']);

return $arr;
