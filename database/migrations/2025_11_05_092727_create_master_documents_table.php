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
        CactuarBlueprint::schema()->create('master_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->publishable();
            $table->timestamps();
        });

        DB::table('master_documents')->insert([
            'label' => 'Peraturan Hukum',
            'is_active' => 1
        ]);
        
        DB::table('master_documents')->insert([
            'label' => 'Jurnal Hukum',
            'is_active' => 1
        ]);

        DB::table('master_documents')->insert([
            'label' => 'Kliping Hukum',
            'is_active' => 1
        ]);

        DB::table('master_documents')->insert([
            'label' => 'Majalah Hukum',
            'is_active' => 1
        ]);

        DB::table('master_documents')->insert([
            'label' => 'Putusan Hukum',
            'is_active' => 1
        ]);

        DB::table('master_documents')->insert([
            'label' => 'Monografi Hukum',
            'is_active' => 1
        ]);

        DB::table('master_documents')->insert([
            'label' => 'Naskah Kerja Sama',
            'is_active' => 1
        ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_documents');
    }
};
