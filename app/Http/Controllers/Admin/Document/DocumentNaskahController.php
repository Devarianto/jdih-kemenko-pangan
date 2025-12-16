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
use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\DocumentType;

use App\Helpers\Document as Helper;
use Illuminate\Support\Facades\Storage;

class DocumentNaskahController extends Controller
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
        return [
            'title' => 'Judul',
            'nomor_perjanjian' => 'No. Perjanjian',
            'tanggal_berlaku' => 'Tanggal Berlaku',
            'tanggal_berakhir' => 'Tempat Berakhir',
            'status_berlaku' => 'Status Berlaku',
            'view_count' => 'View Count',
            'download_pdf_count' => 'Download Count',
        ];
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
        } else if ($key == 'status_tersedia') {
            return $item->front_status_tersedia;
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title', 'nomor_perjanjian'];
    }

    public function listingFilters()
    {
        return [
            'rule_theme_id' => [
                'label' => 'Tema',
                'options' => RuleTheme::pluck('label','id')->all(),
            ],
            'document_type_id' => [
                'label' => 'Tipe',
                'options' => DocumentType::pluck('label','id')->all(),
            ],
            'status_berlaku' => [
                'label' => 'Status Berlaku',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ]
            ]
        ];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('tanggal_berlaku', 'desc');
    }

    public function formRes()
    {
        return new Document;
    }

    public function formCallbackBefore($post,$item,$type)
    {
        return Helper::formCallbackBefore($post,$item,$type,$this->document,$this->formFields($type));
    }

    public function formFields($type)
    {
        $form = [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required title',
                    'maxlength' => 200,
                ]
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'intro' => [
                'label' => 'Intro',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required',
                    'maxlength' => 250,
                ]
            ],
            'thumbnail' => [],
            'image' => [],
            'rule_theme_id' => [
                'label' => 'Tema Peraturan',
                'type' => 'select',
                'options' => RuleTheme::pluck('label', 'id')->toArray()
            ],
            'document_type_id' => [
                'label' => 'Tipe Dokumen',
                'type' => 'select',
                'options' => DocumentType::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'required select2'
                ]
            ],
        ];

        $form += [
            'jenis_bentuk_peraturan' => [
                'label' => 'Jenis/Bentuk Peraturan',
                'type' => 'text',
                'multilang' => true,
            ],
            'pihak_internal' => [
                'label' => 'Pihak Internal',
                'type' => 'text'
            ],
            'pihak_eksternal' => [
                'label' => 'Pihak Eksternal',
                'type' => 'text'
            ],
            'nomor_perjanjian' => [
                'label' => 'No. Perjanjian',
                'type' => 'text'
            ],
            'tempat_penandatanganan' => [
                'label' => 'Tempat Penandatanganan',
                'type' => 'text'
            ],
            'tanggal_berlaku' => [
                'label' => 'Tanggal Berlaku',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required datepicker'
                ]
            ],
            'tanggal_berakhir' => [
                'label' => 'Tanggal Berakhir',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required datepicker'
                ]
            ],
            'jangka_waktu' => [
                'label' => 'Jangka Waktu',
                'type' => 'text',
                'multilang' => true
            ],
            'status_berlaku' => [
                'label' => 'Status Berlaku',
                'type' => 'select',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ]
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
            ],
            'lampiran' => [
                'label' => 'Lampiran',
                'type' => 'textarea',
                'multilang' => true
            ],
            'pdf_name' => [
                'subtitle' => 'File',
                'label' => 'File Name',
                'type' => 'text',
                'multilang' => true
            ],
            'pdf' => [
                'label' => 'PDF',
                'type' => 'file',
                'is_delete' => true,
                'attributes' => [
                    'accept' => 'pdf'
                ]
            ],
        ];

        $form['thumbnail'] = [
            'label' => 'Thumbnail',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '240x220',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        if ($type == 'edit') {
            unset($form['pdf']['attributes']['class']);
        }
        
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
