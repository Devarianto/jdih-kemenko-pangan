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

        CactuarBlueprint::schema()->create('applicant_divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->publishable();
            $table->timestamps();
        });

        CactuarBlueprint::schema()->create('applicant_divisions', function (Blueprint $table) {
            $table->translated();
            $table->string('label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_divisions');
    }
};
