<?php namespace Cactuar\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ConfTrait;

class SettingController extends Controller
{
    use BaseTrait, ConfTrait;
    
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
                'attributes' => ['class' => 'required cfind', 'cfind-type' => 'image'],
            ],
			'favicon' => [
				'label' => 'Fav Icon',
				'type' => 'text',
                'info' => 'ICO file only',
				'attributes' => ['class' => 'required cfind', 'cfind-type' => 'image', 'cfind-ext' => 'ico'],
			],
            'copyright' => [
                'label' => 'Copyright',
                'type' => 'text',
                'attributes' => ['class' => 'required'],
                'info' => 'available keywords:<br>[year] : current year<br>[webarq] : webarq copyright',
            ],
            /*'use-www' => [ //disabled as request, recommend redirect by htaccess / cpanel
                'label' => 'Domain',
                'type' => 'select',
                'options' => [0 => 'without www.*', 1 => 'with www.*'],
                'attributes' => [
                    'style' => 'max-width:200px',
                ]
            ],*/
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

    public function configAppend(){
        return view('cactuar::admin.component.gdpr');
    }
}