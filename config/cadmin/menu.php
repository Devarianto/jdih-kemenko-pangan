<?php
if (env('APP_ENV') == 'fe')
	return;

use Cactuar\Admin\Helpers\admin;

/*
keterangan akan ditambahkan
*/

return [
    'setting' => [
        'label' => 'Setting',
        'parent' => null,
        'fa' => 'wrench',
    ],
    'site-setting' => [
        'label' => 'Website Setting',
        'parent' => 'setting',
        'controller' => 'App\Http\Controllers\Admin\SettingController',
        'fa' => 'globe',
        'default-action' => 'config',
        'routes' => admin::moduleRoutes(['config']),
    ],
    'offline-page'=>[
        'label'=>'Offline page',
        'parent'=>'setting',
        'controller'=>'App\Http\Controllers\Admin\Misc\OfflineController',
        'default-action'=>'config',
        'routes'=> admin::moduleRoutes(['config']),
    ],
    '404-page'=>[
        'label'=>'404 page',
        'parent'=>'setting',
        'controller'=>'App\Http\Controllers\Admin\Misc\Page404CenterController',
        'default-action'=>'config',
        'routes'=> admin::moduleRoutes(['config']),
    ],
    /*
    '404-aside'=>[
        'label'=>'404 page',
        'parent'=>'setting',
        'controller'=>'App\Http\Controllers\Admin\Misc\Page404AsideController',
        'default-action'=>'config',
        'routes'=> admin::moduleRoutes(['config']),
    ],*/
    
	
    
	'ai'=>[
		'label'=>'AI',
		'fa'=>'robot'
	],
	'openai-setting' => [
        'label'=>'AI Setting',
        'parent'=>'ai',
        'controller'=>'Cactuar\Admin\Http\Controllers\AI\Admin\SettingController',
        'default-action'=>'config',
        'routes'=> admin::moduleRoutes(['config']),
    ],
	'ai-billing-log'=>[
		'label'=>'AI Log',
		'parent'=>'ai',
		'controller'=>'Cactuar\Admin\Http\Controllers\AI\Admin\BillingLogAIController',
		'fa'=>'robot',
		'routes'=>admin::moduleRoutes(['index','download']),
	],
	'ai-credit'=>[
		'label'=>'AI Credit',
		'parent'=>'ai',
		'controller'=>'Cactuar\Admin\Http\Controllers\AI\Admin\CreditRequestController',
		'fa'=>'coin',
		'routes'=>['get'=>['index','request'],'post'=>['request']],
	],
    'account' => [
        'label' => 'User JDIH',
        'parent' => null,
        'controller' => 'App\Http\Controllers\Admin\AccountController',
        'fa' => 'user',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish', 'email-template'], ['new-password'],['new-password'])
    ],

    'project' => [
        'label' => 'Project',
        'fa' => 'pencil-square',
    ],

    'kategori-project' => [
        'label' => 'Kategori',
        'fa' => 'tags',
        'parent' => 'project',
        'controller' => 'App\Http\Controllers\Admin\CategoryProjectController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish']),
    ],

    'divisi-pemohon' => [
        'label' => 'Divisi Pemohon',
        'fa' => 'tags',
        'parent' => 'project',
        'controller' => 'App\Http\Controllers\Admin\ApplicantDivisionController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish']),
    ],

    'usulan-project' => [
        'label' => 'Usulan',
        'fa' => 'file',
        'parent' => 'project',
        'controller' => 'App\Http\Controllers\Admin\UsulanController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish','download']),
    ],

    'menu' => [
        'label' => 'Menu',
        'parent' => 'content',
        'fa' => 'file',
		'controller' => 'App\Http\Controllers\Admin\MenuController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish']),
    ],
    'information' => [
        'label' => 'Informasi',
        'parent' => null,
        'fa' => 'info'
    ],
    'information-gallery' => [
        'label' => 'Galeri',
        'parent' => 'information',
        'fa' => 'image',
        'controller' => 'App\Http\Controllers\Admin\GalleryController',
        'routes' => admin::moduleRoutes(['index', 'edit', 'delete', 'create', 'publish'])
    ],
    'information-news' => [
        'label' => 'Berita',
        'parent' => 'information',
        'fa' => 'image',
        'controller' => 'App\Http\Controllers\Admin\NewsController',
        'routes' => admin::moduleRoutes(['index', 'edit', 'delete', 'create', 'publish'])
    ],
	'contact' => [
        'label' => 'Hubungi Kami',
        'fa' => 'phone',
		'controller' => 'App\Http\Controllers\Admin\ContactController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish', 'email-template']),
    ],
    /* tambahkan module lain disini */
    
    'media' => [
        'label' => 'Media',
        'parent' => null,
        'fa' => 'image',
    ],
    'image' => [
        'label' => 'Image',
        'controller' => 'Cactuar\Admin\Http\Controllers\MediaImageController',
        'parent' => 'media',
        'fa'  => 'image',
        'routes' => admin::moduleRoutes(['index','create','delete']),
    ],
    'file' => [
        'label' => 'File',
        'controller' => 'Cactuar\Admin\Http\Controllers\MediaFileController',
        'parent' => 'media',
        'fa'  => 'file-pdf-o',
        'routes' => admin::moduleRoutes(['index','create','delete']),
    ],
    'log' => [
        'label' => 'Logs',
        'parent' => null,
        'fa' => 'terminal',
    ],
    'admin-log' => [
        'label' => 'Admin Log',
        'parent' => 'log',
        'controller' => 'Cactuar\Admin\Http\Controllers\LogController',
        'fa' => 'tags',
        'routes' => admin::moduleRoutes(['index','download']),
    ],

	/* ------- Additional Module ---------- *//*
    
    'translation' => [
        'label' => 'Translation',
        'parent' => 'setting',
        'fa' => 'language',
        'controller' => 'Cactuar\Admin\Http\Controllers\TranslationController',
        'routes' => ['get' => ['index','edit'], 'post' => ['edit']],
    ],
    'email-log' => [
        'label' => 'Email Log',
        'parent' => 'log',
        'fa' => 'send-o',
        'controller' => 'Cactuar\Admin\Http\Controllers\EmailLogController',
        'routes' => admin::moduleRoutes(['index','download']),
    ]
    */
];