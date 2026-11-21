<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartisipasiPublik extends Model
{
    protected $table = 'partisipasi_publik';

    protected $fillable = ['regulasi_id', 'tgl_mulai', 'tgl_selesai', 'is_active', 'masukan_tambahan'];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_active' => 'boolean',
        'masukan_tambahan' => 'integer',
    ];

    /**
     * Hitung total jumlah masukan yang ditampilkan di halaman publik Partisipasi Publik.
     */
    public function displayMasukanCount(?int $visibleRealCount = null): int
    {
        if ($visibleRealCount === null) {
            $visibleRealCount = $this->regulasi
                ? $this->regulasi->tanggapan->where('is_hidden', false)->count()
                : 0;
        }

        return max(0, $visibleRealCount + (int) ($this->masukan_tambahan ?? 0));
    }

    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class);
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }
}