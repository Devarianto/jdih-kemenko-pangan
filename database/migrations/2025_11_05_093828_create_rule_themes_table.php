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
        CactuarBlueprint::schema()->create('rule_themes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('icon')->nullable();
            $table->text('image')->nullable();
            $table->string('label');
            $table->publishable();
            $table->timestamps();
        });

        DB::table('rule_themes')->insert([
            'label' => 'Tata Niaga dan Distribusi Pangan',
            'is_active' => 1
        ]);

        DB::table('rule_themes')->insert([
            'label' => 'Usaha Pangan dan Pertanian',
            'is_active' => 1
        ]);

        DB::table('rule_themes')->insert([
            'label' => 'Keterjangkauan dan Keamanan Pangan',
            'is_active' => 1
        ]);

        DB::table('rule_themes')->insert([
            'label' => 'Sumber Daya Maritim',
            'is_active' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_themes');
    }
};
