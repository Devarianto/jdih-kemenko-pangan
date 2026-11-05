<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    protected $table = 'tanggapan';

    protected $fillable = [
        'regulasi_id',
        'user_id',
        'nama_pengirim',
        'email',
        'tipe',                 // 'masyarakat' atau 'pemerintahan_akademisi'
        'nama_instansi',        // diisi kalau tipe = pemerintahan_akademisi
        'nomor_telepon',
        'isi_tanggapan',
        'is_hidden',
        'status_tindak_lanjut', // 'menunggu', 'ditelaah', 'diterima', 'ditolak'
        'catatan_internal',     // hanya untuk admin (tidak tampil ke publik)
        'tindak_lanjut',        // tanggapan/tindak lanjut tim penyusun
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Label instansi yang ramah tampil, dipakai di badge halaman publik.
     */
    public function getLabelInstansiAttribute(): string
    {
        return match ($this->tipe) {
            'pemerintahan_akademisi' => 'Pemerintahan/Akademisi',
            default => 'Masyarakat',
        };
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status_tindak_lanjut) {
            'ditelaah' => 'Sedang Ditelaah',
            'diterima' => 'Diakomodasi / Diterima',
            'ditolak'  => 'Tidak Diakomodasi',
            default    => 'Menunggu Telaah',
        };
    }

    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
