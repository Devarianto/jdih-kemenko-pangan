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

class RisalahPembahasanController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait;

    protected $masterId = Document::RISALAH_PEMBAHASAN;

    public function listingRes()
    {
        return Document::translate()->where('master_document_id', $this->masterId);
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Risalah / Rapat',
            'related_document_id' => 'Rancangan PUU Terkait',
            'date' => 'Tanggal Pembahasan',
            'tempat_penetapan' => 'Tempat / Lokasi',
            'pihak_internal' => 'Peserta / Pihak Terlibat',
            'download_pdf_count' => 'Unduhan',
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'related_document_id') {
            return $item->related_document ? e($item->related_document->title) : '<span class="text-muted">-</span>';
        } elseif ($key == 'date') {
            return $value ? date2string($value) : '-';
        } elseif ($key == 'tempat_penetapan') {
            return $value ?: '-';
        } elseif ($key == 'pihak_internal') {
            return $value ?: ($item->teu ?: '-');
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title', 'tempat_penetapan', 'pihak_internal', 'teu'];
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

        return Helper::formCallbackBefore($post, $item, $type, 'risalah_pembahasan', $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function formFields($type)
    {
        // Opsi Rancangan PUU terkait (unik per judul, tersinkron dari e-Regulasi)
        $rancanganList = Document::rancanganDropdownOptions();

        $form = [
            'title' => [
                'label' => 'Judul Risalah / Rapat Pembahasan',
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
                'label' => 'Rancangan PUU yang Dibahas',
                'type' => 'select',
                'options' => ['' => '-- Pilih Rancangan PUU Terkait --'] + $rancanganList,
                'attributes' => [
                    'class' => 'select2'
                ]
            ],
            'date' => [
                'label' => 'Tanggal Rapat / Pembahasan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker required'
                ]
            ],
            'tempat_penetapan' => [
                'label' => 'Tempat / Lokasi Pelaksanaan',
                'type' => 'text',
            ],
            'pihak_internal' => [
                'subtitle' => 'Peserta & Notula Pembahasan',
                'label' => 'Peserta / Pihak Terlibat',
                'type' => 'text',
            ],
            'teu' => [
                'label' => 'Unit Penyelenggara / Pemrakarsa',
                'type' => 'text',
                'multilang' => true,
            ],
            'intro' => [
                'label' => 'Agenda & Pokok Bahasan',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'rekomendasi' => [
                'label' => 'Kesimpulan / Hasil Keputusan Rapat',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Dokumen Notula',
                'label' => 'Nama Berkas PDF',
                'type' => 'text',
                'multilang' => true,
            ],
            'pdf' => [
                'label' => 'Naskah Risalah Pembahasan (PDF)',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'attachment' => [
                'label' => 'Lampiran (Daftar Hadir / Bahan Tayang / Matriks)',
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
