<?php

use App\Modules\Sites\Models\SiteAccessLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_access_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('url', 512)->index(); // see UserLogin constants
            $table->ipAddress('ip')->index();
            $table->enum('action', [SiteAccessLog::DB_ACTION_ALLOWED, SiteAccessLog::DB_ACTION_DENIED])->default(SiteAccessLog::DB_ACTION_ALLOWED);
            $table->string('user_agent', 512)->index();
            $table->string('referer', 512)->nullable()->index();
            $table->json('misc_json')->nullable();
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
        Schema::dropIfExists('site_access_logs');
    }
}
