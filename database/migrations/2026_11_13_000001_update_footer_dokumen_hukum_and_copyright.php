<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Rapikan urutan sort_id menu aktif di bawah Dokumen Hukum (id=11) agar tidak bentrok
        $orderMap = [
            12 => 1, // Peraturan Hukum
            16 => 2, // Putusan Hukum
            15 => 3, // Artikel/Majalah Hukum
            17 => 4, // Monografi Hukum
            18 => 5, // Naskah Kerja Sama
            36 => 6, // Peraturan Terjemahan
        ];

        foreach ($orderMap as $menuId => $sortId) {
            DB::table('menus')
                ->where('id', $menuId)
                ->update(['sort_id' => $sortId]);
        }

        // 2. Pastikan URL menu Peraturan Terjemahan (id=36) mengarah ke route yang aktif
        DB::table('menus_lang')
            ->where('base_id', 36)
            ->where('lang', 'id')
            ->update(['url' => '/peraturan-terjemahan']);

        DB::table('menus_lang')
            ->where('base_id', 36)
            ->where('lang', 'en')
            ->update(['url' => '/translated-regulations']);

        // 3. Pastikan Peraturan Terjemahan (id=36) tampil di footer kolom DOKUMEN HUKUM (foot-left)
        $exists = DB::table('relateds')
            ->where('module', 'menu')
            ->where('related', 'position')
            ->where('related_uniqid', 'foot-left')
            ->where('uniqid', '36')
            ->exists();

        if (!$exists && DB::table('menus')->where('id', 36)->exists()) {
            DB::table('relateds')->insert([
                'uniqid' => '36',
                'module' => 'menu',
                'related' => 'position',
                'related_uniqid' => 'foot-left',
            ]);
        }

        // 4. Perbaiki credit/copyright di site-setting (hilangkan karakter rusak dan lengkapi nama instansi)
        DB::table('configs')
            ->where('module', 'site-setting')
            ->where('key', 'copyright')
            ->update([
                'val' => 'Copyright © [year] Kementerian Koordinator Bidang Pangan. All Rights Reserved.',
            ]);
    }

    public function down(): void
    {
        DB::table('relateds')
            ->where('module', 'menu')
            ->where('related', 'position')
            ->where('related_uniqid', 'foot-left')
            ->where('uniqid', '36')
            ->delete();
    }
};
