<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Cactuar\Admin\CactuarBlueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        CactuarBlueprint::schema()->create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_type_id')->nullable();
            $table->foreign('document_type_id')
                ->references('id')
                ->on('document_types')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unsignedInteger('rule_type_id')->nullable();
            $table->foreign('rule_type_id')
                ->references('id')
                ->on('rule_types')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unsignedInteger('rule_theme_id')->nullable();
            $table->foreign('rule_theme_id')
                ->references('id')
                ->on('rule_themes')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->unsignedInteger('master_document_id');
            $table->foreign('master_document_id')
                ->references('id')
                ->on('master_documents')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->text('thumbnail')->nullable();
            $table->text('image')->nullable();
            $table->date('date')->nullable();
            $table->integer('year')->nullable();

            $table->string('no_peraturan')->nullable();
            $table->text('tempat_penetapan')->nullable();
            $table->date('tanggal_penetapan')->nullable();
            $table->date('tanggal_pengundangan')->nullable();
            $table->text('lokasi')->nullable();
            $table->smallInteger('status_berlaku')->nullable(); // 0 => No, 1 => Yes
            
            $table->string('no_panggil')->nullable();
            $table->text('tempat_terbit')->nullable();
            $table->string('penerbit')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->string('isbn')->nullable();
            $table->string('nomor_induk_buku')->nullable();
            $table->smallInteger('status_tersedia')->nullable(); // 0 => No, 1 => Yes

            $table->string('no_putusan')->nullable();
            $table->text('tempat_peradilan')->nullable();
            $table->date('tanggal_dibacakan')->nullable();
            
            $table->string('pihak_internal')->nullable();
            $table->string('pihak_eksternal')->nullable();
            $table->string('nomor_perjanjian')->nullable();
            $table->string('tempat_penandatanganan')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->date('tanggal_berakhir')->nullable();

            // File
            $table->text('pdf')->nullable();
            $table->text('abstract')->nullable();
            $table->text('attachment')->nullable();

            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('download_pdf_count')->default(0);
            $table->unsignedBigInteger('download_abstract_count')->default(0);
            $table->unsignedBigInteger('download_attachment_count')->default(0);
            $table->publishable();
            $table->timestamps();
        });

        CactuarBlueprint::schema()->create('documents', function (Blueprint $table) {
            $table->translated();
            $table->string('title');
            $table->text('intro')->nullable();
            $table->string('teu')->nullable(); // T.E.U Badan/Pengaran, T.E.U Orang/Badan

            $table->string('jenis_bentuk_peraturan')->nullable();
            $table->string('singkatan_bentuk_peraturan')->nullable();
            $table->text('sumber')->nullable();
            $table->string('subjek')->nullable();
            $table->string('bahasa')->nullable();
            $table->string('bidang_hukum')->nullable();
            $table->text('status_peraturan')->nullable();

            $table->string('edisi')->nullable();

            $table->text('lampiran')->nullable();

            $table->string('jenis_peradilan')->nullable();
            $table->string('singkatan_peradilan')->nullable();

            $table->text('deskripsi_fisik')->nullable();

            $table->string('jangka_waktu')->nullable();
            $table->text('status_naskah')->nullable();

            $table->string('pdf_name')->nullable();
            $table->string('abstract_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_lang');
        Schema::dropIfExists('documents');
    }
};
