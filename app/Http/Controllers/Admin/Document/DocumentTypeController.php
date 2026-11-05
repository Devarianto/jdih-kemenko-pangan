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

use App\Models\DocumentType;

class DocumentTypeController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    public function listingRes()
    {
        return DocumentType::select();
    }
    
    public function listingFields()
    {
        return [
            'label' => 'Label',
        ];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function formRes()
    {
        return new DocumentType;
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
