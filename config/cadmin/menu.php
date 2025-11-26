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
    'translation' => [
        'label' => 'Translation',
        'parent' => 'setting',
        'fa' => 'fas fa-language',
        'controller' => 'Cactuar\Admin\Http\Controllers\TranslationController',
        'routes' => ['get' => ['index', 'edit'], 'post' => ['edit']],
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
        'controller' => 'App\Http\Controllers\Admin\Project\CategoryProjectController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish']),
    ],

    'divisi-pemohon' => [
        'label' => 'Divisi Pemohon',
        'fa' => 'tags',
        'parent' => 'project',
        'controller' => 'App\Http\Controllers\Admin\Project\ApplicantDivisionController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish']),
    ],

    'status-project' => [
        'label' => 'Status Project',
        'fa' => 'tags',
        'parent' => 'project',
        'controller' => 'App\Http\Controllers\Admin\Project\StatusProjectController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish']),
    ],

    'usulan-project' => [
        'label' => 'Usulan',
        'fa' => 'file',
        'parent' => 'project',
        'controller' => 'App\Http\Controllers\Admin\Project\UsulanProjectController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish','download'], ['detail'], ['approve','reject','update-status']),
    ],

    'menu' => [
        'label' => 'Menu',
        'fa' => 'file',
		'controller' => 'App\Http\Controllers\Admin\MenuController',
        'routes' => admin::moduleRoutes(['index','edit','delete','create','publish']),
    ],
    'master-document' => [
        'label' => 'Master Dokumen',
        'parent' => null,
        'fa' => 'list'
    ],
    'master-document-list' => [
        'label' => 'Dokumen',
        'parent' => 'master-document',
        'fa' => 'list',
        'controller' => 'App\Http\Controllers\Admin\Document\MasterDocumentController',
        'routes' => admin::moduleRoutes(['index', 'edit', 'publish'])
    ],
    'master-document-rule-theme' => [
        'label' => 'Tema Peraturan',
        'parent' => 'master-document',
        'fa' => 'list',
        'controller' => 'App\Http\Controllers\Admin\Document\RuleThemeController',
        'routes' => admin::moduleRoutes(['index', 'edit', 'publish'])
    ],
    'master-document-rule-type' => [
        'label' => 'Jenis Peraturan',
        'parent' => 'master-document',
        'fa' => 'list',
        'controller' => 'App\Http\Controllers\Admin\Document\RuleTypeController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'master-document-type' => [
        'label' => 'Tipe Dokumen',
        'parent' => 'master-document',
        'fa' => 'list',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentTypeController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'document' => [
        'label' => 'Dokumen Hukum',
        'parent' => null,
        'fa' => 'file',
    ],
    'document-peraturan' => [
        'label' => 'Peraturan Hukum',
        'parent' => 'document',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentPeraturanController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'document-jurnal' => [
        'label' => 'Jurnal Hukum',
        'parent' => 'document',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'document-kliping' => [
        'label' => 'Kliping Hukum',
        'parent' => 'document',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'document-majalah' => [
        'label' => 'Majalah Hukum',
        'parent' => 'document',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'document-putusan' => [
        'label' => 'Putusan Hukum',
        'parent' => 'document',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'document-monografi' => [
        'label' => 'Monografi Hukum',
        'parent' => 'document',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
    ],
    'document-naskah' => [
        'label' => 'Naskah Kerja Sama',
        'parent' => 'document',
        'controller' => 'App\Http\Controllers\Admin\Document\DocumentController',
        'routes' => admin::moduleRoutes(['index', 'create', 'edit', 'delete', 'publish'])
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
    'information-infografis' => [
        'label' => 'Infografis',
        'parent' => 'information',
        'fa' => 'image',
        'controller' => 'App\Http\Controllers\Admin\InfografisController',
        'routes' => admin::moduleRoutes(['index', 'edit', 'delete', 'create', 'publish'])
    ],
    'information-kamus-hukum' => [
        'label' => 'Kamus Hukum',
        'parent' => 'information',
        'fa' => 'image',
        'controller' => 'App\Http\Controllers\Admin\KamusHukumController',
        'routes' => admin::moduleRoutes(['index', 'edit', 'delete', 'create', 'publish'])
    ],
    'rating' => [
        'label' => 'Rating',
        'fa' => 'star',
		'controller' => 'App\Http\Controllers\Admin\RatingController',
        'routes' => admin::moduleRoutes(['index','create','edit','delete','publish','download', 'email-template']),
    ],
	'contact' => [
        'label' => 'Hubungi Kami',
        'fa' => 'phone',
		'controller' => 'App\Http\Controllers\Admin\ContactController',
        'routes' => admin::moduleRoutes(['index','edit','delete','publish','download', 'email-template']),
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