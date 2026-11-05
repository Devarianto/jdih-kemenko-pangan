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
use App\Models\RuleTheme;
use App\Helpers\Document as Helper;

class KajianHukumController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait;

    protected $masterId = Document::KAJIAN_HUKUM;

    public function listingRes()
    {
        return Document::translate()->where('master_document_id', $this->masterId);
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Kajian Hukum',
            'teu' => 'Penulis / Peneliti',
            'bidang_hukum' => 'Bidang Hukum',
            'subjek' => 'Subjek',
            'date' => 'Tanggal Kajian',
            'download_pdf_count' => 'Unduhan',
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'date') {
            return $value ? date2string($value) : '-';
        } elseif ($key == 'teu') {
            return $value ?: '-';
        } elseif ($key == 'bidang_hukum') {
            return $value ?: '-';
        } elseif ($key == 'subjek') {
            return $value ?: '-';
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title', 'teu', 'bidang_hukum', 'subjek'];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function listingFilters()
    {
        $years = Document::where('master_document_id', $this->masterId)
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->all();

        return [
            'year' => [
                'label' => 'Tahun',
                'options' => $years,
            ],
            'rule_theme_id' => [
                'label' => 'Tematik',
                'options' => RuleTheme::pluck('label', 'id')->all(),
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

        return Helper::formCallbackBefore($post, $item, $type, 'kajian_hukum', $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function formFields($type)
    {
        // Opsi dokumen peraturan terkait
        $relatedDocs = Document::translate()->whereIn('master_document_id', [
            Document::PERATURAN,
            Document::RANCANGAN_PUU
        ])->pluck('title', 'documents.id')->toArray();

        $form = [
            'title' => [
                'label' => 'Judul Kajian Hukum',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required title',
                ]
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'rule_theme_id' => [
                'label' => 'Tematik',
                'type' => 'select',
                'options' => RuleTheme::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'teu' => [
                'label' => 'Penulis / Tim Peneliti / Lembaga Pengkaji',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'date' => [
                'label' => 'Tanggal Publikasi / Kajian',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker required'
                ]
            ],
            'subjek' => [
                'label' => 'Subjek Kajian',
                'type' => 'text',
                'multilang' => true,
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true,
            ],
            'related_document_id' => [
                'label' => 'Dokumen Hukum / PUU Terkait (Opsional)',
                'type' => 'select',
                'options' => ['' => '-- Tidak Ada Dokumen Terkait --'] + $relatedDocs,
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'intro' => [
                'subtitle' => 'Substansi & Rekomendasi Kajian',
                'label' => 'Latar Belakang & Ringkasan Eksekutif',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'kesimpulan' => [
                'label' => 'Kesimpulan Hasil Kajian',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'rekomendasi' => [
                'label' => 'Rekomendasi Kebijakan / Formulasi PUU',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Dokumen Kajian',
                'label' => 'Nama Berkas PDF',
                'type' => 'text',
                'multilang' => true,
            ],
            'pdf' => [
                'label' => 'Naskah Laporan Kajian Hukum (PDF)',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'attachment' => [
                'label' => 'Lampiran Tambahan (Bahan Analisis / Data Pendukung)',
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
