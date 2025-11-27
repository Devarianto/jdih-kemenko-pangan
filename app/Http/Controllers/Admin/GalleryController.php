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
use App\Models\Gallery;

use media;

class GalleryController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    public function listingRes()
    {
        return Gallery::translate();
    }
    
    public function listingFields()
    {
        return [
            'title' => 'Title',
            'type' => 'Type',
            'thumbnail' => 'Thumbnail',
            'date' => 'Date',
        ];
    }

    public function listingFilters()
    {
        return [
            'type' => [
                'label' => 'Type',
                'options' => [
                    'image' => 'Image',
                    'video' => 'Video' 
                ]
            ]
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if($key == 'date') {
            return date2string($value);
        }
        if($key == 'thumbnail') {
            return '<img src="'.media::url($value).'" alt="" width="100">';
        }
        return e($value) ?? '-';
    }

    public function listingSearchs()
    {
        return ['title'];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('date','desc');
    }

    public function formRes()
    {
        return new Gallery;
    }

    public function formFields()
    {
        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required',
                    'maxlength' => 150
                ],
                'ai' => ['translate', 'meta-title','correction'],
            ],
            'thumbnail' => [
                'label' => 'Thumbnail',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '360x360',
                    'cfind-convert' => 'webp',
                    'cfind-alt' => 1,
                ]
            ],
            'date' => [
                'label' => 'Date',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required date',
                    'style' => 'width: 200px'
                ]
            ],
            'type' => [
                'label' => 'Type',
                'type' => 'select',
                'options' => [
                    'image' => 'Image',
                    'video' => 'Video'
                ]
            ],
            'iframe' => [
                'label' => 'URL Embed Youtube',
                'type' => 'text',
                'info' => 'eg: https://www.youtube.com/embed/ScMzIvxBSi4'
            ],
            'image' => [
                'type' => 'widget',
                'min' => 1,
                'widgets' => [
                    'thumbnail' => [
                        'label' => 'Thumbnail Popup',
                        'type' => 'text',
                        'attributes' => [
                            'class' => 'required cfind',
                            'cfind-type' => 'image',
                            'cfind-thumb' => '118x78',
                            'cfind-convert' => 'webp',
                            'cfind-alt' => 1,
                        ]
                    ],
                    'image' => [
                        'label' => 'Image Popup',
                        'type' => 'text',
                        'attributes' => [
                            'class' => 'required cfind',
                            'cfind-type' => 'image',
                            'cfind-thumb' => '792x509',
                            'cfind-convert' => 'webp',
                            'cfind-alt' => 1,
                        ]
                    ],
                    'title' => [
                        'label' => 'Title Popup',
                        'type' => 'text',
                        'multilang' => true,
                        'attributes' => [
                            'class' => 'required',
                            'maxlength' => 200
                        ]
                    ]
                ]
            ],
        ];
    }

    public function formAppend()
    {
        return view('admin.gallery.form-js');
    }
}
