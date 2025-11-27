<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

use App\Models\KamusHukum;

use media;

class KamusHukumController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    public function listingRes()
    {
        return KamusHukum::translate();
    }
    
    public function listingFields()
    {
        return [
            'title' => 'Title',
            'view_count' => 'View Count'
        ];
    }

    public function listingSearchs()
    {
        return ['title'];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        // if($key == 'date') {
        //     return date2string($value);
        // }
        // if($key == 'thumbnail') {
        //     return '<img src="'.media::url($value).'" alt="" width="100">';
        // }
        return e($value) ?? '-';
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('title','asc');
    }

    public function formRes()
    {
        return new KamusHukum;
    }

    public function formFields()
    {
        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required title',
                    'maxlength' => 150
                ],
                'ai' => ['translate', 'meta-title','correction'],
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'intro' => [
                'label' => 'Intro',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required',
                    'maxlength' => 255
                ],
                'ai' => ['translate', 'correction'],
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required ckeditor'
                ],
                'ai' => ['translate','correction'],
            ],
            'reference' => [
                'subtitle' => 'Reference',
                'type' => 'widget',
                'widgets' => [
                    'title' => [
                        'type' => 'text',
                        'label' => 'Title',
                        'multilang' => true,
                        'attributes' => [
                            'class' => 'required'
                        ] 
                    ],
                    'target' => [
                        'type' => 'select',
                        'label' => 'Target',
                        'options' => [
                            '_self' => 'Default',
                            '_blank' => 'New Tab',
                        ],
                    ],
                    'link' => [
                        'type' => 'text',
                        'label' => 'Link',
                        'multilang' => true,
                        'info' => 'eg: https://google.com',
                        'attributes' => [
                            'class' => 'required url'
                        ] 
                    ]
                ]
            ],
            'meta' => [
                'type' => 'meta'
            ]
        ];
    }
}
