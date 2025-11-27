<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
		if (Schema::hasTable('openai_api_usages'))
			return;
		
		Schema::create('openai_api_usages',function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('period')->unique();
			$table->double('token_usage')->default(0);
		});

		if (Schema::hasTable('openai_api_logs'))
			return;
		
		Schema::create('openai_api_logs',function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('user_id')->nullable();
			$table->string('username')->nullable();
			$table->string('user_display_name')->nullable();
			$table->string('method')->default('GET');
			$table->text('path')->nullable();
			$table->text('body')->nullable();
			$table->integer('http_code')->nullable();
			$table->string('status')->default('success');
			$table->text('response')->nullable();
			$table->double('token_usage');
			$table->timestamps();
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
		Schema::dropIfExists('openai_api_usages');
		Schema::dropIfExists('openai_api_logs');
    }
};
