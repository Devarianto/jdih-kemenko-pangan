<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMetadataValue extends Model
{
    protected $table = 'document_metadata_values';
    protected $guarded = [];

    public function field()
    {
        return $this->belongsTo(MetadataField::class, 'field_id');
    }
}

