<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('partisipasi_publik', 'masukan_tambahan')) {
            Schema::table('partisipasi_publik', function (Blueprint $table) {
                $table->integer('masukan_tambahan')->default(0)->after('is_active');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('partisipasi_publik', 'masukan_tambahan')) {
            Schema::table('partisipasi_publik', function (Blueprint $table) {
                $table->dropColumn('masukan_tambahan');
            });
        }
    }
};
