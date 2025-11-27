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
        CactuarBlueprint::schema()->create('kamus_hukum', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->publishable();
            $table->timestamps();
        });

        CactuarBlueprint::schema()->create('kamus_hukum', function (Blueprint $table) {
            $table->translated();
            $table->string('title');
            $table->string('intro');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamus_hukum_lang');
        Schema::dropIfExists('kamus_hukum');
    }
};
