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
        if (!Schema::hasTable('public_consultation_feedbacks')) {
            Schema::create('public_consultation_feedbacks', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('document_id')->nullable();
                $table->foreign('document_id')
                    ->references('id')
                    ->on('documents')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->string('name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->string('institution')->nullable();
                $table->text('feedback');
                $table->string('attachment')->nullable();
                $table->string('status', 50)->default('pending'); // pending, reviewed, accepted, rejected
                $table->text('notes')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_consultation_feedbacks');
    }
};
