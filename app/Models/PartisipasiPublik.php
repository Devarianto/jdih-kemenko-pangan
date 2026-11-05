<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartisipasiPublik extends Model
{
    protected $table = 'partisipasi_publik';

    protected $fillable = ['regulasi_id', 'tgl_mulai', 'tgl_selesai', 'is_active'];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class);
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }
}