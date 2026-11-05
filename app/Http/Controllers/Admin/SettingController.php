<?php namespace App\Http\Controllers\Admin;

use Cactuar\Admin\Http\Controllers\SettingController as BaseController;

class SettingController extends BaseController
{
    public function configFields()
    {
        $fields = [
            'status' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => ['online' => 'online', 'offline' => 'offline'],
            ],
            'logo' => [
                'label' => 'Logo',
                'type' => 'text',
                'info' => 'Use svg only, Recomended size width : 308px x height : 58px',
                'attributes' => [
                    'class' => 'required cfind', 
                    'cfind-type' => 'image', 
                    'cfind-ext' => 'svg',
                    'cfind-alt' => 1,
                ],
            ],
            'logo-floating' => [
                'label' => 'Logo Floating',
                'type' => 'text',
                'info' => 'Use svg only, Recomended size width : 308px x height : 58px',
                'attributes' => [
                    'class' => 'required cfind', 
                    'cfind-type' => 'image', 
                    'cfind-ext' => 'svg',
                    'cfind-alt' => 1,
                ],
            ],
			'favicon' => [
				'label' => 'Fav Icon',
				'type' => 'text',
                'info' => 'ICO file only, Recomended size width : 32px x height : 32px',
				'attributes' => ['class' => 'required cfind', 'cfind-type' => 'image', 'cfind-ext' => 'ico'],
			],
            'copyright' => [
                'label' => 'Copyright',
                'type' => 'text',
                'attributes' => ['class' => 'required'],
                'info' => 'available keywords:<br>[year] : current year<br>[webarq] : webarq copyright',
            ],
            'eregulasi-url' => [
                'subtitle' => 'Integrasi Sistem e-Regulasi',
                'label' => 'URL Sistem e-Regulasi',
                'type' => 'text',
                'info' => 'Alamat sistem e-Regulasi Kemenko Pangan untuk submenu Pengajuan PUU (Default: https://regulasikemenkopangan.id/login)',
                'attributes' => [
                    'placeholder' => 'https://regulasikemenkopangan.id/login'
                ]
            ],
            /*'use-www' => [ //disabled as request, recommend redirect by htaccess / cpanel
                'label' => 'Domain',
                'type' => 'select',
                'options' => [0 => 'without www.*', 1 => 'with www.*'],
                'attributes' => [
                    'style' => 'max-width:200px',
                ]
            ],*/
            'login-image' => [
                'subtitle' => 'Login Image',
                'label' => 'Image Large',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '337x539',
                    'cfind-convert' => 'webp',
                    'cfind-alt' => 1,
                ]
            ],
            'login-image-medium' => [
                'label' => 'Image Medium',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '240x483',
                    'cfind-convert' => 'webp'
                ]
            ],
            'login-image-small' => [
                'label' => 'Image Small',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '327x160',
                    'cfind-convert' => 'webp'
                ]
            ],
            'footer' => [
                'type' => 'widget',
                'subtitle' => 'Footer',
                'max' => 1,
                'min' => 1,
                'more-label' => 'Add Footer',
                'widgets' => [
                    'logo' => [
                        'type' => 'text',
                        'label' => 'Logo',
                        'info' => 'Use svg only, Recomended size width : 308px x height : 58px',
                        'attributes' => [
                            'class' => 'required cfind', 
                            'cfind-type' => 'image',
                            'cfind-ext' => 'svg',
                            'cfind-alt' => 1
                        ],
                    ],
                    'title' => [
                        'type' => 'text',
                        'label' => 'Title',
                        'multilang' => true,
                        'attributes' => ['class' => 'required'],
                    ],
                    'address' => [
                        'type' => 'textarea',
                        'label' => 'Address',
                        'attributes' => ['class' => 'required'],
                    ],
                    'phone' => [
                        'type' => 'text',
                        'label' => 'Phone',
                        'attributes' => ['class' => 'required'],
                    ]
                ]
            ],
            'socmed' => [
                'type' => 'widget',
                'subtitle' => 'Social Media',
                'more-label' => 'Add social media',
                'max' => 4,
                'widgets' => [
                    'icon' => [
                        'type' => 'text',
                        'label' => 'Icon',
                        'info' => 'Use SVG only. Recomended size width : 32px x height : 32px',
                        'attributes' => [
                            'class' => 'required cfind',
                            'cfind-type' => 'image',
                            'cfind-ext' => 'svg',
                            'cfind-alt' => 1,
                        ],
                    ],
                    'link' => [
                        'type' => 'text',
                        'label' => 'Link',
                        'info' => 'use http/https',
                        'attributes' => [
                            'class' => 'required',
                        ],
                    ],
                ],
            ],
            'meta-title' => [
                'label' => 'Meta Title',
                'subtitle' => 'Default Meta Data',
                'type' => 'text',
                'multilang' => true,
                'attributes' => ['class' => 'required', 'maxlength' => 255],
                'info' => 'maximum 255 character',
            ],
            'meta-keywords' => [
                'label' => 'Meta Keywords',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => ['rows' => 3],
            ],
            'meta-description' => [
                'label' => 'Meta Description',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => ['class' => 'required', 'rows' => 3, ],
                
            ],
            'meta-image' => [
                'label' => 'Meta Image',
                'type' => 'text',
                'attributes' => ['class' => 'cfind', 'cfind-type' => 'image'],
            ],
            'gdpr' => [
                'label' => 'GDPR & Cookie Setting',
                'type' => 'select',
                'options' => ['on' => 'On', 'off' => 'Off'],
            ],
            'embed-scripts' => [
                'type' => 'widget',
                'subtitle' => 'Embed Script',
                'widgets' => [
                    'position' => [
                        'label' => 'Position',
                        'type' => 'select',
                        'options' => [
                            'head' => 'Head',
                            'body' => 'Body',
                            'foot' => 'Foot'
                        ],
                    ],
                    'category' => [
                        'label' => 'Category Cookies (GDPR)',
                        'type' => 'select',
                        'info' => 'Category will be used if gdpr is active',
                        'options' => config('cadmin.gdpr.category'),
                    ],
                    'script' => [
                        'type' => 'textarea',
                        'label' => 'Script'
                    ],
                ]
            ],
        ];

        if(config('cadmin.gdpr.enabled') == false){
            unset($fields['gdpr']);
            unset($fields['embed-scripts']['widget']['category']);
        }

        return $fields;
    }
}