<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataField extends Model
{
    protected $table = 'metadata_fields';
    protected $guarded = [];

    public const TYPES = [
        'text' => 'Teks Singkat',
        'textarea' => 'Teks Panjang',
        'number' => 'Angka',
        'date' => 'Tanggal',
        'url' => 'Tautan (URL)',
        'select' => 'Pilihan (Dropdown)',
    ];

    public function values()
    {
        return $this->hasMany(DocumentMetadataValue::class, 'field_id');
    }

    public function getOptionListAttribute(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) $this->options))));
    }

    public function labelFor(?string $lang = null): string
    {
        $lang = $lang ?: app()->getLocale();
        return ($lang === 'en' && !empty($this->label_en)) ? $this->label_en : $this->label;
    }
}

