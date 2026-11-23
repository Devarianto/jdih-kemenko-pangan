<?php

namespace App\Http\Controllers\Admin\Puu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;
use Cactuar\Admin\Traits\Controllers\DownloadTrait;

use App\Models\Document;
use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\DocumentType;
use App\Helpers\Document as Helper;

class NaskahUrgensiController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait;

    protected $masterId = Document::NASKAH_AKADEMIK;

    public function listingRes()
    {
        return Document::translate()->where('master_document_id', $this->masterId);
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Naskah',
            'teu' => 'Pemrakarsa / Penulis',
            'lokasi' => 'Unit Kerja',
            'rule_type_id' => 'Bentuk PUU Terkait',
            'date' => 'Tanggal Penyusunan',
            'download_pdf_count' => 'Unduhan',
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'rule_type_id') {
            return $item->rule_type->label ?? '-';
        } elseif ($key == 'date') {
            return $value ? date2string($value) : '-';
        } elseif ($key == 'teu') {
            return $value ?: '-';
        } elseif ($key == 'lokasi') {
            return $value ?: '-';
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title', 'teu', 'lokasi', 'subjek', 'bidang_hukum'];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function listingFilters()
    {
        return [
            'rule_type_id' => [
                'label' => 'Bentuk PUU',
                'options' => RuleType::pluck('label', 'id')->all(),
            ],
        ];
    }

    public function formRes()
    {
        return new Document;
    }

    public function formCallbackBefore($post, $item, $type)
    {
        if ($type == 'create') {
            $post['main']['master_document_id'] = $this->masterId;
        }

        return Helper::formCallbackBefore($post, $item, $type, 'naskah_akademik', $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function formFields($type)
    {
        // Dokumen PUU / Peraturan terkait untuk dropdown (unik per judul)
        $relatedDocs = Document::dropdownOptions([
            Document::PERATURAN,
            Document::RANCANGAN_PUU,
            Document::PROGRAM_PENYUSUNAN
        ]);

        $form = [
            'title' => [
                'label' => 'Judul Naskah Urgensi / Akademik',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required title',
                ]
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'rule_type_id' => [
                'label' => 'Jenis / Bentuk PUU Terkait',
                'type' => 'select',
                'options' => RuleType::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'related_document_id' => [
                'label' => 'Peraturan / Rancangan PUU Terkait (Opsional)',
                'type' => 'select',
                'options' => ['' => '-- Pilih Regulasi Terkait --'] + $relatedDocs,
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'year' => [
                'label' => 'Tahun Penyusunan',
                'type' => 'number',
                'attributes' => [
                    'class' => 'required',
                ]
            ],
            'teu' => [
                'subtitle' => 'Pemrakarsa & Substansi',
                'label' => 'Pemrakarsa / Penulis',
                'type' => 'text',
                'multilang' => true,
            ],
            'lokasi' => [
                'label' => 'Unit Kerja',
                'type' => 'text',
            ],
            'date' => [
                'label' => 'Tanggal Penyusunan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker'
                ]
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true,
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true,
            ],
            'intro' => [
                'label' => 'Ringkasan / Abstrak Naskah',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Dokumen',
                'label' => 'Nama Berkas PDF',
                'type' => 'text',
                'multilang' => true,
            ],
            'pdf' => [
                'label' => 'Dokumen Naskah Utama (PDF)',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'attachment' => [
                'label' => 'Lampiran Pendukung (Opsional)',
                'type' => 'file',
                'is_delete' => true
            ],
            'thumbnail' => [
                'label' => 'Thumbnail Cover',
                'type' => 'text',
                'attributes' => [
                    'class' => 'cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '240x220',
                    'cfind-convert' => 'webp',
                    'cfind-alt' => 1,
                ]
            ],
        ];

        if ($type == 'edit') {
            unset($form['pdf']['attributes']);
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

    public function editFile($item = null)
    {
        return true;
    }
}
