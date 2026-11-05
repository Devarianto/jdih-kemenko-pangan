<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ubah kolom meta_title pada tabel meta_datas menjadi VARCHAR(255).
     */
    public function up(): void
    {
        if (Schema::hasTable('meta_datas') && Schema::hasColumn('meta_datas', 'meta_title')) {
            DB::statement("ALTER TABLE `meta_datas` MODIFY `meta_title` VARCHAR(255) NULL DEFAULT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('meta_datas') && Schema::hasColumn('meta_datas', 'meta_title')) {
            DB::statement("ALTER TABLE `meta_datas` MODIFY `meta_title` TEXT NULL DEFAULT NULL");
        }
    }
};

