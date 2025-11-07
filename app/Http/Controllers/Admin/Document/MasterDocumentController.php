<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

use App\Models\MasterDocument;

class MasterDocumentController extends Controller
{
    use BaseTrait, ListingTrait, EditTrait, PublishTrait;

    public function listingRes()
    {
        return MasterDocument::select();
    }
    
    public function listingFields()
    {
        return [
            'label' => 'Label',
        ];
    }

    public function formRes()
    {
        return new MasterDocument;
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
            ]
        ];
    }
}
