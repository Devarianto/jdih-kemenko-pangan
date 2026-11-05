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
        // 1. Activate & Update Pengajuan Harmonisasi (Menu ID 26)
        DB::table('menus')->where('id', 26)->update([
            'is_active' => 1,
            'sort_id' => 6,
            'updated_at' => now(),
        ]);

        DB::table('menus_lang')->where('base_id', 26)->where('lang', 'id')->update([
            'label' => 'Pengajuan Harmonisasi',
        ]);
        DB::table('menus_lang')->where('base_id', 26)->where('lang', 'en')->update([
            'label' => 'Submission of Harmonization',
        ]);

        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 26)->update([
            'is_active' => 1,
            'updated_at' => now(),
        ]);

        // 2. Activate & Update Permohonan Pengundangan (Menu ID 28)
        DB::table('menus')->where('id', 28)->update([
            'is_active' => 1,
            'sort_id' => 7,
            'updated_at' => now(),
        ]);

        DB::table('menus_lang')->where('base_id', 28)->where('lang', 'id')->update([
            'label' => 'Permohonan Pengundangan',
        ]);
        DB::table('menus_lang')->where('base_id', 28)->where('lang', 'en')->update([
            'label' => 'Application for Promulgation',
        ]);

        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 28)->update([
            'is_active' => 1,
            'updated_at' => now(),
        ]);

        // 3. Update Anev PUU (Menu ID 33) label & sort
        DB::table('menus_lang')->where('base_id', 33)->where('lang', 'id')->update([
            'label' => 'Anev PUU',
        ]);
        DB::table('menus_lang')->where('base_id', 33)->where('lang', 'en')->update([
            'label' => 'Legislation Analysis & Evaluation (Anev PUU)',
        ]);

        // 4. Update sequence of existing menus under parent 25
        DB::table('menus')->where('id', 30)->update(['sort_id' => 1]); // Rancangan PUU
        DB::table('menus')->where('id', 31)->update(['sort_id' => 2]); // Naskah Urgensi/Akademik
        DB::table('menus')->where('id', 33)->update(['sort_id' => 3]); // Anev PUU
        DB::table('menus')->where('id', 32)->update(['sort_id' => 4]); // Risalah Pembahasan
        DB::table('menus')->where('id', 34)->update(['sort_id' => 5]); // Kajian Hukum
        DB::table('menus')->where('id', 26)->update(['sort_id' => 6]); // Pengajuan Harmonisasi
        DB::table('menus')->where('id', 28)->update(['sort_id' => 7]); // Permohonan Pengundangan
        DB::table('menus')->where('id', 37)->update(['sort_id' => 9]); // Program Penyusunan PUU (preserved)
        DB::table('menus')->where('id', 35)->update(['sort_id' => 10]); // Partisipasi Publik (preserved)

        // 5. Create new submenu: Pengajuan PUU (Menu ID 41)
        $existingPengajuan = DB::table('menus')->where('id', 41)->first();
        if (!$existingPengajuan) {
            DB::table('menus')->insert([
                'id' => 41,
                'parent_id' => 25,
                'type' => 'url',
                'sort_id' => 8,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('menus_lang')->insert([
                [
                    'base_id' => 41,
                    'lang' => 'id',
                    'label' => 'Pengajuan PUU',
                    'url' => '/pengajuan-puu',
                ],
                [
                    'base_id' => 41,
                    'lang' => 'en',
                    'label' => 'PUU Submission',
                    'url' => '/pengajuan-puu',
                ],
            ]);

            DB::table('permalinks')->insert([
                [
                    'module' => 'menu',
                    'uniqid' => 41,
                    'lang' => 'id',
                    'permalink' => 'pengajuan-puu',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module' => 'menu',
                    'uniqid' => 41,
                    'lang' => 'en',
                    'permalink' => 'puu-submission',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        } else {
            DB::table('menus')->where('id', 41)->update([
                'parent_id' => 25,
                'type' => 'url',
                'sort_id' => 8,
                'is_active' => 1,
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permalinks')->where('module', 'menu')->where('uniqid', 41)->delete();
        DB::table('menus_lang')->where('base_id', 41)->delete();
        DB::table('menus')->where('id', 41)->delete();

        DB::table('menus')->where('id', 26)->update(['is_active' => 0]);
        DB::table('menus')->where('id', 28)->update(['is_active' => 0]);
    }
};

