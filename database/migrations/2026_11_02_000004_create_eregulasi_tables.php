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
        // 1. Modifikasi tabel users JDIH jika belum memiliki kolom role & unit_kerja
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 50)->default('super_admin')->after('email');
            }
            if (!Schema::hasColumn('users', 'unit_kerja')) {
                $table->string('unit_kerja', 255)->nullable()->after('role');
            }
        });

        // Set seluruh user admin eksisting sebagai super_admin
        DB::table('users')->whereNull('role')->orWhere('role', '')->update([
            'role' => 'super_admin'
        ]);

        // 2. Tabel regulasi
        if (!Schema::hasTable('regulasi')) {
            Schema::create('regulasi', function (Blueprint $table) {
                $table->id();
                $table->string('jenis', 100);
                $table->text('judul');
                $table->text('abstrak')->nullable();
                $table->date('tgl_usulan');
                $table->string('unit_kerja', 255);
                $table->string('status', 50)->default('draft');
                $table->string('current_stage', 50)->default('pengajuan');
                $table->string('uji_publik_status', 50)->nullable();
                $table->boolean('pasca_partisipasi_dimulai')->default(false);
                $table->text('file_permohonan')->nullable();
                $table->text('file_draft')->nullable();
                $table->unsignedInteger('created_by');
                
                // Tahap Harmonisasi
                $table->date('tgl_mulai_harmonisasi')->nullable();
                $table->date('tgl_selesai_harmonisasi')->nullable();
                $table->text('catatan_harmonisasi')->nullable();
                $table->text('harmon_surat_permohonan')->nullable();
                $table->text('harmon_naskah_urgensi')->nullable();
                $table->text('harmon_draft_rancangan')->nullable();

                // Tahap Penetapan
                $table->date('tgl_mulai_penetapan')->nullable();
                $table->date('tgl_selesai_penetapan')->nullable();
                $table->text('catatan_penetapan')->nullable();
                $table->text('tapan_surat_permohonan')->nullable();
                $table->text('tapan_surat_selesai_harmon')->nullable();
                $table->text('tapan_ba_harmon')->nullable();
                $table->text('tapan_softcopy_harmon')->nullable();
                $table->text('tapan_draft_akhir')->nullable();

                $table->timestamps();

                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 3. Tabel regulasi_tahapans
        if (!Schema::hasTable('regulasi_tahapans')) {
            Schema::create('regulasi_tahapans', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('regulasi_id');
                $table->string('stage', 50);
                $table->string('status', 50)->default('in_progress');
                $table->dateTime('started_at')->nullable();
                $table->dateTime('completed_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->foreign('regulasi_id')->references('id')->on('regulasi')->onDelete('cascade');
            });
        }

        // 4. Tabel regulasi_proses
        if (!Schema::hasTable('regulasi_proses')) {
            Schema::create('regulasi_proses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('regulasi_id');
                $table->string('judul', 255);
                $table->string('proses', 255);
                $table->date('tanggal');
                $table->boolean('is_after_uji_publik')->default(false);
                $table->text('file_dokumen')->nullable();
                $table->unsignedInteger('created_by');
                $table->timestamps();

                $table->foreign('regulasi_id')->references('id')->on('regulasi')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 5. Tabel partisipasi_publik
        if (!Schema::hasTable('partisipasi_publik')) {
            Schema::create('partisipasi_publik', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('regulasi_id');
                $table->date('tgl_mulai');
                $table->date('tgl_selesai');
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->foreign('regulasi_id')->references('id')->on('regulasi')->onDelete('cascade');
            });
        }

        // 6. Tabel tanggapan
        if (!Schema::hasTable('tanggapan')) {
            Schema::create('tanggapan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('regulasi_id');
                $table->unsignedInteger('user_id')->nullable();
                $table->string('nama_pengirim', 255)->nullable();
                $table->string('email', 255)->nullable();
                $table->string('tipe', 50)->default('masyarakat');
                $table->string('nama_instansi', 255)->nullable();
                $table->string('nomor_telepon', 100)->nullable();
                $table->text('isi_tanggapan');
                $table->boolean('is_hidden')->default(false);
                $table->timestamps();

                $table->foreign('regulasi_id')->references('id')->on('regulasi')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapan');
        Schema::dropIfExists('partisipasi_publik');
        Schema::dropIfExists('regulasi_proses');
        Schema::dropIfExists('regulasi_tahapans');
        Schema::dropIfExists('regulasi');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'unit_kerja')) {
                $table->dropColumn('unit_kerja');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};

