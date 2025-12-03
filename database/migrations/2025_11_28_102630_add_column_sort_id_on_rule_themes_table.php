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
        Schema::table('rule_themes', function(Blueprint $table) {
            $table->integer('sort_id')->default(1)->after('is_active');
        });

        for ($i=1; $i <= 4; $i++) { 
            DB::table('rule_themes')->where('id', $i)->update([
                'sort_id' => $i,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rule_themes', function(Blueprint $table) {
            $table->dropColumn('sort_id');
        });
    }
};
