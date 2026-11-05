<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Program Penyusunan PUU (Menu ID 37) -> Sort 1, Active 1
        DB::table('menus')->where('id', 37)->update([
            'sort_id' => 1,
            'is_active' => 1,
            'type' => 'url',
            'updated_at' => now(),
        ]);
        DB::table('menus_lang')->where('base_id', 37)->where('lang', 'id')->update([
            'label' => 'Program Penyusunan PUU',
            'url' => '/program-penyusunan-puu',
        ]);
        DB::table('menus_lang')->where('base_id', 37)->where('lang', 'en')->update([
            'label' => 'Legislation Drafting Program',
            'url' => '/program-penyusunan-puu',
        ]);

        // 2. Rancangan PUU (Menu ID 30) -> Sort 2, Active 1
        DB::table('menus')->where('id', 30)->update([
            'sort_id' => 2,
            'is_active' => 1,
            'type' => 'rancangan-puu',
            'updated_at' => now(),
        ]);
        DB::table('menus_lang')->where('base_id', 30)->where('lang', 'id')->update([
            'label' => 'Rancangan PUU',
        ]);
        DB::table('menus_lang')->where('base_id', 30)->where('lang', 'en')->update([
            'label' => 'Draft Legislation',
        ]);

        // 3. Naskah Urgensi/Akademik (Menu ID 31) -> Sort 3, Active 1
        DB::table('menus')->where('id', 31)->update([
            'sort_id' => 3,
            'is_active' => 1,
            'type' => 'about',
            'updated_at' => now(),
        ]);
        DB::table('menus_lang')->where('base_id', 31)->where('lang', 'id')->update([
            'label' => 'Naskah Urgensi/Akademik',
        ]);
        DB::table('menus_lang')->where('base_id', 31)->where('lang', 'en')->update([
            'label' => 'Urgency/Academic Papers',
        ]);

        // 4. Analisis Evaluasi PUU (Menu ID 33) -> Sort 4, Active 1 (Renamed from Anev PUU)
        DB::table('menus')->where('id', 33)->update([
            'sort_id' => 4,
            'is_active' => 1,
            'type' => 'about',
            'updated_at' => now(),
        ]);
        DB::table('menus_lang')->where('base_id', 33)->where('lang', 'id')->update([
            'label' => 'Analisis Evaluasi PUU',
        ]);
        DB::table('menus_lang')->where('base_id', 33)->where('lang', 'en')->update([
            'label' => 'PUU Analysis and Evaluation',
        ]);
        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 33)->where('lang', 'id')->update([
            'label' => 'Analisis Evaluasi PUU',
        ]);
        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 33)->where('lang', 'en')->update([
            'label' => 'PUU Analysis and Evaluation',
        ]);

        // 5. Risalah Pembahasan (Menu ID 32) -> Sort 5, Active 1
        DB::table('menus')->where('id', 32)->update([
            'sort_id' => 5,
            'is_active' => 1,
            'type' => 'about',
            'updated_at' => now(),
        ]);
        DB::table('menus_lang')->where('base_id', 32)->where('lang', 'id')->update([
            'label' => 'Risalah Pembahasan',
        ]);
        DB::table('menus_lang')->where('base_id', 32)->where('lang', 'en')->update([
            'label' => 'Minutes of Deliberation',
        ]);

        // 6. Kajian Hukum (Menu ID 34) -> Sort 6, Active 1
        DB::table('menus')->where('id', 34)->update([
            'sort_id' => 6,
            'is_active' => 1,
            'type' => 'about',
            'updated_at' => now(),
        ]);
        DB::table('menus_lang')->where('base_id', 34)->where('lang', 'id')->update([
            'label' => 'Kajian Hukum',
        ]);
        DB::table('menus_lang')->where('base_id', 34)->where('lang', 'en')->update([
            'label' => 'Legal Studies',
        ]);

        // 7. Partisipasi Publik (Menu ID 35) -> Sort 7, Active 1
        DB::table('menus')->where('id', 35)->update([
            'sort_id' => 7,
            'is_active' => 1,
            'type' => 'url',
            'updated_at' => now(),
        ]);
        DB::table('menus_lang')->where('base_id', 35)->where('lang', 'id')->update([
            'label' => 'Partisipasi Publik',
            'url' => 'https://regulasikemenkopangan.id/',
        ]);
        DB::table('menus_lang')->where('base_id', 35)->where('lang', 'en')->update([
            'label' => 'Public Participation',
            'url' => 'https://regulasikemenkopangan.id/',
        ]);

        // Deactivate menus that are NOT part of the Dokumen Pembentukan PUU structure
        // Menu 26: Pengajuan Harmonisasi
        DB::table('menus')->where('id', 26)->update(['is_active' => 0, 'updated_at' => now()]);
        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 26)->update(['is_active' => 0]);

        // Menu 28: Permohonan Pengundangan
        DB::table('menus')->where('id', 28)->update(['is_active' => 0, 'updated_at' => now()]);
        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 28)->update(['is_active' => 0]);

        // Menu 41: Pengajuan PUU
        DB::table('menus')->where('id', 41)->update(['is_active' => 0, 'updated_at' => now()]);
        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 41)->update(['is_active' => 0]);

        // Menu 23: Rancangan Peraturan (already inactive)
        DB::table('menus')->where('id', 23)->update(['is_active' => 0, 'updated_at' => now()]);
        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 23)->update(['is_active' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert Analisis Evaluasi PUU label back to Anev PUU
        DB::table('menus_lang')->where('base_id', 33)->where('lang', 'id')->update([
            'label' => 'Anev PUU',
        ]);
        DB::table('menus_lang')->where('base_id', 33)->where('lang', 'en')->update([
            'label' => 'Legislation Analysis & Evaluation (Anev PUU)',
        ]);
    }
};

