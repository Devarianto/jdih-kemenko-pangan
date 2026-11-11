<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\MetadataField;
use Illuminate\Database\Seeder;

/**
 * Preset metadata mengikuti JDIH Kemendag.
 * - Jika kolom sudah ada sebagai input di form admin bawaan => dipetakan (source_column), tanpa input ganda.
 * - Jika belum ada => menjadi field dinamis baru (disimpan di document_metadata_values).
 * Aman dijalankan berulang (tidak menimpa field yang sudah ada / sudah diubah admin).
 */
class MetadataFieldSeeder extends Seeder
{
    /** [key, label, label_en, type, kolom/atribut bawaan atau null, options] */
    protected function common(): array
    {
        return [
            ['teu', 'T.E.U Orang/Badan', 'Author / Entity', 'text', 'teu'],
            ['jenis_bentuk', 'Jenis/Bentuk', 'Type / Form', 'text', 'jenis_bentuk_peraturan'],
            ['cetakan_edisi', 'Cetakan/Edisi', 'Edition', 'text', 'edisi'],
            ['tempat_terbit', 'Tempat Terbit', 'Place of Publication', 'text', 'tempat_terbit'],
            ['unit_penanggungjawab', 'Unit Penanggungjawab', 'Responsible Unit', 'text', null],
            ['tahun_terbit', 'Tahun Terbit', 'Year', 'text', 'year'],
            ['deskripsi_fisik', 'Deskripsi Fisik', 'Physical Description', 'text', 'deskripsi_fisik'],
            ['subjek', 'Subjek', 'Subject', 'text', 'subjek'],
            ['bahasa', 'Bahasa', 'Language', 'text', 'bahasa'],
            ['bidang_hukum', 'Bidang Hukum', 'Legal Field', 'text', 'bidang_hukum'],
            ['lokasi', 'Lokasi', 'Location', 'text', 'lokasi'],
        ];
    }

    protected function publikasi(): array
    {
        return [
            ['teu', 'T.E.U Orang/Badan', 'Author / Entity', 'text', 'teu'],
            ['cetakan_edisi', 'Cetakan/Edisi', 'Edition', 'text', 'edisi'],
            ['tempat_terbit', 'Tempat Terbit', 'Place of Publication', 'text', 'tempat_terbit'],
            ['penerbit', 'Penerbit', 'Publisher', 'text', 'penerbit'],
            ['tahun_terbit', 'Tahun Terbit', 'Year', 'text', 'tahun_terbit'],
            ['sumber', 'Sumber', 'Source', 'text', 'sumber'],
            ['subjek', 'Subjek', 'Subject', 'text', 'subjek'],
            ['bahasa', 'Bahasa', 'Language', 'text', 'bahasa'],
            ['bidang_hukum', 'Bidang Hukum', 'Legal Field', 'text', 'bidang_hukum'],
            ['lokasi', 'Lokasi', 'Location', 'text', 'lokasi'],
        ];
    }

    protected function presets(): array
    {
        $anev = array_merge($this->common(), [
            ['tindak_lanjut', 'Tindak Lanjut', 'Follow-up', 'select', null, "Sudah ditindaklanjuti\nBelum ditindaklanjuti"],
            ['peraturan_tindak_lanjut', 'Peraturan Tindak Lanjut', 'Follow-up Regulation', 'text', null],
        ]);

        return [
            Document::PROGRAM_PENYUSUNAN => ['App\Http\Controllers\Admin\Puu\ProgramPenyusunanController', $this->common()],
            Document::NASKAH_AKADEMIK => ['App\Http\Controllers\Admin\Puu\NaskahUrgensiController', $this->common()],
            Document::RANCANGAN_PUU => ['App\Http\Controllers\Admin\Puu\RancanganPuuController', $this->common()],
            Document::ANALISIS_EVALUASI => ['App\Http\Controllers\Admin\Puu\AnalisisEvaluasiController', $anev],
            Document::RISALAH_PEMBAHASAN => ['App\Http\Controllers\Admin\Puu\RisalahPembahasanController', $this->common()],
            Document::KAJIAN_HUKUM => ['App\Http\Controllers\Admin\Puu\KajianHukumController', $this->common()],
            Document::MONOGRAFI => ['App\Http\Controllers\Admin\Document\DocumentMonografiController', array_merge($this->publikasi(), [
                ['no_panggil', 'Nomor Panggil', 'Call Number', 'text', 'no_panggil'],
                ['isbn', 'ISBN/ISSN', 'ISBN/ISSN', 'text', 'isbn'],
                ['nomor_induk_buku', 'Nomor Induk Buku', 'Book Registration No.', 'text', 'nomor_induk_buku'],
            ])],
            Document::JURNAL => ['App\Http\Controllers\Admin\Document\DocumentJurnalController', array_merge($this->publikasi(), [
                ['no_panggil', 'Nomor Panggil', 'Call Number', 'text', 'no_panggil'],
                ['isbn', 'ISBN/ISSN', 'ISBN/ISSN', 'text', 'isbn'],
            ])],
            Document::KLIPING => ['App\Http\Controllers\Admin\Document\DocumentKlipingController', $this->publikasi()],
            Document::MAJALAH => ['App\Http\Controllers\Admin\Document\DocumentMajalahController', $this->publikasi()],
        ];
    }

    public function run(): void
    {
        foreach ($this->presets() as $masterId => [$controller, $rows]) {
            $existing = [];
            try {
                $form = app($controller)->formFields('edit');
                $existing = array_keys($form);
            } catch (\Throwable $e) {
                $this->command?->warn("Form {$controller} tidak terbaca: " . $e->getMessage());
            }

            $sort = 10;
            foreach ($rows as $r) {
                [$key, $label, $labelEn, $type, $col] = $r;
                $options = $r[5] ?? null;
                $sort += 10;

                if (MetadataField::where('master_document_id', $masterId)->where('key', $key)->exists()) {
                    continue;
                }

                // kolom sudah ada di form bawaan => hanya dipetakan untuk tampilan
                $source = ($col && in_array($col, $existing, true)) ? $col : null;
                // kolom bawaan yang tak punya input di form & bukan dinamis tidak bisa diisi => jadikan dinamis
                MetadataField::create([
                    'master_document_id' => $masterId,
                    'key' => $key,
                    'label' => $label,
                    'label_en' => $labelEn,
                    'type' => $type,
                    'options' => $options,
                    'source_column' => $source,
                    'is_required' => 0,
                    'show_in_public' => 1,
                    'sort_id' => $sort,
                    'is_active' => 1,
                ]);
            }
        }
    }
}
