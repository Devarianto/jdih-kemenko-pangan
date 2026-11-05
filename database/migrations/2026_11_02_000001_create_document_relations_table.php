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
        if (!Schema::hasTable('document_relations')) {
            Schema::create('document_relations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('source_document_id');
                $table->unsignedInteger('related_document_id');
                $table->string('relationship_type', 50)->default('terkait');
                $table->enum('category', ['peraturan_terkait', 'dokumen_terkait'])->default('peraturan_terkait');
                $table->text('note')->nullable();
                $table->timestamps();

                $table->foreign('source_document_id')
                      ->references('id')
                      ->on('documents')
                      ->onDelete('cascade');

                $table->foreign('related_document_id')
                      ->references('id')
                      ->on('documents')
                      ->onDelete('cascade');

                $table->unique(
                    ['source_document_id', 'related_document_id', 'relationship_type'], 
                    'doc_rel_unique'
                );

                $table->index('related_document_id', 'doc_rel_related_idx');
                $table->index('category', 'doc_rel_category_idx');
                $table->index('relationship_type', 'doc_rel_type_idx');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_relations');
    }
};

