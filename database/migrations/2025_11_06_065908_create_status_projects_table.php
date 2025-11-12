<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use Cactuar\Admin\CactuarBlueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        CactuarBlueprint::schema()->create('status_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('color')->nullable();
            $table->publishable();
            $table->sortable();
            $table->timestamps();
        });

        CactuarBlueprint::schema()->create('status_projects', function (Blueprint $table) {
            $table->translated();
            $table->string('label');
        });

        // Seed initial statuses (ID and EN)
        $statuses = [
            ['id' => 'Perencanaan', 'en' => 'Planning'],
            ['id' => 'Penyusunan', 'en' => 'Drafting'],
            ['id' => 'Pembahasan', 'en' => 'Deliberation'],
            ['id' => 'Konsultasi Publik', 'en' => 'Public Consultation'],
            ['id' => 'Harmonisasi', 'en' => 'Harmonization'],
            ['id' => 'Persetujuan Presiden', 'en' => 'Presidential Approval'],
            ['id' => 'Penetapan dan Pengundangan', 'en' => 'Enactment and Promulgation'],
            ['id' => 'Penyebarluasan', 'en' => 'Dissemination'],
            ['id' => 'Selesai', 'en' => 'Completed'],
        ];

        foreach ($statuses as $index => $labels) {
            $baseId = DB::table('status_projects')->insertGetId([
                'color' => null,
                'is_active' => 1,
                'sort_id' => $index + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('status_projects_lang')->insert([
                [
                    'base_id' => $baseId,
                    'lang' => 'id',
                    'label' => $labels['id'],
                ],
                [
                    'base_id' => $baseId,
                    'lang' => 'en',
                    'label' => $labels['en'],
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_projects');
    }
};
