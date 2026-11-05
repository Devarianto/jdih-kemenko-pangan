<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'has_translation')) {
                $table->boolean('has_translation')->default(0)->after('status_tersedia');
            }
            if (!Schema::hasColumn('documents', 'translation_title')) {
                $table->text('translation_title')->nullable()->after('has_translation');
            }
            if (!Schema::hasColumn('documents', 'translation_no_peraturan')) {
                $table->string('translation_no_peraturan', 255)->nullable()->after('translation_title');
            }
            if (!Schema::hasColumn('documents', 'translation_intro')) {
                $table->longText('translation_intro')->nullable()->after('translation_no_peraturan');
            }
            if (!Schema::hasColumn('documents', 'translation_pdf')) {
                $table->string('translation_pdf', 255)->nullable()->after('translation_intro');
            }
            if (!Schema::hasColumn('documents', 'translation_attachment')) {
                $table->string('translation_attachment', 255)->nullable()->after('translation_pdf');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $cols = [
                'has_translation',
                'translation_title',
                'translation_no_peraturan',
                'translation_intro',
                'translation_pdf',
                'translation_attachment'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('documents', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
