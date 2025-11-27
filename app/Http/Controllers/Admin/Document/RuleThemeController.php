<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

use App\Models\RuleTheme;
use media;

class RuleThemeController extends Controller
{
    use BaseTrait, ListingTrait, EditTrait, PublishTrait;

    public function listingRes()
    {
        return RuleTheme::select();
    }
    
    public function listingFields()
    {
        return [
            'label' => 'Label',
            'image' => 'Image'
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if($key == 'image') {
            return '<img src="'.media::url($value).'" alt="" width="100">';
        }
        return e($value) ?? '-';
    }

    public function formRes()
    {
        return new RuleTheme;
    }

    public function formFields()
    {
        return [
            'label' => [
                'type' => 'text',
                'label' => 'Label',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'icon' => [
                'type' => 'text',
                'label' => 'Icon',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-alt' => 1,
                ]
            ],
            'image' => [
                'type' => 'text',
                'label' => 'Image',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '281x220',
                    'cfind-convert' => 'webp',
                    'cfind-alt' => 1,
                ]
            ]
        ];
    }
}
