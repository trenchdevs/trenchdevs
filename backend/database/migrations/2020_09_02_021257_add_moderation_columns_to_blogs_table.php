<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModerationColumnsToBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {

            $table->enum('moderation_status', ['pending', 'approved', 'rejected'])->default('pending')
                ->after('status')->index();
            $table->unsignedBigInteger('moderated_by')->after('moderation_status')->nullable();
            $table->dateTime('moderated_at')->nullable()->after('moderated_by');
            $table->text('moderation_notes')->after('moderated_at')->nullable();

            $table->foreign('moderated_by', 'blogs_moderated_by_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign('blogs_moderated_by_foreign');
            $table->dropColumn('moderation_notes');
            $table->dropColumn('moderated_at');
            $table->dropColumn('moderated_by');
            $table->dropColumn('moderation_status');
        });
    }
}
