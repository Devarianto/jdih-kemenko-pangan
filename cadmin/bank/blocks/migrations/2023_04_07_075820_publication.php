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
        if (Schema::hasTable('publications'))
            return;

        CactuarBlueprint::schema()->create('publications',function(CactuarBlueprint $table) {
            $table->increments('id');
            $table->text('thumb')->nullable();
            $table->date('date');
            $table->integer('is_highlight')->default(0);
            $table->publishable();
            $table->timestamps();
        });

        CactuarBlueprint::schema()->create('publications',function(CactuarBlueprint $table) {
            $table->translated();
            $table->text('doc')->nullable();
            $table->string('label')->nullable();
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
