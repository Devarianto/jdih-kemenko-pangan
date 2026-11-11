<?php

namespace App\Helpers;

use App\Models\MetadataField;
use App\Models\DocumentMetadataValue;
use Illuminate\Support\Facades\Schema;

/**
 * CMS Metadata Dinamis.
 *
 * - Field didefinisikan admin di menu "Pengaturan Metadata" (tabel metadata_fields).
 * - Field TANPA source_column disimpan di document_metadata_values (input di form dokumen).
 * - Field DENGAN source_column hanya dipetakan ke kolom/atribut lama (input sudah ada di form
 *   bawaan), sehingga tidak ada input ganda dan data lama tetap dipakai.
 */
class DynamicMetadata
{
    public static function ready(): bool
    {
        static $ready = null;
        if ($ready === null) {
            try {
                $ready = Schema::hasTable('metadata_fields') && Schema::hasTable('document_metadata_values');
            } catch (\Throwable $e) {
                $ready = false;
            }
        }
        return $ready;
    }

    /** Field aktif untuk satu jenis dokumen, terurut. */
    public static function fields(int $masterId)
    {
        if (!self::ready()) {
            return collect();
        }
        return MetadataField::where('master_document_id', $masterId)
            ->where('is_active', 1)
            ->orderBy('sort_id')
            ->orderBy('id')
            ->get();
    }

    /** Field yang diinput lewat widget form (tidak punya source_column). */
    public static function editableFields(int $masterId)
    {
        return self::fields($masterId)->filter(fn ($f) => empty($f->source_column))->values();
    }

    /** Sisipkan widget ke form admin (sebelum blok 'meta'). */
    public static function inject(array $form, int $masterId): array
    {
        if (!self::ready()) {
            return $form;
        }

        $hasEditable = self::editableFields($masterId)->isNotEmpty();
        $needsRelations = !isset($form['relations']);

        $metaWidget = $hasEditable ? [
            'type' => 'free',
            'html' => function ($res) use ($masterId) {
                return view('admin.document.dynamic-metadata-widget', [
                    'fields' => self::editableFields($masterId),
                    'values' => self::values($res),
                ])->render();
            },
        ] : null;

        $relWidget = $needsRelations ? [
            'type' => 'free',
            'html' => function ($res) {
                return view('admin.document.relations-widget', ['res' => $res])->render();
            },
        ] : null;

        $out = [];
        $placed = false;
        foreach ($form as $k => $v) {
            if (!$placed && $k === 'meta') {
                if ($metaWidget) {
                    $out['dynamic_metadata'] = $metaWidget;
                }
                if ($relWidget) {
                    $out['relations'] = $relWidget;
                }
                $placed = true;
            }
            $out[$k] = $v;
        }
        if (!$placed) {
            if ($metaWidget) {
                $out['dynamic_metadata'] = $metaWidget;
            }
            if ($relWidget) {
                $out['relations'] = $relWidget;
            }
        }
        return $out;
    }

    /** Nilai tersimpan: [field_id => value]. */
    public static function values($document): array
    {
        if (!self::ready() || !$document || empty($document->id)) {
            return [];
        }
        return DocumentMetadataValue::where('document_id', $document->id)->pluck('value', 'field_id')->all();
    }

    /** Simpan input form (dm[field_id]) untuk dokumen. */
    public static function save($document, $input = null): void
    {
        if (!self::ready() || !$document || empty($document->id)) {
            return;
        }
        $input = $input ?? request()->input('dm');
        if (!is_array($input)) {
            return;
        }

        $allowed = MetadataField::where('master_document_id', $document->master_document_id)
            ->whereNull('source_column')
            ->pluck('id')
            ->all();

        foreach ($input as $fieldId => $value) {
            $fieldId = (int) $fieldId;
            if (!in_array($fieldId, $allowed, true)) {
                continue;
            }
            $value = is_string($value) ? trim($value) : $value;
            if ($value === '' || $value === null) {
                DocumentMetadataValue::where('document_id', $document->id)->where('field_id', $fieldId)->delete();
                continue;
            }
            DocumentMetadataValue::updateOrCreate(
                ['document_id' => $document->id, 'field_id' => $fieldId],
                ['value' => is_array($value) ? json_encode($value) : (string) $value]
            );
        }
    }

    /**
     * Baris metadata untuk halaman publik.
     * @return array<int, array{key:string,label:string,value:string,type:string,html:bool}>
     */
    public static function publicRows($document, ?string $lang = null, bool $dynamicOnly = false): array
    {
        if (!self::ready() || !$document) {
            return [];
        }
        $masterId = (int) $document->master_document_id;
        $values = self::values($document);
        $rows = [];

        foreach (self::fields($masterId) as $f) {
            if (!$f->show_in_public) {
                continue;
            }
            if ($dynamicOnly && $f->source_column) {
                continue;
            }
            $raw = $f->source_column
                ? ($document->{$f->source_column} ?? null)
                : ($values[$f->id] ?? null);

            $raw = is_scalar($raw) ? trim((string) $raw) : '';
            $rows[] = [
                'key' => $f->key,
                'label' => $f->labelFor($lang),
                'value' => $raw === '' ? '-' : self::format($f->type, $raw),
                'type' => $f->type,
                'html' => $raw !== '' && $f->type === 'url',
            ];
        }
        return $rows;
    }

    /**
     * Jenis dokumen yang tabel metadata publiknya dirender PENUH dari CMS.
     * (Peraturan, Putusan, Naskah Kerja Sama tetap memakai baris statis + tambahan field dinamis.)
     */
    public const CMS_DRIVEN = [2, 3, 4, 6, 9, 10, 11, 12, 13, 15];

    /** True bila baris statis di view harus diganti baris dari CMS. */
    public static function replacesStatic($document): bool
    {
        if (!self::ready() || !$document) {
            return false;
        }
        $masterId = (int) $document->master_document_id;
        return in_array($masterId, self::CMS_DRIVEN, true)
            && self::fields($masterId)->contains(fn ($f) => $f->show_in_public);
    }

    protected static function format(string $type, string $raw): string
    {
        switch ($type) {
            case 'date':
                $ts = strtotime($raw);
                return $ts ? date('d-m-Y', $ts) : e($raw);
            case 'url':
                $u = e($raw);
                return '<a href="' . $u . '" target="_blank" rel="noopener noreferrer">' . $u . '</a>';
            default:
                return e($raw);
        }
    }

    /** Nama kunci dari label (slug snake_case). */
    public static function makeKey(string $label): string
    {
        $k = strtolower(preg_replace('/[^A-Za-z0-9]+/', '_', $label));
        return trim($k, '_') ?: 'field';
    }
}
