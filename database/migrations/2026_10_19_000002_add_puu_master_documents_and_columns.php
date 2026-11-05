<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Seed Master Documents for PUU
        $masterDocs = [
            8 => 'Peraturan Terjemahan',
            9 => 'Program Penyusunan PUU',
            10 => 'Naskah Urgensi / Akademik',
            11 => 'Analisis Evaluasi PUU',
            12 => 'Risalah Pembahasan',
            13 => 'Kajian Hukum',
            14 => 'Partisipasi Publik',
            15 => 'Rancangan PUU',
        ];

        foreach ($masterDocs as $id => $label) {
            $exists = DB::table('master_documents')->where('id', $id)->first();
            if (!$exists) {
                DB::table('master_documents')->insert([
                    'id' => $id,
                    'label' => $label,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('master_documents')->where('id', $id)->update([
                    'label' => $label,
                    'is_active' => 1,
                    'updated_at' => now(),
                ]);
            }
        }

        // 2. Add PUU Specific Columns to documents table
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'related_document_id')) {
                $table->unsignedInteger('related_document_id')->nullable()->after('master_document_id');
            }
            if (!Schema::hasColumn('documents', 'tahapan_puu_id')) {
                $table->unsignedBigInteger('tahapan_puu_id')->nullable()->after('related_document_id');
            }
            if (!Schema::hasColumn('documents', 'tanggal_mulai')) {
                $table->date('tanggal_mulai')->nullable()->after('tanggal_berakhir');
            }
            if (!Schema::hasColumn('documents', 'tanggal_selesai')) {
                $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
            }
            if (!Schema::hasColumn('documents', 'status_konsultasi')) {
                $table->string('status_konsultasi', 50)->nullable()->after('tanggal_selesai');
            }
            if (!Schema::hasColumn('documents', 'status_harmonisasi')) {
                $table->string('status_harmonisasi', 100)->nullable()->after('status_konsultasi');
            }
            if (!Schema::hasColumn('documents', 'periode_perencanaan')) {
                $table->string('periode_perencanaan', 100)->nullable()->after('status_harmonisasi');
            }
            if (!Schema::hasColumn('documents', 'periode_evaluasi')) {
                $table->string('periode_evaluasi', 100)->nullable()->after('periode_perencanaan');
            }
        });

        // 3. Add PUU Specific Columns to documents_lang table
        Schema::table('documents_lang', function (Blueprint $table) {
            if (!Schema::hasColumn('documents_lang', 'unit_pemrakarsa')) {
                $table->string('unit_pemrakarsa', 255)->nullable()->after('teu');
            }
            if (!Schema::hasColumn('documents_lang', 'rekomendasi')) {
                $table->text('rekomendasi')->nullable()->after('status_peraturan');
            }
            if (!Schema::hasColumn('documents_lang', 'metode_evaluasi')) {
                $table->text('metode_evaluasi')->nullable()->after('rekomendasi');
            }
            if (!Schema::hasColumn('documents_lang', 'kesimpulan')) {
                $table->text('kesimpulan')->nullable()->after('metode_evaluasi');
            }
            if (!Schema::hasColumn('documents_lang', 'panduan_masukan')) {
                $table->text('panduan_masukan')->nullable()->after('kesimpulan');
            }
        });

        // 4. Register Privileges for Admin (privilege_id: 1)
        $modules = [
            'puu-program-penyusunan',
            'puu-naskah-urgensi',
            'puu-rancangan',
            'puu-risalah',
            'puu-analisis-evaluasi',
            'puu-kajian-hukum',
            'puu-partisipasi-publik',
        ];

        $actions = ['index', 'create', 'edit', 'delete', 'publish', 'download', 'feedback', 'feedback-detail', 'update-feedback'];

        foreach ($modules as $mod) {
            foreach ($actions as $act) {
                $privExists = DB::table('module_privileges')
                    ->where('privilege_id', 1)
                    ->where('module', $mod)
                    ->where('act', $act)
                    ->exists();

                if (!$privExists) {
                    DB::table('module_privileges')->insert([
                        'privilege_id' => 1,
                        'module' => $mod,
                        'act' => $act,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop added columns safely if needed
        Schema::table('documents', function (Blueprint $table) {
            $cols = ['related_document_id', 'tahapan_puu_id', 'tanggal_mulai', 'tanggal_selesai', 'status_konsultasi', 'status_harmonisasi', 'periode_perencanaan', 'periode_evaluasi'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('documents', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('documents_lang', function (Blueprint $table) {
            $cols = ['unit_pemrakarsa', 'rekomendasi', 'metode_evaluasi', 'kesimpulan', 'panduan_masukan'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('documents_lang', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
