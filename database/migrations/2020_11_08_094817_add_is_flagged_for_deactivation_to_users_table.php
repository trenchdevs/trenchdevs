<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFlaggedForDeactivationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_flagged_for_deactivation')
                ->default(0)
                ->after('is_active')
                ->index();
            $table->timestamp('deactivation_notice_sent_at', 0)
                ->after('is_flagged_for_deactivation')
                ->nullable()
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_flagged_for_deactivation');
            $table->dropColumn('deactivation_notice_sent_at');
        });
    }
}
