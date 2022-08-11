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

            $table->comment('App wide configuration / flags');
        });

        DB::table('app_configurations')->updateOrInsert(
            ['key' => 'CLEAR_CACHE'],
            ['value' => '1', 'description' => 'Bust the cache for the app? w/c uses the TDCache class']
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
