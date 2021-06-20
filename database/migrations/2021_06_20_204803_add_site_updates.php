<?php

use App\Models\Site;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->default(1)->after('account_id')->index();
            $table->foreign('site_id')->references('id')->on('sites');

            $table->dropIndex('users_email_unique');
        });

        Schema::table('sites', function (Blueprint $table) {
            $table->string('theme', 64)->after('identifier')->index();
        });

        if ($trenchDevs = Site::getByIdentifier(Site::DB_IDENTIFIER_TRENCHDEVS)) {
            User::query()->whereNull('site_id')->update(['site_id' => $trenchDevs->id]);
            $trenchDevs->save(['theme' => 'trenchdevs']);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('theme');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unique(['email']);
            $table->dropForeign('users_site_id_foreign');
            $table->dropColumn('site_id');
        });

    }
}
