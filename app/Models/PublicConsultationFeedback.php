<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicConsultationFeedback extends Model
{
    protected $table = 'public_consultation_feedbacks';

    protected $fillable = [
        'document_id',
        'name',
        'email',
        'phone',
        'institution',
        'feedback',
        'attachment',
        'status',
        'notes',
        'ip_address',
        'user_agent',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
