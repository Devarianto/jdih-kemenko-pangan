<?php

namespace App\Http\Controllers\Admin\Document;

use App\Helpers\DynamicMetadata;
use App\Http\Controllers\Controller;
use App\Models\MasterDocument;
use App\Models\MetadataField;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

/**
 * Pengaturan Metadata (CMS Metadata Dinamis).
 * Admin menentukan baris "Meta | Keterangan" per jenis dokumen.
 */
class MetadataFieldController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    public function listingRes()
    {
        return MetadataField::select();
    }

    public function listingFields()
    {
        return [
            'master_document_id' => 'Jenis Dokumen',
            'label' => 'Label Metadata',
            'type' => 'Tipe Input',
            'is_required' => 'Wajib',
            'show_in_public' => 'Tampil di Website',
            'sort_id' => 'Urutan',
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        switch ($key) {
            case 'master_document_id':
                return e(optional(MasterDocument::find($value))->label ?: '-');
            case 'type':
                return e(MetadataField::TYPES[$value] ?? $value) . ($item->source_column ? ' <span class="badge badge-secondary">kolom bawaan</span>' : '');
            case 'is_required':
            case 'show_in_public':
                return $value ? 'Ya' : 'Tidak';
        }
        return e($value);
    }

    public function listingSearchs()
    {
        return ['label', 'label_en', 'key'];
    }

    public function listingFilters()
    {
        return [
            'master_document_id' => [
                'label' => 'Jenis Dokumen',
                'options' => MasterDocument::orderBy('id')->pluck('label', 'id')->all(),
            ],
        ];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('master_document_id')->orderBy('sort_id')->orderBy('id');
    }

    public function formRes()
    {
        return new MetadataField;
    }

    public function formCallbackBefore($post, $item, $type)
    {
        $main = $post['main'] ?? [];

        if (empty($main['key'])) {
            $main['key'] = $type === 'edit' && $item && $item->key
                ? $item->key
                : DynamicMetadata::makeKey($main['label'] ?? 'field');
        }

        // key harus unik per jenis dokumen
        if ($type === 'create') {
            $base = $main['key'];
            $i = 2;
            while (MetadataField::where('master_document_id', $main['master_document_id'] ?? 0)->where('key', $main['key'])->exists()) {
                $main['key'] = $base . '_' . $i++;
            }
        }

        foreach (['is_required', 'show_in_public', 'is_active'] as $flag) {
            $main[$flag] = !empty($main[$flag]) ? 1 : 0;
        }
        if (!isset($main['sort_id']) || $main['sort_id'] === '') {
            $main['sort_id'] = 0;
        }

        $post['main'] = $main;
        return $post;
    }

    public function formFields($type = 'create')
    {
        return [
            'master_document_id' => [
                'label' => 'Jenis Dokumen',
                'type' => 'select',
                'options' => MasterDocument::orderBy('id')->pluck('label', 'id')->all(),
                'attributes' => ['class' => 'required'],
                'info' => 'Metadata ini muncul pada form & halaman detail jenis dokumen yang dipilih.',
            ],
            'label' => [
                'label' => 'Label (Bahasa Indonesia)',
                'type' => 'text',
                'attributes' => ['class' => 'required'],
                'info' => 'Contoh: Unit Penanggungjawab',
            ],
            'label_en' => [
                'label' => 'Label (English, opsional)',
                'type' => 'text',
                'info' => 'Contoh: Responsible Unit',
            ],
            'type' => [
                'label' => 'Tipe Input',
                'type' => 'select',
                'options' => MetadataField::TYPES,
                'attributes' => ['class' => 'required'],
            ],
            'options' => [
                'label' => 'Pilihan (khusus tipe Pilihan)',
                'type' => 'textarea',
                'attributes' => ['rows' => 4],
                'info' => 'Satu pilihan per baris. Contoh: Sudah ditindaklanjuti / Belum ditindaklanjuti',
            ],
            'is_required' => [
                'label' => 'Wajib diisi?',
                'type' => 'select',
                'options' => [0 => 'Tidak', 1 => 'Ya'],
            ],
            'show_in_public' => [
                'label' => 'Tampilkan di halaman website?',
                'type' => 'select',
                'options' => [1 => 'Ya', 0 => 'Tidak'],
            ],
            'sort_id' => [
                'label' => 'Urutan Tampil',
                'type' => 'text',
                'info' => 'Angka kecil tampil lebih dulu.',
            ],
        ];
    }
}

