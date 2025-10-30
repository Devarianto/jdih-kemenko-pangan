<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Cactuar\Admin\CactuarBlueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasTable('news') == true)
            return;

        CactuarBlueprint::schema()->create('news',function(CactuarBlueprint $table) {
            $table->increments('id');
            $table->text('thumb')->nullable();
            $table->date('date');
            $table->string('author')->nullable();
            $table->publishable();
            $table->timestamps();
        });

        CactuarBlueprint::schema()->create('news',function(CactuarBlueprint $table) {
            $table->translated();
            $table->string('label');
            $table->text('intro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
