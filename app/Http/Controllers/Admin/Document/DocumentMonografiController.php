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

class DocumentMonografiController extends Controller
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
            'no_panggil' => 'No. Panggil',
            'edisi' => 'Cetakan/Edisi',
            'tempat_terbit' => 'Tempat Terbit',
            'tahun_terbit' => 'Tahun Terbit',
            'status_tersedia' => 'Status Tersedia',
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
        return ['title', 'no_panggil'];
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
            'status_tersedia' => [
                'label' => 'Status Tersedia',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ]
            ]
        ];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('tahun_terbit', 'desc')->orderBy('created_at','desc');
    }

    public function formRes()
    {
        return new Document;
    }

    public function formCallbackBefore($post,$item,$type)
    {
        return Helper::formCallbackBefore($post,$item,$type,$this->document);
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
            'teu' => [
                'subtitle' => 'Deskripsi', 
                'label' => 'T.E.U. Orang/Badan',
                'type' => 'text',
                'multilang' => true,
            ],
            'no_panggil' => [
                'label' => 'No. Panggil',
                'type' => 'text',
            ],
            'edisi' => [
                'label' => 'Edisi',
                'type' => 'text',
                'multilang' => true,
            ],
            'tempat_terbit' => [
                'label' => 'Tempat Terbit',
                'type' => 'text',
            ],
            'penerbit' => [
                'label' => 'Penerbit',
                'type' => 'text',
            ],
            'tahun_terbit' => [
                'label' => 'Tahun Terbit',
                'type' => 'number',
                'attributes' => [
                    'class' => 'required',
                    'minlength' => 1
                ]
            ],
            'deskripsi_fisik' => [
                'label' => 'Deskripsi Fisik',
                'type' => 'text',
                'multilang' => true
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true
            ],
            'isbn' => [
                'label' => 'ISBN',
                'type' => 'text'
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true
            ],
            'nomor_induk_buku' => [
                'label' => 'Nomor Induk Buku',
                'type' => 'text'
            ],
            'lokasi' => [
                'label' => 'Lokasi',
                'type' => 'text',
            ],
            'status_tersedia' => [
                'label' => 'Status Tersedia',
                'type' => 'select',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ]
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
                    'class' => 'required',
                    'accept' => 'pdf'
                ]
            ]
        ];
        
        $form['thumbnail'] = [
            'label' => 'Thumbnail',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '283x365',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        $form['image'] = [
            'label' => 'Image Detail',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '317x410',
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
