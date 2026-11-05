<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;

class Gallery extends Model
{
    use TranslateTrait;
    
    protected $table = 'galleries';

    public function classifications()
    {
        return $this->belongsToMany(
            VideoClassification::class,
            'gallery_video_classifications',
            'gallery_id',
            'classification_id'
        )->withTimestamps();
    }

    public function scopeClassifiedAs($query, $code)
    {
        return $query->whereHas('classifications', function ($q) use ($code) {
            $q->where('code', $code);
        });
    }

    public function hasClassification($code): bool
    {
        if ($this->relationLoaded('classifications')) {
            return $this->classifications->contains('code', $code);
        }
        return $this->classifications()->where('code', $code)->exists();
    }

    public function getEmbedUrlAttribute(): string
    {
        return self::formatYoutubeEmbed($this->iframe);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (empty($this->thumbnail)) {
            return '';
        }
        try {
            return \media::initial($this->thumbnail)->url ?? '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    public static function formatYoutubeEmbed(?string $url): string
    {
        if (empty($url)) {
            return '';
        }

        $url = trim($url);

        // If already embed URL, return clean
        if (preg_match('#^https?://(www\.)?youtube\.com/embed/([a-zA-Z0-9_-]+)#i', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[2];
        }

        // youtu.be/ID
        if (preg_match('#youtu\.be/([a-zA-Z0-9_-]+)#i', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // youtube.com/watch?v=ID
        if (preg_match('#[?&]v=([a-zA-Z0-9_-]+)#i', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // youtube.com/shorts/ID
        if (preg_match('#youtube\.com/shorts/([a-zA-Z0-9_-]+)#i', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        return $url;
    }
}
