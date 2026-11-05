<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

use App\Models\RuleTheme;
use media;

class RuleThemeController extends Controller
{
    use BaseTrait, CreateTrait, ListingTrait, EditTrait, DeleteTrait, PublishTrait;

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

    public function listingOrderDefault($res)
    {
        return $res->orderBy('sort_id');
    }

    public function deleteAble($item)
    {
        if ($item->id <= 4) {
            return false;
        }

        return true;
    }

    public function formRes()
    {
        return new RuleTheme;
    }

    public function createCallbackBefore($post, $item)
    {
        if (empty($item->sort_id) && empty($post['main']['sort_id'])) {
            $post['main']['sort_id'] = (RuleTheme::max('sort_id') ?? 0) + 1;
        }
        return $post;
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
