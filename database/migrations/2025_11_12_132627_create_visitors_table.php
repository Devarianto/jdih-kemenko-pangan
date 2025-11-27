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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('visitor')->default(0);
            $table->timestamps();
        });

        Schema::create('visitor_total', function(Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->unsignedBigInteger('visitor')->default(0);
            $table->timestamps();
        });

        DB::table('visitor_total')->insert([
            'key' => 'total',
            'visitor' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
        Schema::dropIfExists('visitor_total');
    }
};
