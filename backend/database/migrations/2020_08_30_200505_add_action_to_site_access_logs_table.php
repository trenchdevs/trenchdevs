<?php

use App\Modules\Sites\Models\SiteAccessLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionToSiteAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_access_logs', function (Blueprint $table) {
            $table->enum('action', [SiteAccessLog::DB_ACTION_ALLOWED, SiteAccessLog::DB_ACTION_DENIED])
                ->default(SiteAccessLog::DB_ACTION_ALLOWED)
                ->after('ip')
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
        Schema::table('site_access_logs', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }
}
