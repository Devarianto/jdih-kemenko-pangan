<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tanggapan')) {
            Schema::table('tanggapan', function (Blueprint $table) {
                if (!Schema::hasColumn('tanggapan', 'status_tindak_lanjut')) {
                    $table->string('status_tindak_lanjut', 50)->default('menunggu')->after('is_hidden');
                }
                if (!Schema::hasColumn('tanggapan', 'catatan_internal')) {
                    $table->text('catatan_internal')->nullable()->after('status_tindak_lanjut');
                }
                if (!Schema::hasColumn('tanggapan', 'tindak_lanjut')) {
                    $table->text('tindak_lanjut')->nullable()->after('catatan_internal');
                }
                if (!Schema::hasColumn('tanggapan', 'reviewed_by')) {
                    $table->unsignedInteger('reviewed_by')->nullable()->after('tindak_lanjut');
                }
                if (!Schema::hasColumn('tanggapan', 'reviewed_at')) {
                    $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tanggapan')) {
            Schema::table('tanggapan', function (Blueprint $table) {
                $cols = [];
                foreach (['status_tindak_lanjut', 'catatan_internal', 'tindak_lanjut', 'reviewed_by', 'reviewed_at'] as $col) {
                    if (Schema::hasColumn('tanggapan', $col)) {
                        $cols[] = $col;
                    }
                }
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }
    }
};

