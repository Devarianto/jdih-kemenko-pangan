<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentRelation extends Model
{
    protected $table = 'document_relations';

    protected $fillable = [
        'source_document_id',
        'related_document_id',
        'relationship_type',
        'category',
        'is_external',
        'external_title',
        'external_url',
        'external_number',
        'external_year',
        'external_category',
        'note'
    ];

    protected $casts = [
        'is_external' => 'boolean',
    ];

    /**
     * Relationship Type Constants
     */
    const TYPE_MENGUBAH = 'mengubah';
    const TYPE_DIUBAH_OLEH = 'diubah_oleh';
    const TYPE_MENCABUT = 'mencabut';
    const TYPE_DICABUT_OLEH = 'dicabut_oleh';
    const TYPE_MELAKSANAKAN = 'melaksanakan';
    const TYPE_DILAKSANAKAN_OLEH = 'dilaksanakan_oleh';
    const TYPE_MENETAPKAN = 'menetapkan';
    const TYPE_DITETAPKAN_OLEH = 'ditetapkan_oleh';
    const TYPE_DASAR_HUKUM = 'dasar_hukum';
    const TYPE_MENJADI_DASAR_HUKUM = 'menjadi_dasar_hukum';
    const TYPE_TERKAIT = 'terkait';

    /**
     * Reciprocal relationship mapping
     */
    const RECIPROCAL_MAP = [
        self::TYPE_MENGUBAH => self::TYPE_DIUBAH_OLEH,
        self::TYPE_DIUBAH_OLEH => self::TYPE_MENGUBAH,
        self::TYPE_MENCABUT => self::TYPE_DICABUT_OLEH,
        self::TYPE_DICABUT_OLEH => self::TYPE_MENCABUT,
        self::TYPE_MELAKSANAKAN => self::TYPE_DILAKSANAKAN_OLEH,
        self::TYPE_DILAKSANAKAN_OLEH => self::TYPE_MELAKSANAKAN,
        self::TYPE_MENETAPKAN => self::TYPE_DITETAPKAN_OLEH,
        self::TYPE_DITETAPKAN_OLEH => self::TYPE_MENETAPKAN,
        self::TYPE_DASAR_HUKUM => self::TYPE_MENJADI_DASAR_HUKUM,
        self::TYPE_MENJADI_DASAR_HUKUM => self::TYPE_DASAR_HUKUM,
        self::TYPE_TERKAIT => self::TYPE_TERKAIT,
    ];

    /**
     * Human-readable Indonesian labels
     */
    const TYPE_LABELS = [
        self::TYPE_MENGUBAH => 'Mengubah',
        self::TYPE_DIUBAH_OLEH => 'Diubah Oleh',
        self::TYPE_MENCABUT => 'Mencabut',
        self::TYPE_DICABUT_OLEH => 'Dicabut Oleh',
        self::TYPE_MELAKSANAKAN => 'Melaksanakan',
        self::TYPE_DILAKSANAKAN_OLEH => 'Dilaksanakan Oleh',
        self::TYPE_MENETAPKAN => 'Menetapkan',
        self::TYPE_DITETAPKAN_OLEH => 'Ditetapkan Oleh',
        self::TYPE_DASAR_HUKUM => 'Dasar Hukum',
        self::TYPE_MENJADI_DASAR_HUKUM => 'Menjadi Dasar Hukum',
        self::TYPE_TERKAIT => 'Terkait Lainnya',
    ];

    /**
     * Badge visual color palette for UI display
     */
    const TYPE_COLORS = [
        self::TYPE_MENGUBAH => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#bfdbfe'],
        self::TYPE_DIUBAH_OLEH => ['bg' => '#ecfeff', 'text' => '#0e7490', 'border' => '#a5f3fc'],
        self::TYPE_MENCABUT => ['bg' => '#fef2f2', 'text' => '#b91c1c', 'border' => '#fecaca'],
        self::TYPE_DICABUT_OLEH => ['bg' => '#fff7ed', 'text' => '#c2410c', 'border' => '#fed7aa'],
        self::TYPE_MELAKSANAKAN => ['bg' => '#f0fdf4', 'text' => '#15803d', 'border' => '#bbf7d0'],
        self::TYPE_DILAKSANAKAN_OLEH => ['bg' => '#f0fdfa', 'text' => '#0f766e', 'border' => '#99f6e4'],
        self::TYPE_MENETAPKAN => ['bg' => '#faf5ff', 'text' => '#7e22ce', 'border' => '#e9d5ff'],
        self::TYPE_DITETAPKAN_OLEH => ['bg' => '#eef2ff', 'text' => '#4338ca', 'border' => '#c7d2fe'],
        self::TYPE_DASAR_HUKUM => ['bg' => '#fffbeb', 'text' => '#b45309', 'border' => '#fde68a'],
        self::TYPE_MENJADI_DASAR_HUKUM => ['bg' => '#fefce8', 'text' => '#a16207', 'border' => '#fef08a'],
        self::TYPE_TERKAIT => ['bg' => '#f8fafc', 'text' => '#475569', 'border' => '#e2e8f0'],
    ];

    /**
     * Source Document
     */
    public function sourceDocument(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'source_document_id');
    }

    /**
     * Related Document
     */
    public function relatedDocument(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'related_document_id');
    }

    /**
     * Get label for the relation type
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->relationship_type] ?? ucfirst(str_replace('_', ' ', $this->relationship_type));
    }

    /**
     * Get styling colors for badge
     */
    public function getTypeColorsAttribute(): array
    {
        return self::TYPE_COLORS[$this->relationship_type] ?? ['bg' => '#f8fafc', 'text' => '#475569', 'border' => '#e2e8f0'];
    }

    /**
     * Get reciprocal relationship type
     */
    public static function getReciprocal(string $type): string
    {
        return self::RECIPROCAL_MAP[$type] ?? self::TYPE_TERKAIT;
    }

    /**
     * Synchronize relations for a source document
     *
     * @param int $sourceDocId
     * @param array $regulations Array of internal or external regulation relations
     * @param array $crossDocs Array of internal or external cross-document relations
     */
    public static function syncRelations(int $sourceDocId, array $regulations = [], array $crossDocs = []): void
    {
        if (empty($sourceDocId)) {
            return;
        }

        // Delete existing outgoing relations for this document
        self::where('source_document_id', $sourceDocId)->delete();

        // 1. Insert regulations relations
        $insertedPairs = [];
        foreach ($regulations as $reg) {
            $type = (string) ($reg['relationship_type'] ?? self::TYPE_TERKAIT);
            $note = isset($reg['note']) ? (string)$reg['note'] : null;
            $isExternal = !empty($reg['is_external']) || !empty($reg['external_url']);

            if ($isExternal) {
                $extUrl = trim((string)($reg['external_url'] ?? ''));
                $extTitle = trim((string)($reg['title'] ?? $reg['external_title'] ?? ''));
                if (!empty($extTitle)) {
                    self::create([
                        'source_document_id' => $sourceDocId,
                        'related_document_id' => null,
                        'relationship_type' => $type,
                        'category' => 'peraturan_terkait',
                        'is_external' => true,
                        'external_title' => $extTitle,
                        'external_url' => $extUrl,
                        'external_number' => $reg['no_peraturan'] ?? $reg['external_number'] ?? null,
                        'external_year' => $reg['year'] ?? $reg['external_year'] ?? null,
                        'external_category' => $reg['type_label'] ?? $reg['external_category'] ?? 'Peraturan',
                        'note' => $note
                    ]);
                }
            } else {
                $relatedId = (int) ($reg['related_document_id'] ?? 0);
                if ($relatedId > 0 && $relatedId !== $sourceDocId) {
                    $pairKey = $relatedId . ':' . $type;
                    if (!isset($insertedPairs[$pairKey])) {
                        self::create([
                            'source_document_id' => $sourceDocId,
                            'related_document_id' => $relatedId,
                            'relationship_type' => $type,
                            'category' => 'peraturan_terkait',
                            'is_external' => false,
                            'note' => $note
                        ]);
                        $insertedPairs[$pairKey] = true;
                    }
                }
            }
        }

        // 2. Insert cross-category documents relations
        foreach ($crossDocs as $cd) {
            $type = (string) ($cd['relationship_type'] ?? self::TYPE_TERKAIT);
            $note = isset($cd['note']) ? (string)$cd['note'] : null;
            $isExternal = !empty($cd['is_external']) || !empty($cd['external_url']);

            if ($isExternal) {
                $extUrl = trim((string)($cd['external_url'] ?? ''));
                $extTitle = trim((string)($cd['title'] ?? $cd['external_title'] ?? ''));
                if (!empty($extTitle)) {
                    self::create([
                        'source_document_id' => $sourceDocId,
                        'related_document_id' => null,
                        'relationship_type' => $type,
                        'category' => 'dokumen_terkait',
                        'is_external' => true,
                        'external_title' => $extTitle,
                        'external_url' => $extUrl,
                        'external_number' => $cd['no_peraturan'] ?? $cd['external_number'] ?? null,
                        'external_year' => $cd['year'] ?? $cd['external_year'] ?? null,
                        'external_category' => $cd['category_label'] ?? $cd['external_category'] ?? 'Dokumen',
                        'note' => $note
                    ]);
                }
            } else {
                $relatedId = (int) ($cd['related_document_id'] ?? 0);
                if ($relatedId > 0 && $relatedId !== $sourceDocId) {
                    $pairKey = $relatedId . ':' . $type;
                    if (!isset($insertedPairs[$pairKey])) {
                        self::create([
                            'source_document_id' => $sourceDocId,
                            'related_document_id' => $relatedId,
                            'relationship_type' => $type,
                            'category' => 'dokumen_terkait',
                            'is_external' => false,
                            'note' => $note
                        ]);
                        $insertedPairs[$pairKey] = true;
                    }
                }
            }
        }
    }
}

