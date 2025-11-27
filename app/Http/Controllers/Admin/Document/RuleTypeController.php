<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

use App\Models\RuleType;

class RuleTypeController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    public function listingRes()
    {
        return RuleType::select();
    }
    
    public function listingFields()
    {
        return [
            'label' => 'Label',
            'chart_color' => 'Chart Color',
        ];
    }

    public function formRes()
    {
        return new RuleType;
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
            'chart_color' => [
                'type' => 'text',
                'label' => 'Chart Color',
                'info' => 'eg: #5E5CE6',
                'attributes' => [
                    'class' => 'required'
                ]
            ]
        ];
    }
}
