<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulasi extends Model
{
    use HasFactory;

    protected $table = 'regulasi';

    protected $fillable = [
        'jenis',
        'judul',
        'abstrak',
        'tgl_usulan',
        'file_permohonan',
        'file_draft',
        'unit_kerja',
        'created_by',
        'status',
        'current_stage',
        'uji_publik_status',
        'pasca_partisipasi_dimulai',
        'tgl_mulai_harmonisasi',
        'tgl_selesai_harmonisasi',
        'catatan_harmonisasi',
        'tgl_mulai_penetapan',
        'tgl_selesai_penetapan',
        'catatan_penetapan',
    ];

    protected $casts = [
        'tgl_usulan' => 'date',
        'pasca_partisipasi_dimulai' => 'boolean',
        'tgl_mulai_harmonisasi' => 'date',
        'tgl_selesai_harmonisasi' => 'date',
        'tgl_mulai_penetapan' => 'date',
        'tgl_selesai_penetapan' => 'date',
    ];

    // Urutan tahap dipakai untuk render step navigation & cek "sudah lewat tahap mana"
    public const STAGES = [
        'pengajuan',
        'pembahasan',
        'uji_publik',
        'harmonisasi',
        'penetapan',
    ];

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tahapans()
    {
        return $this->hasMany(RegulasiTahapan::class)->orderBy('created_at');
    }

    public function proses()
    {
        return $this->hasMany(RegulasiProses::class)->orderBy('tanggal');
    }

    public function partisipasiPublik()
    {
        return $this->hasOne(PartisipasiPublik::class);
    }

    public function document()
    {
        return $this->hasOne(Document::class, 'regulasi_id');
    }

    public function syncToJdihDocument()
    {
        $doc = Document::firstOrNew(['regulasi_id' => $this->id]);
        $doc->master_document_id = Document::RANCANGAN_PUU;
        $doc->date = $this->tgl_usulan ? $this->tgl_usulan->format('Y-m-d') : $this->created_at->format('Y-m-d');
        $doc->year = $this->tgl_usulan ? $this->tgl_usulan->format('Y') : $this->created_at->format('Y');
        $doc->pdf = $this->file_draft ?: $this->file_permohonan;
        $doc->is_active = 1;
        $doc->status_berlaku = 1;
        $doc->created_at = $this->created_at ?: now();
        $doc->updated_at = $this->updated_at ?: now();
        $doc->save();

        $unit = $this->unit_kerja ?: (optional($this->pemohon)->name ?? 'Kementerian Koordinator Bidang Pangan');
        foreach (['id', 'en'] as $lang) {
            \DB::table('documents_lang')->updateOrInsert(
                ['base_id' => $doc->id, 'lang' => $lang],
                [
                    'title' => $this->judul,
                    'intro' => $this->abstrak,
                    'unit_pemrakarsa' => $unit,
                    'pdf_name' => $doc->pdf ? basename($doc->pdf) : null
                ]
            );
        }

        $slug = \Illuminate\Support\Str::limit(\Illuminate\Support\Str::slug($this->judul), 210, '');
        foreach (['id', 'en'] as $lang) {
            \DB::table('permalinks')->updateOrInsert(
                ['module' => 'puu-rancangan', 'uniqid' => $doc->id, 'lang' => $lang],
                [
                    'permalink' => $slug . ($lang === 'en' ? '-en' : '') . '-' . $doc->id,
                    'label' => \Illuminate\Support\Str::limit($this->judul, 250, ''),
                    'description' => $this->abstrak,
                    'is_active' => 1
                ]
            );
        }

        return $doc;
    }

    /**
     * Kumpulkan semua path file fisik (disk 'public') milik regulasi ini dan seluruh prosesnya.
     */
    public function collectPublicStorageFiles(): array
    {
        $paths = [];
        if (!empty($this->file_permohonan)) {
            $paths[] = $this->file_permohonan;
        }
        if (!empty($this->file_draft)) {
            $paths[] = $this->file_draft;
        }

        foreach ($this->proses()->get(['file_dokumen']) as $proses) {
            foreach ((array) $proses->file_dokumen as $file) {
                if (!empty($file) && is_string($file)) {
                    $paths[] = $file;
                }
            }
        }

        return array_values(array_unique($paths));
    }

    /**
     * Hapus entri Rancangan PUU di JDIH publik (documents, documents_lang, permalinks, relasi/metadata)
     * yang tersinkron dengan regulasi ini.
     */
    public function deleteSyncedJdihDocuments(): void
    {
        $docs = Document::where('regulasi_id', $this->id)->get();
        foreach ($docs as $doc) {
            \DB::table('permalinks')
                ->where('module', 'puu-rancangan')
                ->where('uniqid', (string) $doc->id)
                ->delete();

            \DB::table('documents_lang')
                ->where('base_id', $doc->id)
                ->delete();

            \DB::table('document_metadata_values')
                ->where('document_id', $doc->id)
                ->delete();

            \DB::table('document_relations')
                ->where('source_document_id', $doc->id)
                ->orWhere('related_document_id', $doc->id)
                ->delete();

            $doc->delete();
        }
    }

    protected static function booted()
    {
        static::saved(function ($regulasi) {
            try {
                $regulasi->syncToJdihDocument();
            } catch (\Throwable $e) {}
        });

        static::deleting(function ($regulasi) {
            $regulasi->deleteSyncedJdihDocuments();
        });
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }

    public function getStageIndex(): int
    {
        return array_search($this->current_stage, self::STAGES) ?: 0;
    }

    public function isStageCompleted(string $stage): bool
    {
        $stageIndex = array_search($stage, self::STAGES);
        return $stageIndex !== false && $stageIndex < $this->getStageIndex();
    }

    public function isStageActive(string $stage): bool
    {
        return $this->current_stage === $stage;
    }

    /**
     * True kalau regulasi masih di tahap Uji Publik TAPI periode partisipasi publiknya
     * (tgl_selesai) sudah lewat dari hari ini. Dipakai untuk auto-transisi ke Harmonisasi.
     */
    public function isUjiPublikKedaluwarsa(): bool
    {
        if ($this->current_stage !== 'uji_publik') {
            return false;
        }

        if (!$this->partisipasiPublik || !$this->partisipasiPublik->tgl_selesai) {
            return false;
        }

        return \Carbon\Carbon::parse($this->partisipasiPublik->tgl_selesai)->lt(now()->startOfDay());
    }
}