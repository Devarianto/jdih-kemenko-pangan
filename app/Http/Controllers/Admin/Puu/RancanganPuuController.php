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
use App\Models\StatusProject;
use App\Helpers\Document as Helper;

class RancanganPuuController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait;

    protected $masterId = Document::RANCANGAN_PUU;

    public function listingRes()
    {
        return Document::translate()->where('master_document_id', $this->masterId);
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Rancangan',
            'rule_type_id' => 'Bentuk PUU',
            'tahapan_puu_id' => 'Tahapan PUU',
            'status_harmonisasi' => 'Status Harmonisasi',
            'teu' => 'Unit Pemrakarsa',
            'year' => 'Tahun',
            'download_pdf_count' => 'Unduhan',
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'rule_type_id') {
            return $item->rule_type->label ?? '-';
        } elseif ($key == 'tahapan_puu_id') {
            return $item->tahapan->label ?? ($value ? "Tahap #{$value}" : '-');
        } elseif ($key == 'status_harmonisasi') {
            $badges = [
                'Belum' => '<span class="badge bg-secondary">Belum Harmonisasi</span>',
                'Proses' => '<span class="badge bg-warning text-dark">Dalam Proses</span>',
                'Selesai' => '<span class="badge bg-success">Selesai Harmonisasi</span>',
            ];
            return $badges[$value] ?? ($value ? e($value) : '<span class="badge bg-light text-muted">-</span>');
        } elseif ($key == 'teu') {
            return $value ?: ($item->unit_pemrakarsa ?: '-');
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title', 'no_peraturan', 'teu', 'year'];
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

        $tahapanOptions = StatusProject::translate()->pluck('label', 'id')->all();

        return [
            'year' => [
                'label' => 'Tahun',
                'options' => $years,
            ],
            'rule_type_id' => [
                'label' => 'Bentuk PUU',
                'options' => RuleType::pluck('label', 'id')->all(),
            ],
            'tahapan_puu_id' => [
                'label' => 'Tahapan PUU',
                'options' => $tahapanOptions,
            ],
            'status_harmonisasi' => [
                'label' => 'Status Harmonisasi',
                'options' => [
                    'Belum' => 'Belum Harmonisasi',
                    'Proses' => 'Dalam Proses',
                    'Selesai' => 'Selesai Harmonisasi',
                ],
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

        return Helper::formCallbackBefore($post, $item, $type, 'rancangan_puu', $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function formFields($type)
    {
        $tahapanOptions = StatusProject::translate()->pluck('label', 'id')->toArray();

        // Opsi dokumen acuan (Program Penyusunan atau Naskah Urgensi)
        $relatedDocs = Document::translate()->whereIn('master_document_id', [
            Document::PROGRAM_PENYUSUNAN,
            Document::NASKAH_AKADEMIK
        ])->pluck('title', 'documents.id')->toArray();

        $form = [
            'title' => [
                'label' => 'Judul Rancangan PUU',
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
                'label' => 'Jenis / Bentuk PUU',
                'type' => 'select',
                'options' => RuleType::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'rule_theme_id' => [
                'label' => 'Tematik',
                'type' => 'select',
                'options' => RuleTheme::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'year' => [
                'label' => 'Tahun Rancangan',
                'type' => 'number',
                'attributes' => [
                    'class' => 'required',
                ]
            ],
            'no_peraturan' => [
                'label' => 'Nomor Rancangan (Jika Ada)',
                'type' => 'text',
            ],
            'tahapan_puu_id' => [
                'subtitle' => 'Tahapan & Status Perkembangan',
                'label' => 'Tahapan Pembentukan PUU',
                'type' => 'select',
                'options' => $tahapanOptions,
                'attributes' => [
                    'class' => 'select2 required'
                ]
            ],
            'status_harmonisasi' => [
                'label' => 'Status Harmonisasi',
                'type' => 'select',
                'options' => [
                    'Belum' => 'Belum Harmonisasi',
                    'Proses' => 'Dalam Proses',
                    'Selesai' => 'Selesai Harmonisasi',
                ],
            ],
            'related_document_id' => [
                'label' => 'Dokumen Acuan (Program Penyusunan / Naskah Urgensi)',
                'type' => 'select',
                'options' => ['' => '-- Tidak Ada Dokumen Acuan --'] + $relatedDocs,
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'teu' => [
                'subtitle' => 'Pemrakarsa & Substansi Pokok',
                'label' => 'Unit Pemrakarsa',
                'type' => 'text',
                'multilang' => true,
            ],
            'date' => [
                'label' => 'Tanggal Penyusunan / Dimulai',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker'
                ]
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true,
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true,
            ],
            'intro' => [
                'label' => 'Ringkasan Pokok Pengaturan / Latar Belakang',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Naskah Rancangan',
                'label' => 'Nama Berkas PDF',
                'type' => 'text',
                'multilang' => true,
            ],
            'pdf' => [
                'label' => 'Naskah Rancangan PUU (PDF)',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'attachment' => [
                'label' => 'Lampiran / Matriks DIM / Sandingan (PDF/Doc)',
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
