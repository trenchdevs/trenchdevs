<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_degrees', function (Blueprint $table) {
            $table->renameColumn('education_institution', 'educational_institution');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_degrees', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->renameColumn('educational_institution', 'education_institution');
        });
    }
}
