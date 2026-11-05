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
use App\Models\PublicConsultationFeedback;
use App\Helpers\Document as Helper;

class PartisipasiPublikController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait;

    protected $masterId = Document::PARTISIPASI_PUBLIK;

    public function getIndex()
    {
        return redirect()->route('admin.partisipasi.index');
    }

    public function listingRes()
    {
        return Document::translate()
            ->withCount('feedbacks')
            ->where('master_document_id', $this->masterId);
    }

    public function listingFields()
    {
        return [
            'title' => 'Judul Konsultasi Publik',
            'related_document_id' => 'Rancangan PUU Terkait',
            'periode' => 'Periode Konsultasi',
            'status_konsultasi' => 'Status Konsultasi',
            'feedbacks_count' => 'Masukan Masuk',
            'download_pdf_count' => 'Unduhan',
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'related_document_id') {
            return $item->related_document ? e($item->related_document->title) : '<span class="text-muted">-</span>';
        } elseif ($key == 'periode') {
            $mulai = $item->tanggal_mulai ? date2string($item->tanggal_mulai) : 'Segera';
            $selesai = $item->tanggal_selesai ? date2string($item->tanggal_selesai) : 'Terbuka';
            return "{$mulai} s/d {$selesai}";
        } elseif ($key == 'status_konsultasi') {
            $status = $item->status_konsultasi ?: 'Menunggu';
            $badges = [
                'Dibuka' => '<span class="badge bg-success">Dibuka</span>',
                'Ditutup' => '<span class="badge bg-danger">Ditutup</span>',
                'Menunggu' => '<span class="badge bg-warning text-dark">Segera / Menunggu</span>',
            ];
            return $badges[$status] ?? '<span class="badge bg-secondary">' . e($status) . '</span>';
        } elseif ($key == 'feedbacks_count') {
            $count = $item->feedbacks_count ?? 0;
            $url = url()->admin('puu-partisipasi-publik/feedback?unique=' . $item->id);
            return '<a href="' . $url . '" class="btn btn-sm btn-info text-white"><i class="fa fa-comments"></i> ' . $count . ' Masukan</a>';
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title', 'status_konsultasi', 'teu'];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function listingFilters()
    {
        return [
            'status_konsultasi' => [
                'label' => 'Status Konsultasi',
                'options' => [
                    'Dibuka' => 'Dibuka',
                    'Ditutup' => 'Ditutup',
                    'Menunggu' => 'Segera / Menunggu',
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

        return Helper::formCallbackBefore($post, $item, $type, 'partisipasi_publik', $this->formFields($type));
    }

    public function formFields($type)
    {
        // Opsi Rancangan PUU yang dikonsultasikan
        $rancanganList = Document::translate()->where('master_document_id', Document::RANCANGAN_PUU)
            ->pluck('title', 'documents.id')
            ->toArray();

        $form = [
            'title' => [
                'label' => 'Judul Konsultasi Publik',
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
                'label' => 'Rancangan PUU yang Dikonsultasikan',
                'type' => 'select',
                'options' => ['' => '-- Pilih Rancangan PUU Terkait --'] + $rancanganList,
                'attributes' => [
                    'class' => 'select2 required'
                ]
            ],
            'tanggal_mulai' => [
                'subtitle' => 'Jadwal & Status Konsultasi Publik',
                'label' => 'Tanggal Mulai Konsultasi',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker required'
                ]
            ],
            'tanggal_selesai' => [
                'label' => 'Tanggal Selesai Konsultasi',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker required'
                ]
            ],
            'status_konsultasi' => [
                'label' => 'Status Konsultasi',
                'type' => 'select',
                'options' => [
                    'Dibuka' => 'Dibuka (Terima Masukan Publik)',
                    'Ditutup' => 'Ditutup',
                    'Menunggu' => 'Segera / Menunggu',
                ],
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'teu' => [
                'subtitle' => 'Penyelenggara & Panduan Masukan',
                'label' => 'Unit Penyelenggara / Pengelola',
                'type' => 'text',
                'multilang' => true,
            ],
            'panduan_masukan' => [
                'label' => 'Panduan & Ketentuan Pemberian Masukan',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'intro' => [
                'label' => 'Ringkasan & Ruang Lingkup Konsultasi Publik',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'Berkas Naskah Rancangan untuk Publik',
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
                'label' => 'Dokumen Pendukung / Lembar Kuesioner (Opsional)',
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

    /**
     * Menampilkan daftar masukan masyarakat untuk dokumen partisipasi publik tertentu
     */
    public function getFeedback($id = null)
    {
        $id = $id ?: request('unique', request('document_id', request('id')));
        $document = Document::translate()->findOrFail($id);
        $feedbacks = PublicConsultationFeedback::where('document_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.puu.feedback_list', compact('document', 'feedbacks'));
    }

    /**
     * Menampilkan detail masukan publik
     */
    public function getFeedbackDetail($id = null)
    {
        $id = $id ?: request('unique', request('id'));
        $feedback = PublicConsultationFeedback::with('document')->findOrFail($id);

        return view('admin.puu.feedback_detail', compact('feedback'));
    }

    /**
     * Mengupdate status verifikasi masukan publik
     */
    public function postFeedbackStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:public_consultation_feedbacks,id',
            'status' => 'required|in:pending,approved,rejected,reviewed',
            'notes' => 'nullable|string',
        ]);

        $feedback = PublicConsultationFeedback::findOrFail($request->id);
        $feedback->status = $request->status;
        if ($request->has('notes')) {
            $feedback->notes = $request->notes;
        }
        $feedback->save();

        return redirect()->back()->with('success', 'Status masukan berhasil diperbarui.');
    }
}
