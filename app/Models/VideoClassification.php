<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoClassification extends Model
{
    protected $table = 'video_classifications';

    protected $fillable = [
        'code',
        'name',
        'description',
        'sort_id',
        'is_active',
    ];

    public function galleries()
    {
        return $this->belongsToMany(
            Gallery::class,
            'gallery_video_classifications',
            'classification_id',
            'gallery_id'
        )->withTimestamps();
    }
}
