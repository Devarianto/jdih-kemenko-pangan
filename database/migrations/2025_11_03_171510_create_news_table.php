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
        CactuarBlueprint::schema()->create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->text('thumbnail');
            $table->text('thumbnail_home_small');
            $table->text('thumbnail_home_large');
            $table->text('image');
            $table->date('date');
            $table->publishable();
            $table->timestamps();
        });
        
        CactuarBlueprint::schema()->create('news', function (Blueprint $table) {
            $table->translated();
            $table->string('title');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_lang');
        Schema::dropIfExists('news');
    }
};
