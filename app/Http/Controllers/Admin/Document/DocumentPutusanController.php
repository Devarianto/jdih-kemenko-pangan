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

class DocumentPutusanController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    protected $masterId = \App\Models\Document::PUTUSAN;

    private $document;

    public function __construct()
    {
        $this->document = 'putusan';
    }

    public function listingRes()
    {
        $model = Document::translate()->where('master_document_id', Document::getId($this->document));
        
        return $model;
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Putusan',
            'no_putusan' => 'No. Putusan',
            'court_type' => 'Lembaga Peradilan',
            'tempat_peradilan' => 'Tempat Peradilan',
            'tanggal_dibacakan' => 'Tanggal Dibacakan',
            'status_berlaku' => 'Status Berlaku',
            'view_count' => 'View Count',
            'download_pdf_count' => 'Download Count',
        ];
    }

    public function listingCallback($key,$value,$item,$type)
    {
        if ($key == 'court_type') {
            if ($value === 'MA') {
                return '<span class="badge" style="background:#0284c7; color:#fff; font-size:12px; padding:4px 8px; border-radius:4px;">Mahkamah Agung (MA)</span>';
            } elseif ($value === 'MK') {
                return '<span class="badge" style="background:#dc2626; color:#fff; font-size:12px; padding:4px 8px; border-radius:4px;">Mahkamah Konstitusi (MK)</span>';
            } elseif ($value === 'NEEDS_CLASSIFICATION') {
                return '<span class="badge" style="background:#d97706; color:#fff; font-size:12px; padding:4px 8px; border-radius:4px;">NEEDS_CLASSIFICATION</span>';
            }
            return e($item->court_label ?? $value);
        } else if ($key == 'rule_theme_id') {
            return $item->rule_theme->label ?? '';
        } else if ($key == 'tanggal_dibacakan') {
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
        return ['title', 'no_putusan', 'court_type', 'pemohon', 'pokok_perkara'];
    }

    public function listingFilters()
    {
        return [
            'court_type' => [
                'label' => 'Lembaga Peradilan',
                'options' => [
                    'MA' => 'Mahkamah Agung (MA)',
                    'MK' => 'Mahkamah Konstitusi (MK)',
                    'NEEDS_CLASSIFICATION' => 'Perlu Klasifikasi (NEEDS_CLASSIFICATION)',
                ],
            ],
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
            ],
        ];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function formRes()
    {
        return new Document;
    }

    public function formCallbackBefore($post,$item,$type)
    {
        // Enforce Lembaga Peradilan classification and sync to jenis_peradilan / singkatan_peradilan
        if (!empty($post['main']['court_type'])) {
            $court = $post['main']['court_type'];
            if ($court === 'MA') {
                foreach (['id', 'en'] as $l) {
                    $post['il8n'][$l]['jenis_peradilan'] = 'Mahkamah Agung';
                    $post['il8n'][$l]['singkatan_peradilan'] = 'MA';
                }
            } elseif ($court === 'MK') {
                foreach (['id', 'en'] as $l) {
                    $post['il8n'][$l]['jenis_peradilan'] = 'Mahkamah Konstitusi';
                    $post['il8n'][$l]['singkatan_peradilan'] = 'MK';
                }
            }
        }

        // Auto populate year from tanggal_dibacakan if empty
        if (!empty($post['main']['tanggal_dibacakan'])) {
            $post['main']['year'] = date('Y', strtotime($post['main']['tanggal_dibacakan']));
        }

        return Helper::formCallbackBefore($post,$item,$type,$this->document, $this->formFields($type));
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function formFields($type)
    {
        $form = [
            'court_type' => [
                'label' => 'Lembaga Peradilan',
                'type' => 'select',
                'options' => [
                    '' => '-- Pilih Lembaga Peradilan --',
                    'MA' => 'Mahkamah Agung (MA)',
                    'MK' => 'Mahkamah Konstitusi (MK)',
                ],
                'rules' => 'required|in:MA,MK',
                'attributes' => [
                    'class' => 'required',
                ]
            ],
            'title' => [
                'label' => 'Judul Putusan',
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
                'label' => 'Ringkasan / Abstrak Putusan',
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
                    'class' => 'select2'
                ]
            ],
        ];

        $form += [
            'teu' => [
                'subtitle' => 'Metadata Putusan', 
                'label' => 'T.E.U. Orang/Badan',
                'type' => 'text',
                'multilang' => true,
            ],
            'no_putusan' => [
                'label' => 'No. Putusan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'tanggal_dibacakan' => [
                'label' => 'Tanggal Putusan / Dibacakan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required datepicker'
                ]
            ],
            'tempat_peradilan' => [
                'label' => 'Tempat Peradilan',
                'type' => 'text'
            ],
            'pemohon' => [
                'label' => 'Pemohon / Penggugat / Pihak Terkait',
                'type' => 'text',
                'multilang' => true,
            ],
            'termohon' => [
                'label' => 'Termohon / Tergugat',
                'type' => 'text',
                'multilang' => true,
            ],
            'pokok_perkara' => [
                'label' => 'Pokok Perkara',
                'type' => 'textarea',
                'multilang' => true,
            ],
            'amar_putusan' => [
                'label' => 'Amar Putusan',
                'type' => 'textarea',
                'multilang' => true,
            ],
            'status_berlaku' => [
                'label' => 'Status Putusan (1 = Berlaku/BHT, 0 = Tidak Berlaku)',
                'type' => 'select',
                'options' => [
                    1 => 'Berlaku / Berkekuatan Hukum Tetap',
                    0 => 'Tidak Berlaku / Gugur'
                ],
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true,
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum / Jenis Perkara',
                'type' => 'text',
                'multilang' => true,
            ],
            'sumber' => [
                'label' => 'Sumber',
                'type' => 'text',
                'multilang' => true,
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true,
            ],
            'lokasi' => [
                'label' => 'Lokasi Fisik',
                'type' => 'text',
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Dokumen',
                'label' => 'Nama File PDF',
                'type' => 'text',
                'multilang' => true
            ],
            'pdf' => [
                'label' => 'File PDF Putusan',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required',
                    'accept' => 'pdf'
                ]
            ],
            'attachment' => [
                'label' => 'File Lampiran (Opsional)',
                'type' => 'file',
            ],
        ];

        $form['thumbnail'] = [
            'label' => 'Thumbnail',
            'type' => 'text',
            'attributes' => [
                'class' => 'cfind',
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
