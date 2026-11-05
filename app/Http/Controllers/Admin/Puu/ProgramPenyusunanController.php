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

class ProgramPenyusunanController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait;

    protected $masterId = Document::PROGRAM_PENYUSUNAN;

    public function listingRes()
    {
        return Document::translate()->where('master_document_id', $this->masterId);
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Program',
            'year' => 'Tahun',
            'rule_type_id' => 'Bentuk PUU',
            'teu' => 'Unit Pemrakarsa',
            'no_peraturan' => 'Nomor/Identitas',
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

        return [
            'year' => [
                'label' => 'Tahun',
                'options' => $years,
            ],
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

        return Helper::formCallbackBefore($post, $item, $type, 'program_penyusunan', $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function formFields($type)
    {
        $form = [
            'title' => [
                'label' => 'Judul Program PUU',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required title',
                ]
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'year' => [
                'label' => 'Tahun Perencanaan',
                'type' => 'number',
                'attributes' => [
                    'class' => 'required',
                ]
            ],
            'rule_type_id' => [
                'label' => 'Jenis / Bentuk PUU yang Direncanakan',
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
            'no_peraturan' => [
                'label' => 'Nomor / Identitas Program (Jika Ada)',
                'type' => 'text',
            ],
            'periode_perencanaan' => [
                'label' => 'Periode Perencanaan (Contoh: 2025-2029)',
                'type' => 'text',
            ],
            'teu' => [
                'subtitle' => 'Pemrakarsa & Substansi',
                'label' => 'Unit Pemrakarsa',
                'type' => 'text',
                'multilang' => true,
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
                'label' => 'Deskripsi / Keterangan Program',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Dokumen Pendukung',
                'label' => 'Nama Berkas PDF',
                'type' => 'text',
                'multilang' => true,
            ],
            'pdf' => [
                'label' => 'Dokumen Utama (PDF)',
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
