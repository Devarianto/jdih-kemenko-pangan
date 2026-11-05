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
use App\Helpers\Document as Helper;

class AnalisisEvaluasiController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait;

    protected $masterId = Document::ANALISIS_EVALUASI;

    public function listingRes()
    {
        return Document::translate()->where('master_document_id', $this->masterId);
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Analisis & Evaluasi',
            'related_document_id' => 'Peraturan yang Dievaluasi',
            'periode_evaluasi' => 'Periode Evaluasi',
            'teu' => 'Unit Pelaksana',
            'date' => 'Tanggal Evaluasi',
            'download_pdf_count' => 'Unduhan',
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'related_document_id') {
            return $item->related_document ? e($item->related_document->title) : '<span class="text-muted">-</span>';
        } elseif ($key == 'date') {
            return $value ? date2string($value) : '-';
        } elseif ($key == 'periode_evaluasi') {
            return $value ?: '-';
        } elseif ($key == 'teu') {
            return $value ?: ($item->unit_pemrakarsa ?: '-');
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title', 'periode_evaluasi', 'teu', 'metode_evaluasi'];
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

        return Helper::formCallbackBefore($post, $item, $type, 'analisis_evaluasi', $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function formFields($type)
    {
        // Opsi peraturan yang dievaluasi
        $peraturanList = Document::translate()->where('master_document_id', Document::PERATURAN)
            ->pluck('title', 'documents.id')
            ->toArray();

        $form = [
            'title' => [
                'label' => 'Judul Laporan Analisis & Evaluasi',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required title',
                ]
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'related_document_id' => [
                'label' => 'Peraturan yang Dievaluasi',
                'type' => 'select',
                'options' => ['' => '-- Pilih Peraturan yang Dievaluasi --'] + $peraturanList,
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'periode_evaluasi' => [
                'label' => 'Periode Evaluasi (Contoh: Semester I 2025 atau Tahun 2024)',
                'type' => 'text',
            ],
            'teu' => [
                'label' => 'Unit Pelaksana / Tim Evaluasi',
                'type' => 'text',
                'multilang' => true,
            ],
            'date' => [
                'label' => 'Tanggal Pelaksanaan / Laporan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker required'
                ]
            ],
            'metode_evaluasi' => [
                'subtitle' => 'Metodologi & Temuan Evaluasi',
                'label' => 'Metode Evaluasi (Dimensi & Instrumen Evaluasi)',
                'type' => 'text',
                'multilang' => true,
            ],
            'intro' => [
                'label' => 'Ringkasan Eksekutif Hasil Analisis',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'kesimpulan' => [
                'label' => 'Kesimpulan Hasil Evaluasi',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'rekomendasi' => [
                'label' => 'Rekomendasi Tindak Lanjut (Pertahankan / Revisi / Cabut)',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Dokumen Laporan',
                'label' => 'Nama Berkas PDF',
                'type' => 'text',
                'multilang' => true,
            ],
            'pdf' => [
                'label' => 'Laporan Analisis & Evaluasi (PDF)',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'attachment' => [
                'label' => 'Dokumen Lampiran Pendukung (Opsional)',
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
