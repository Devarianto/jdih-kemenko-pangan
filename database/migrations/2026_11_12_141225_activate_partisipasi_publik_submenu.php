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
        // 1. Activate Menu ID 35 (Partisipasi Publik) under Dokumen Pembentukan PUU (parent_id: 25)
        DB::table('menus')->where('id', 35)->update([
            'parent_id'  => 25,
            'is_active'  => 1,
            'type'       => 'url',
            'sort_id'    => 7,
            'updated_at' => now(),
        ]);

        DB::table('menus_lang')->updateOrInsert(
            ['base_id' => 35, 'lang' => 'id'],
            ['label' => 'Partisipasi Publik', 'url' => '/partisipasi-publik']
        );

        DB::table('menus_lang')->updateOrInsert(
            ['base_id' => 35, 'lang' => 'en'],
            ['label' => 'Public Participation', 'url' => '/partisipasi-publik']
        );

        // 2. Ensure Menu ID 37 (Program Penyusunan PUU) has type 'url' so fullUrl resolves correctly to /program-penyusunan-puu
        DB::table('menus')->where('id', 37)->update([
            'type'       => 'url',
            'updated_at' => now(),
        ]);

        DB::table('menus_lang')->updateOrInsert(
            ['base_id' => 37, 'lang' => 'id'],
            ['label' => 'Program Penyusunan PUU', 'url' => '/program-penyusunan-puu']
        );

        DB::table('menus_lang')->updateOrInsert(
            ['base_id' => 37, 'lang' => 'en'],
            ['label' => 'Legislation Drafting Program', 'url' => '/program-penyusunan-puu']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('menus')->where('id', 35)->update([
            'is_active'  => 0,
            'updated_at' => now(),
        ]);
    }
};
