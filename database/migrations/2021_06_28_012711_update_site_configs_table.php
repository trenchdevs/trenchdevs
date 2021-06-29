<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configs', function(Blueprint $table){
            $table->dropUnique('key_name');
            $table->unique(['site_id', 'key_name'], 'site_configs_site_id_key_name_uq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_configs', function(Blueprint $table){
            $table->dropUnique('site_configs_site_id_key_name_uq');
            $table->unique('key_name');
        });
    }
}
