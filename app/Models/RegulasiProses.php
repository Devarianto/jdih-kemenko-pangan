<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulasiProses extends Model
{
    use HasFactory;

    protected $table = 'regulasi_proses';

    protected $fillable = [
        'regulasi_id',
        'judul',
        'proses',
        'tanggal',
        'file_dokumen',
        'is_after_uji_publik',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_after_uji_publik' => 'boolean',
        'file_dokumen' => 'array',
    ];

    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}