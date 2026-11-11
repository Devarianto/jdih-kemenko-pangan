<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CMS Metadata Dinamis.
 * Tabel tambahan (backward compatible): kolom lama pada `documents` tidak diubah.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('metadata_fields')) {
            Schema::create('metadata_fields', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('master_document_id')->index();
                $table->string('key', 60);
                $table->string('label', 150);
                $table->string('label_en', 150)->nullable();
                // text | textarea | number | date | url | select
                $table->string('type', 20)->default('text');
                $table->text('options')->nullable();          // untuk type select, satu opsi per baris
                $table->string('source_column', 60)->nullable(); // pemetaan ke kolom lama pada `documents`
                $table->boolean('is_required')->default(false);
                $table->boolean('show_in_public')->default(true);
                $table->integer('sort_id')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->unique(['master_document_id', 'key']);
            });
        }

        if (!Schema::hasTable('document_metadata_values')) {
            Schema::create('document_metadata_values', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('document_id');
                $table->unsignedBigInteger('field_id');
                $table->longText('value')->nullable();
                $table->timestamps();

                $table->unique(['document_id', 'field_id']);
                $table->index('field_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('document_metadata_values');
        Schema::dropIfExists('metadata_fields');
    }
};

