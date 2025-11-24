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

use App\Models\Infografis;

use media;

class InfografisController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    public function listingRes()
    {
        return Infografis::translate();
    }
    
    public function listingFields()
    {
        return [
            'title' => 'Title',
            'thumbnail' => 'Thumbnail',
            'date' => 'Date',
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
        return new Infografis;
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
                    'maxlength' => 255
                ],
                'ai' => ['translate', 'meta-title','correction'],
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'thumbnail' => [
                'label' => 'Thumbnail',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '283x365',
                    'cfind-convert' => 'webp',
                    'cfind-alt' => 1,
                ]
            ],
            'image' => [
                'subtitle' => 'Image',
                'type' => 'widget',
                'widgets' => [
                    'image' => [
                        'label' => 'Image',
                        'type' => 'text',
                        'attributes' => [
                            'class' => 'required cfind',
                            'cfind-type' => 'image',
                            'cfind-thumb' => '990x1022',
                            'cfind-convert' => 'webp',
                            'cfind-alt' => 1,
                        ]
                    ],
                ],
            ],
            'date' => [
                'label' => 'Date',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required date',
                    'style' => 'width: 200px'
                ]
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
            'meta' => [
                'type' => 'meta'
            ]
        ];
    }

    public function formAppend()
    {
        return view('admin.infografis.form-js');
    }
}
