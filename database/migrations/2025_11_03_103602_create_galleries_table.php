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
        CactuarBlueprint::schema()->create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->text('thumbnail');
            $table->string('type'); // image / video
            $table->text('iframe')->nullable();
            $table->date('date');
            $table->publishable();
            $table->timestamps();
        });
        
        CactuarBlueprint::schema()->create('galleries', function (CactuarBlueprint $table) {
            $table->translated();
            $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries_lang');
        Schema::dropIfExists('galleries');
    }
};
