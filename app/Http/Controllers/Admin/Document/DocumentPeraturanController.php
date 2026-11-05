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

class DocumentPeraturanController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    private $document;

    public function __construct()
    {
        $this->document = 'peraturan';
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
            'no_peraturan' => 'No. Peraturan',
            'rule_type_id' => 'Jenis Peraturan' ,
            'rule_theme_id' => 'Tema',
            'tanggal_penetapan' => 'Tanggal Penetapan',
            'tanggal_pengundangan' => 'Tanggal Pengundangan',
            'status_berlaku' => 'Status Berlaku',
            'view_count' => 'View Count',
            'download_pdf_count' => 'Download Count'
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
        return ['title', 'no_peraturan'];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function listingFilters()
    {
        return [
            'rule_theme_id' => [
                'label' => 'Tema',
                'options' => RuleTheme::pluck('label','id')->all(),
            ],
            'rule_type_id' => [
                'label' => 'Jenis Peraturan',
                'options' => RuleType::pluck('label','id')->all(),
            ],
            'status_berlaku' => [
                'label' => 'Status Berlaku',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ]
            ],
        ];
    }

    public function formRes()
    {
        return new Document;
    }

    public function formCallbackBefore($post,$item,$type)
    {
        return Helper::formCallbackBefore($post,$item,$type,$this->document, $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
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
            'rule_type_id' => [
                'label' => 'Jenis Peraturan',
                'type' => 'select',
                'options' => RuleType::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'required select2'
                ]
            ],
            'year' => [
                'label' => 'Tahun',
                'type' => 'number',
                'attributes' => [
                    'class' => 'required',
                    'minlength' => 1
                ]
            ],
            'status_berlaku' => [
                'label' => 'Status Peraturan (Berlaku/Tidak Berlaku)',
                'type' => 'select',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ],
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'teu' => [
                'subtitle' => 'Deskripsi', 
                'label' => 'T.E.U. Badan/Pengarang',
                'type' => 'text',
                'multilang' => true,
            ],
            'no_peraturan' => [
                'label' => 'Nomor Peraturan',
                'type' => 'text',
            ],
            'jenis_bentuk_peraturan' => [
                'label' => 'Jenis/Bentuk Peraturan',
                'type' => 'text',
                'multilang' => true,
            ],
            'singkatan_bentuk_peraturan' => [
                'label' => 'Singkatan Jenis/Bentuk Peraturan',
                'type' => 'text',
                'multilang' => true,
            ],
            'tempat_penetapan' => [
                'label' => 'Tempat Penetapan',
                'type' => 'text',
            ],
            'tanggal_penetapan' => [
                'label' => 'Tanggal Penetapan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker'
                ]
            ],
            'tanggal_pengundangan' => [
                'label' => 'Tanggal Pengundangan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker'
                ]
            ],
            'sumber' => [
                'label' => 'Sumber',
                'type' => 'text',
                'multilang' => true
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true
            ],
            'status_peraturan' => [
                'label' => 'Status Peraturan',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
            ],
            'lokasi' => [
                'label' => 'Lokasi',
                'type' => 'text',
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
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
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'abstract' => [
                'label' => 'Abstrak',
                'type' => 'file',
                'is_delete' => true
            ]
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
            unset($form['pdf']['attributes']);
            unset($form['abstract']['attributes']);
        }
        
        $form += [
            'translation' => [
                'type' => 'free',
                'html' => function($res) {
                    return view('admin.document.translation-widget', ['res' => $res])->render();
                }
            ],
            'relations' => [
                'type' => 'free',
                'html' => function($res) {
                    return view('admin.document.relations-widget', ['res' => $res])->render();
                }
            ],
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
