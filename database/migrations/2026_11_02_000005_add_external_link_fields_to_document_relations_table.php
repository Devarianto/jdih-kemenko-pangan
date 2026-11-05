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
        if (Schema::hasTable('document_relations')) {
            DB::statement("ALTER TABLE document_relations MODIFY related_document_id INT(10) UNSIGNED NULL");

            Schema::table('document_relations', function (Blueprint $table) {
                if (!Schema::hasColumn('document_relations', 'is_external')) {
                    $table->boolean('is_external')->default(false)->after('category');
                    $table->text('external_title')->nullable()->after('is_external');
                    $table->text('external_url')->nullable()->after('external_title');
                    $table->string('external_number', 100)->nullable()->after('external_url');
                    $table->string('external_year', 20)->nullable()->after('external_number');
                    $table->string('external_category', 100)->nullable()->after('external_year');
                    
                    $table->index('is_external', 'doc_rel_external_idx');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('document_relations')) {
            Schema::table('document_relations', function (Blueprint $table) {
                if (Schema::hasColumn('document_relations', 'is_external')) {
                    $table->dropIndex('doc_rel_external_idx');
                    $table->dropColumn([
                        'is_external',
                        'external_title',
                        'external_url',
                        'external_number',
                        'external_year',
                        'external_category'
                    ]);
                }
            });
            DB::statement("ALTER TABLE document_relations MODIFY related_document_id INT(10) UNSIGNED NOT NULL");
        }
    }
};

