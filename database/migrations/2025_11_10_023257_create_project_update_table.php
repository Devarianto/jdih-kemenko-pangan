<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_update', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('project_name')->nullable();
            $table->text('dokumen')->nullable();
            $table->text('note')->nullable();
            $table->integer('id_status_project');
            $table->string('label_status_project_id')->nullable();
            $table->string('label_status_project_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_update');
    }
};
