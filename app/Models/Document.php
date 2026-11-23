<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;
use Cactuar\Admin\Traits\Models\PermalinkTrait;

use lang;
use Carbon\Carbon;

class Document extends Model
{
    use TranslateTrait, PermalinkTrait;

    protected $table = 'documents';
    protected $guarded = ['id'];

    const PERATURAN = 1;
    const JURNAL = 2;
    const KLIPING = 3;
    const MAJALAH = 4;
    const PUTUSAN = 5;
    const MONOGRAFI = 6;
    const NASKAH = 7;
    const PERATURAN_TERJEMAHAN = 8;
    const PROGRAM_PENYUSUNAN = 9;
    const NASKAH_AKADEMIK = 10;
    const ANALISIS_EVALUASI = 11;
    const RISALAH_PEMBAHASAN = 12;
    const KAJIAN_HUKUM = 13;
    const PARTISIPASI_PUBLIK = 14;
    const RANCANGAN_PUU = 15;

    const COURT_MA = 'MA';
    const COURT_MK = 'MK';
    const COURT_NEEDS_CLASSIFICATION = 'NEEDS_CLASSIFICATION';

    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class, 'regulasi_id');
    }

    public function getStageLabelAttribute()
    {
        if ($this->regulasi) {
            if ($this->regulasi->status === 'selesai') {
                return 'Selesai';
            }
            if ($this->regulasi->current_stage === 'uji_publik' && $this->regulasi->pasca_partisipasi_dimulai) {
                return 'Pasca Partisipasi Publik';
            }
            $stage = $this->regulasi->current_stage ?: $this->regulasi->status;
            $labels = [
                'pengajuan' => 'Tahap Pengajuan',
                'pembahasan' => 'Tahap Pembahasan',
                'uji_publik' => 'Partisipasi Publik',
                'pasca_partisipasi' => 'Pasca Partisipasi Publik',
                'harmonisasi' => 'Tahap Harmonisasi',
                'penetapan' => 'Tahap Penetapan',
                'proses' => 'Dalam Proses Penyusunan',
                'selesai' => 'Selesai',
            ];
            return $labels[$stage] ?? ('Tahap ' . ucfirst(str_replace('_', ' ', $stage)));
        }
        return 'Dalam Proses Pembentukan';
    }

    public static function courtTypes(bool $includeAll = false)
    {
        $types = [
            self::COURT_MA => 'Mahkamah Agung (MA)',
            self::COURT_MK => 'Mahkamah Konstitusi (MK)',
        ];

        if ($includeAll) {
            $types[self::COURT_NEEDS_CLASSIFICATION] = 'Belum Diklasifikasi';
        }

        return $types;
    }

    public function getCourtLabelAttribute()
    {
        if ($this->court_type === self::COURT_MA) {
            return 'Mahkamah Agung (MA)';
        }
        if ($this->court_type === self::COURT_MK) {
            return 'Mahkamah Konstitusi (MK)';
        }
        if ($this->court_type === self::COURT_NEEDS_CLASSIFICATION) {
            return 'Perlu Klasifikasi (NEEDS_CLASSIFICATION)';
        }
        return $this->translated('jenis_peradilan') ?: ($this->jenis_peradilan ?: '-');
    }

    public function getCourtBadgeAttribute()
    {
        if ($this->court_type === self::COURT_MA) {
            return '<span class="tag tag-ma badge-court-ma" style="background:#e0f2fe; color:#0369a1; font-weight:600; padding:3px 10px; border-radius:12px; font-size:12px; display:inline-block;">Mahkamah Agung (MA)</span>';
        }
        if ($this->court_type === self::COURT_MK) {
            return '<span class="tag tag-mk badge-court-mk" style="background:#fee2e2; color:#b91c1c; font-weight:600; padding:3px 10px; border-radius:12px; font-size:12px; display:inline-block;">Mahkamah Konstitusi (MK)</span>';
        }
        return '<span class="tag tag-needs badge-court-needs" style="background:#fef3c7; color:#92400e; font-weight:600; padding:3px 10px; border-radius:12px; font-size:12px; display:inline-block;">Perlu Klasifikasi</span>';
    }

    const SHARE_FACEBOOK = 'fb';
	const SHARE_LINKEDIN = 'linkedin';
	const SHARE_TWITTER = 'tw';
	const SHARE_WHATSAPP = 'wa';
	const SHARE_INSTAGRAM = 'ig';
    const SHARE_EMAIL = 'email';

    public function share($type)
	{
		$text = '';
		switch (strtolower($type)) {
			case self::SHARE_FACEBOOK:
				$text = 'https://www.facebook.com/sharer/sharer.php?u=' . url($this->permalink_document);
				break;
			case self::SHARE_LINKEDIN:
				$text = 'https://www.linkedin.com/sharing/share-offsite/?url=' . url($this->permalink_document);
				break;
			case self::SHARE_TWITTER:
				$text = 'https://twitter.com/intent/tweet?text=' . url($this->permalink_document);
				break;
			case self::SHARE_WHATSAPP:
				$text = 'https://api.whatsapp.com/send?text=' . url($this->permalink_document);
				break;
			case self::SHARE_INSTAGRAM:
				$text = 'https://www.instagram.com/share?text=' . url($this->permalink_document);
				break;
            case self::SHARE_EMAIL:
                $text = 'mailto:?subject=I wanted you to see this site&body=Check out this ' . url($this->permalink_document);
                break;
		}

		return $text;
	}

    public static function getId($value)
    {
        $constName = strtoupper($value);
        $class = __CLASS__; // atau nama class secara eksplisit

        if (defined("$class::$constName")) {
            return constant("$class::$constName");
        }

        return null; // jika tidak ditemukan
    }

    public function rule_type()
    {
        return $this->belongsTo(RuleType::class, 'rule_type_id');
    }

    public function rule_theme()
    {
        return $this->belongsTo(RuleTheme::class, 'rule_theme_id');
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function master_document()
    {
        return $this->belongsTo(MasterDocument::class, 'master_document_id');
    }

    public function related_document()
    {
        return $this->belongsTo(Document::class, 'related_document_id');
    }

    public function tahapan()
    {
        return $this->belongsTo(StatusProject::class, 'tahapan_puu_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(PublicConsultationFeedback::class, 'document_id');
    }

    public function outgoingRelations()
    {
        return $this->hasMany(\App\Models\DocumentRelation::class, 'source_document_id');
    }

    public function incomingRelations()
    {
        return $this->hasMany(\App\Models\DocumentRelation::class, 'related_document_id');
    }

    /**
     * Get Peraturan Terkait (both outgoing and incoming reciprocal relations where target is regulation)
     */
    public function getPeraturanTerkaitList()
    {
        $list = [];

        // 1. Outgoing relations marked as peraturan_terkait
        $outgoing = $this->outgoingRelations()
            ->with(['relatedDocument.master_document', 'relatedDocument.rule_type'])
            ->where('category', 'peraturan_terkait')
            ->get();

        foreach ($outgoing as $rel) {
            if ($rel->is_external) {
                $list[] = [
                    'id' => $rel->id,
                    'is_external' => true,
                    'document_id' => null,
                    'title' => $rel->external_title,
                    'no_peraturan' => $rel->external_number ?? '-',
                    'year' => $rel->external_year ?? '-',
                    'jenis_peraturan' => $rel->external_category ?? 'Peraturan',
                    'relationship_type' => $rel->relationship_type,
                    'relation_label' => $rel->type_label,
                    'colors' => $rel->type_colors,
                    'permalink' => $rel->external_url,
                    'external_url' => $rel->external_url,
                    'pdf' => null,
                    'direction' => 'outgoing',
                    'note' => $rel->note,
                ];
                continue;
            }
            $doc = $rel->relatedDocument;
            if (!$doc) continue;
            $list[] = [
                'id' => $rel->id,
                'is_external' => false,
                'document_id' => $doc->id,
                'title' => $doc->translated('title') ?: $doc->title,
                'no_peraturan' => $doc->no_peraturan ?? '-',
                'year' => $doc->date ? date('Y', strtotime($doc->date)) : '-',
                'jenis_peraturan' => optional($doc->rule_type)->label ?? optional($doc->master_document)->label ?? 'Peraturan',
                'relationship_type' => $rel->relationship_type,
                'relation_label' => $rel->type_label,
                'colors' => $rel->type_colors,
                'permalink' => $doc->permalink_document,
                'pdf' => $doc->pdf,
                'direction' => 'outgoing',
                'note' => $rel->note,
            ];
        }

        // 2. Incoming relations (reciprocal)
        $incoming = $this->incomingRelations()
            ->with(['sourceDocument.master_document', 'sourceDocument.rule_type'])
            ->where('category', 'peraturan_terkait')
            ->get();

        foreach ($incoming as $rel) {
            $doc = $rel->sourceDocument;
            if (!$doc) continue;
            $reciprocalType = \App\Models\DocumentRelation::getReciprocal($rel->relationship_type);
            $list[] = [
                'id' => $rel->id,
                'document_id' => $doc->id,
                'title' => $doc->translated('title') ?: $doc->title,
                'no_peraturan' => $doc->no_peraturan ?? '-',
                'year' => $doc->date ? date('Y', strtotime($doc->date)) : '-',
                'jenis_peraturan' => optional($doc->rule_type)->label ?? optional($doc->master_document)->label ?? 'Peraturan',
                'relationship_type' => $reciprocalType,
                'relation_label' => \App\Models\DocumentRelation::TYPE_LABELS[$reciprocalType] ?? ucfirst(str_replace('_', ' ', $reciprocalType)),
                'colors' => \App\Models\DocumentRelation::TYPE_COLORS[$reciprocalType] ?? ['bg' => '#f8fafc', 'text' => '#475569', 'border' => '#e2e8f0'],
                'permalink' => $doc->permalink_document,
                'pdf' => $doc->pdf,
                'direction' => 'incoming',
                'note' => $rel->note,
            ];
        }

        // 3. Direct related_document_id column (used on PUU forms)
        if ($this->related_document_id && ($relDoc = $this->related_document)) {
            $already = collect($list)->contains(fn ($r) => ($r['document_id'] ?? null) == $relDoc->id);
            if (!$already) {
                $list[] = [
                    'id' => 'direct_' . $relDoc->id,
                    'is_external' => false,
                    'document_id' => $relDoc->id,
                    'title' => $relDoc->translated('title') ?: $relDoc->title,
                    'no_peraturan' => $relDoc->no_peraturan ?? '-',
                    'year' => $relDoc->year ?: ($relDoc->date ? date('Y', strtotime($relDoc->date)) : '-'),
                    'jenis_peraturan' => optional($relDoc->rule_type)->label ?? optional($relDoc->master_document)->label ?? 'Peraturan',
                    'relationship_type' => 'terkait',
                    'relation_label' => 'Peraturan Terkait',
                    'colors' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#bfdbfe'],
                    'permalink' => $relDoc->permalink_document,
                    'pdf' => $relDoc->pdf,
                    'direction' => 'outgoing',
                    'note' => null,
                ];
            }
        }

        return $list;
    }

    /**
     * Get Dokumen Terkait (cross-category documents)
     */
    public function getDokumenTerkaitList()
    {
        $list = [];

        // 1. Outgoing relations marked as dokumen_terkait
        $outgoing = $this->outgoingRelations()
            ->with(['relatedDocument.master_document', 'relatedDocument.rule_type'])
            ->where('category', 'dokumen_terkait')
            ->get();

        foreach ($outgoing as $rel) {
            if ($rel->is_external) {
                $list[] = [
                    'id' => $rel->id,
                    'is_external' => true,
                    'document_id' => null,
                    'title' => $rel->external_title,
                    'kategori' => $rel->external_category ?? 'Dokumen Eksternal',
                    'nomor' => $rel->external_number ?? '-',
                    'year' => $rel->external_year ?? '-',
                    'relationship_type' => $rel->relationship_type,
                    'relation_label' => $rel->type_label,
                    'colors' => $rel->type_colors,
                    'permalink' => $rel->external_url,
                    'external_url' => $rel->external_url,
                    'pdf' => null,
                    'direction' => 'outgoing',
                    'note' => $rel->note,
                ];
                continue;
            }
            $doc = $rel->relatedDocument;
            if (!$doc) continue;
            $list[] = [
                'id' => $rel->id,
                'is_external' => false,
                'document_id' => $doc->id,
                'title' => $doc->translated('title') ?: $doc->title,
                'kategori' => optional($doc->master_document)->label ?? 'Dokumen Hukum',
                'nomor' => $doc->no_peraturan ?? $doc->nomor_perjanjian ?? $doc->no_putusan ?? '-',
                'year' => $doc->date ? date('Y', strtotime($doc->date)) : '-',
                'relationship_type' => $rel->relationship_type,
                'relation_label' => $rel->type_label,
                'colors' => $rel->type_colors,
                'permalink' => $doc->permalink_document,
                'pdf' => $doc->pdf,
                'direction' => 'outgoing',
                'note' => $rel->note,
            ];
        }

        // 2. Incoming relations marked as dokumen_terkait
        $incoming = $this->incomingRelations()
            ->with(['sourceDocument.master_document', 'sourceDocument.rule_type'])
            ->where('category', 'dokumen_terkait')
            ->get();

        foreach ($incoming as $rel) {
            $doc = $rel->sourceDocument;
            if (!$doc) continue;
            $reciprocalType = \App\Models\DocumentRelation::getReciprocal($rel->relationship_type);
            $list[] = [
                'id' => $rel->id,
                'document_id' => $doc->id,
                'title' => $doc->translated('title') ?: $doc->title,
                'kategori' => optional($doc->master_document)->label ?? 'Dokumen Hukum',
                'nomor' => $doc->no_peraturan ?? $doc->nomor_perjanjian ?? $doc->no_putusan ?? '-',
                'year' => $doc->date ? date('Y', strtotime($doc->date)) : '-',
                'relationship_type' => $reciprocalType,
                'relation_label' => \App\Models\DocumentRelation::TYPE_LABELS[$reciprocalType] ?? ucfirst(str_replace('_', ' ', $reciprocalType)),
                'colors' => \App\Models\DocumentRelation::TYPE_COLORS[$reciprocalType] ?? ['bg' => '#f8fafc', 'text' => '#475569', 'border' => '#e2e8f0'],
                'permalink' => $doc->permalink_document,
                'pdf' => $doc->pdf,
                'direction' => 'incoming',
                'note' => $rel->note,
            ];
        }

        return $list;
    }

    public function getTagColorHomeAttribute()
    {
        $master_document = $this->master_document == null ? null : $this->master_document->id;
        if ($master_document == self::PUTUSAN) {
            return '#091D77';
        } else if ($master_document == self::PERATURAN || $master_document == self::PERATURAN_TERJEMAHAN) {
            return '#091D77';
        } else if (in_array($master_document, [self::KLIPING, self::MAJALAH, self::JURNAL, self::MONOGRAFI])) {
            return '#0086A7';
        } else if (in_array($master_document, [self::NASKAH, self::PROGRAM_PENYUSUNAN, self::NASKAH_AKADEMIK, self::ANALISIS_EVALUASI, self::RISALAH_PEMBAHASAN, self::KAJIAN_HUKUM, self::PARTISIPASI_PUBLIK])) {
            return '#091D77;';
        }
    }

    public function getDisplayStatusBerlakuAttribute()
    {
        if ($this->status_berlaku == 0) {
            return 'Tidak';
        } else if ($this->status_berlaku == 1) {
            return 'Ya';
        }
        return '-';
    }

    public function getFrontStatusBerlakuAttribute()
    {
        if ($this->status_berlaku == 0) {
            return lang::translate('document.status-berlaku.tidak');
        } else if ($this->status_berlaku == 1) {
            return lang::translate('document.status-berlaku.ya');
        }
        return '-';
    }

    public function getFrontStatusTersediaAttribute()
    {
        if ($this->status_tersedia == 0) {
            return lang::translate('document.status-tersedia.tidak');
        } else if ($this->status_tersedia == 1) {
            return lang::translate('document.status-tersedia.ya');
        }
        return '-';
    }

    public function getPermalinkDocumentAttribute()
    {
        $master_document = $this->master_document == null ? null : $this->master_document->id;
        if ($master_document == self::PUTUSAN) {
            $p = $this->customPermalink('document-putusan');
            return $p ?: url('/document-putusan/' . $this->id);
        } else if ($master_document == self::PERATURAN) {
            return $this->customPermalink('document-peraturan');
        } else if ($master_document == self::KLIPING) {
            return $this->customPermalink('document-kliping');
        } else if ($master_document == self::MAJALAH) {
            return $this->customPermalink('document-majalah');
        } else if ($master_document == self::JURNAL) {
            return $this->customPermalink('document-jurnal');
        } else if ($master_document == self::MONOGRAFI) {
            return $this->customPermalink('document-monografi');
        } else if ($master_document == self::NASKAH) {
            return $this->customPermalink('document-naskah');
        } else if ($master_document == self::PERATURAN_TERJEMAHAN) {
            return $this->customPermalink('peraturan-terjemahan');
        } else if ($master_document == self::PROGRAM_PENYUSUNAN) {
            return $this->customPermalink('puu-program-penyusunan') ?: $this->customPermalink('program-penyusunan-puu');
        } else if ($master_document == self::NASKAH_AKADEMIK) {
            return $this->customPermalink('puu-naskah-urgensi') ?: $this->customPermalink('naskah-akademik');
        } else if ($master_document == self::ANALISIS_EVALUASI) {
            return $this->customPermalink('puu-analisis-evaluasi') ?: $this->customPermalink('analisis-evaluasi');
        } else if ($master_document == self::RISALAH_PEMBAHASAN) {
            return $this->customPermalink('puu-risalah') ?: $this->customPermalink('risalah-pembahasan');
        } else if ($master_document == self::KAJIAN_HUKUM) {
            return $this->customPermalink('puu-kajian-hukum') ?: $this->customPermalink('kajian-hukum');
        } else if ($master_document == self::PARTISIPASI_PUBLIK) {
            return $this->customPermalink('puu-partisipasi-publik') ?: $this->customPermalink('partisipasi-publik');
        } else if ($master_document == self::RANCANGAN_PUU) {
            return $this->customPermalink('puu-rancangan');
        }

        $module = \DB::table('permalinks')
            ->where('uniqid', $this->id)
            ->where('module', '!=', 'menu')
            ->value('module');
        if ($module) {
            return $this->customPermalink($module);
        }

        return '';
    }

    public function getApiJenisAttribute()
    {
        return $this->jenis_bentuk_peraturan ?? '-';
        // $master_document = $this->master_document_id;

        // if ($master_document == self::PERATURAN) {
        //     return $this->jenis_bentuk_peraturan;
        // } else {
        //     return '-';
        // }
    }

    public function getApiTahunPengundanganAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            return !$this->tanggal_pengundangan ? '-' : Carbon::parse($this->tanggal_pengundangan)->format('Y');
        } else {
            return '-';
        }
    }

    public function getApiTanggalPengundanganAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            return !$this->tanggal_pengundangan ? '-' : $this->tanggal_pengundangan;
        } else {
            return '-';
        }
    }

    public function getApiNoPeraturanAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            return !$this->no_peraturan ? '-' : $this->no_peraturan;
        } else {
            return '-';
        }
    }

    public function getApiJudulAttribute()
    {
        return $this->title;
    }

    public function getApiNoPanggilAttribute()
    {
        $master_document = $this->master_document_id;

        if (in_array($master_document, [self::MONOGRAFI, self::JURNAL])) {
            return !$this->no_panggil ? '-' : $this->no_panggil;
        } else {
            return '-';
        }
    }

    public function getApiSingkatanJenisAttribute()
    {
        return $this->singkata_jenis_peraturan ?? '-';
    }

    public function getApiTempatTerbitAttribute()
    {
        return $this->tempat_terbit ?? '-';
    }

    public function getApiPenerbitAttribute()
    {
        $master_document = $this->master_document_id;
        if ($master_document == self::MONOGRAFI) {
            return !$this->penerbit ? '-' : $this->penerbit;
        } else {
            return '-';
        }
    }

    public function getApiDeskripsiFisikAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::MONOGRAFI) {
            return !$this->deskripsi_fisik ? '-' : $this->deskripsi_fisik;
        } else {
            return '-';
        }
    }

    public function getApiSumberAttribute()
    {
        return $this->sumber ?? '-';
    }

    public function getApiSubjekAttribute()
    {
        return $this->subjek ?? '-';
    }

    public function getApiStatusAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            if ($this->status_berlaku == 0) {
                return 'tidak berlaku';
            } else if ($this->status_berlaku == 1) {
                return 'masih berlaku';
            }
        } else {
            return '-';
        }
    }

    public function getApiBahasaAttribute()
    {
        return $this->bahasa ?? '-';
    }

    public function getApiBidangHukumAttribute()
    {
        return $this->bidang_hukum ?? '-';
    }

    public function getApiIsbnAttribute()
    {
        return $this->isbn ?? '-';
    }

    public function getApiTeuBadanAttribute()
    {
        return $this->teu ?? '-';
    }

    public function getApiNomorIndukBukuAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::MONOGRAFI) {
            return $this->nomor_induk_buku ?? '';
        } else {
            return '-';
        }
    }

    /**
     * Ambil opsi dropdown Rancangan PUU aktif dari e-Regulasi, unik per judul (tanpa duplikasi).
     */
    public static function rancanganDropdownOptions(): array
    {
        return self::dropdownOptions(self::RANCANGAN_PUU);
    }

    /**
     * Ambil opsi dropdown dokumen untuk form admin, ter-deduplikasi per judul dan urut abjad.
     * Untuk RANCANGAN_PUU hanya mengambil dokumen aktif yang tersinkron dengan tabel regulasi.
     */
    public static function dropdownOptions(array|int $masterIds): array
    {
        $ids = (array) $masterIds;
        $hasRancangan = in_array(self::RANCANGAN_PUU, $ids, true);

        if ($hasRancangan) {
            Regulasi::doesntHave('document')->get()->each->syncToJdihDocument();
        }

        $nonRancanganIds = array_values(array_diff($ids, [self::RANCANGAN_PUU]));

        $docs = self::translate()
            ->with('regulasi')
            ->where(function ($q) use ($hasRancangan, $nonRancanganIds) {
                if ($hasRancangan) {
                    $q->orWhere(function ($rq) {
                        $rq->where('master_document_id', self::RANCANGAN_PUU)
                            ->where('documents.is_active', 1)
                            ->whereNotNull('documents.regulasi_id')
                            ->whereHas('regulasi');
                    });
                }
                if (!empty($nonRancanganIds)) {
                    $q->orWhere(function ($nq) use ($nonRancanganIds) {
                        $nq->whereIn('master_document_id', $nonRancanganIds)
                            ->where('documents.is_active', 1);
                    });
                }
            })
            ->select('documents.*', 'documents_lang.title')
            ->get()
            ->sort(function ($a, $b) {
                $pa = $a->regulasi ? $a->regulasi->stagePriority() : 0;
                $pb = $b->regulasi ? $b->regulasi->stagePriority() : 0;
                if ($pa !== $pb) {
                    return $pb <=> $pa;
                }
                return ($b->updated_at?->timestamp ?? 0) <=> ($a->updated_at?->timestamp ?? 0)
                    ?: ($b->id <=> $a->id);
            });

        $options = [];
        $seenTitles = [];

        foreach ($docs as $doc) {
            $title = trim(preg_replace('/\s+/', ' ', (string) ($doc->title ?? '')));
            if ($title === '') {
                continue;
            }
            $key = mb_strtolower($title);
            if (isset($seenTitles[$key])) {
                continue;
            }
            $seenTitles[$key] = true;
            $options[$doc->id] = $title;
        }

        asort($options, SORT_NATURAL | SORT_FLAG_CASE);

        return $options;
    }

}
