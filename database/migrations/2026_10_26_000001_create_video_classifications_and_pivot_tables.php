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
        // 1. Table video_classifications
        if (!Schema::hasTable('video_classifications')) {
            Schema::create('video_classifications', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 50)->unique();
                $table->string('name', 100);
                $table->text('description')->nullable();
                $table->integer('sort_id')->default(0);
                $table->tinyInteger('is_active')->default(1);
                $table->timestamps();
            });
        }

        // 2. Table gallery_video_classifications (Pivot many-to-many)
        if (!Schema::hasTable('gallery_video_classifications')) {
            Schema::create('gallery_video_classifications', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('gallery_id');
                $table->unsignedInteger('classification_id');
                $table->timestamps();

                $table->foreign('gallery_id')
                    ->references('id')
                    ->on('galleries')
                    ->onDelete('cascade');

                $table->foreign('classification_id')
                    ->references('id')
                    ->on('video_classifications')
                    ->onDelete('cascade');

                $table->unique(['gallery_id', 'classification_id'], 'gallery_class_unique');
            });
        }

        // 3. Add description column to galleries_lang if not exists
        if (Schema::hasTable('galleries_lang') && !Schema::hasColumn('galleries_lang', 'description')) {
            Schema::table('galleries_lang', function (Blueprint $table) {
                $table->text('description')->nullable()->after('title');
            });
        }

        // 4. Add sort_id column to galleries if not exists
        if (Schema::hasTable('galleries') && !Schema::hasColumn('galleries', 'sort_id')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->integer('sort_id')->default(0)->after('date');
            });
        }

        // 5. Seed initial classifications
        $now = now();
        $classifications = [
            [
                'code' => 'galeri',
                'name' => 'Galeri',
                'description' => 'Video untuk halaman Galeri Foto & Video',
                'sort_id' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'aksesibilitas',
                'name' => 'Aksesibilitas',
                'description' => 'Video panduan dan informasi ramah aksesibilitas/disabilitas',
                'sort_id' => 2,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($classifications as $c) {
            $existing = DB::table('video_classifications')->where('code', $c['code'])->first();
            if (!$existing) {
                DB::table('video_classifications')->insert($c);
            }
        }

        // 6. Connect existing video records to 'galeri' by default
        $galeriCat = DB::table('video_classifications')->where('code', 'galeri')->first();
        $aksesibilitasCat = DB::table('video_classifications')->where('code', 'aksesibilitas')->first();

        if ($galeriCat) {
            $existingVideos = DB::table('galleries')->where('type', 'video')->get();
            foreach ($existingVideos as $idx => $v) {
                // Link to 'galeri'
                DB::table('gallery_video_classifications')->updateOrInsert(
                    ['gallery_id' => $v->id, 'classification_id' => $galeriCat->id],
                    ['created_at' => $now, 'updated_at' => $now]
                );

                // For the last video (or if index == 0), also link to 'aksesibilitas' to demonstrate multi-classification
                if ($aksesibilitasCat && $idx === 0) {
                    DB::table('gallery_video_classifications')->updateOrInsert(
                        ['gallery_id' => $v->id, 'classification_id' => $aksesibilitasCat->id],
                        ['created_at' => $now, 'updated_at' => $now]
                    );
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_video_classifications');
        Schema::dropIfExists('video_classifications');

        if (Schema::hasTable('galleries_lang') && Schema::hasColumn('galleries_lang', 'description')) {
            Schema::table('galleries_lang', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }

        if (Schema::hasTable('galleries') && Schema::hasColumn('galleries', 'sort_id')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->dropColumn('sort_id');
            });
        }
    }
};
