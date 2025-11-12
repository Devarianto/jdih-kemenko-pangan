<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_applicant_division', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->integer('applicant_division_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_applicant_division');
    }
};


