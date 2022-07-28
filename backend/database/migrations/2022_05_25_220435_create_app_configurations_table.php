<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAppConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_configurations', function (Blueprint $table) {
            $table->string('key', 64)->index()->unique();
            $table->string('value', 256)->index();
            $table->string('description', 256);
            $table->unique(['key', 'value']);
        });

        DB::table('app_configurations')->updateOrInsert(
            ['key' => 'TD_CACHE_BUST'],
            ['value' => '0', 'description' => 'Bust the cache for TDCache?']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_configurations');
    }
}
