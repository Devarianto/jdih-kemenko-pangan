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

use App\Models\Document;

use App\Helpers\Document as Helper;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    private $document;

    public function __construct()
    {
        $module = explode('-', $this->module());
        
        $this->document = $module[1];
    }

    public function listingRes()
    {
        $model = Document::translate()->where('master_document_id', Document::getId($this->document));
        
        return $model;
    }

    public function listingFields()
    {
        return Helper::listingFields($this->document);
    }

    public function listingCallback($key,$value,$item,$type)
    {
        if ($key == 'rule_type_id') {
            return $item->rule_type->label ?? '';
        } else if ($key == 'rule_theme_id') {
            return $item->rule_theme->label ?? '';
        } else if ($key == 'tanggal_penetapan') {
            return date2string($value);
        } else if ($key == 'tanggal_pengundangan') {
            return date2string($value);
        } else if ($key == 'status_berlaku') {
            return $item->display_status_berlaku;
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title'];
    }

    public function formRes()
    {
        return new Document;
    }

    public function formCallbackBefore($post,$item,$type)
    {
        $request = request()->all();
        if ($type == 'create') 
            $post['main']['master_document_id'] = Document::getId($this->document);
        
        if ($type == 'create' || $type == 'edit') {
            if (isset($request['pdf']) && $request['pdf'] != null) {
                if ($type == 'edit' && $item->pdf != null) {
                    if (Storage::exists($item->pdf))
                        Storage::delete($item->pdf);
                }

                $original = pathinfo($request['pdf']->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $request['pdf']->getClientOriginalExtension();
                $filename = $original . '_' . time() . '.' . $ext;
                $path = $request['pdf']->storeAs('upload/pdf', $filename);
                
                $post['main']['pdf'] = $path;
            } else if ($type == 'edit' && $item->pdf != null) {
                $post['main']['pdf'] = $item->pdf;
            }

            if (isset($request['abstract']) && $request['abstract'] != null) {
                if ($type == 'edit' && $item->abstract != null) {
                    if (Storage::exists($item->abstract))
                        Storage::delete($item->abstract);
                }
                $original = pathinfo($request['abstract']->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $request['abstract']->getClientOriginalExtension();
                $filename = $original . '_' . time() . '.' . $ext;

                $path = $request['abstract']->storeAs('upload/abstract', $filename);
                $post['main']['abstract'] = $path;
            } else if ($type == 'edit' && $item->abstract != null) {
                $post['main']['abstract'] = $item->abstract;
            }
        }
        
        return $post;
    }

    public function formFields($type)
    {
        $form = Helper::formFields($this->document, $type);
        
        $form += [
            'meta' => [
                'type' => 'meta'
            ]  
        ];
        return $form;
    }

    public function createFile()
    {
        return true;
    }

    public function editFile()
    {
        return true;
    }
}
