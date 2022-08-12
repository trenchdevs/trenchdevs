<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('site_config_keys', function (Blueprint $table) {
            $table->string('key_name', 128)->index();
            $table->string('module', 64)->default('Core')->index();
            $table->string('description', 128);

            $table->primary('key_name');
        });

        Schema::create('site_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->index();
            $table->string('key_name', 128)->index();
            $table->string('key_value', 255)->index();
            $table->string('comments', 255)->index()->nullable();
            $table->timestamps();

            $table->unique('site_id', 'key_name');

            $table->index(['site_id', 'key_name', 'key_value']);
            $table->index(['key_name', 'key_value']);

            $table->foreign(['site_id'])->references('id')->on('sites');
            $table->foreign(['key_name'])->references('key_name')->on('site_config_keys');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('site_configs');
        Schema::dropIfExists('site_config_keys');
    }
}
