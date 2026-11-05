<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulasiTahapan extends Model
{
    use HasFactory;

    protected $fillable = [
        'regulasi_id',
        'stage',
        'status',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class);
    }
}
