<?php

use App\Domains\Sites\Models\Site;
use App\Domains\Sites\Models\Sites\SiteConfig;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('site_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->string('key_name', 128);
            $table->string('key_value', 255);
            $table->string('comments', 255)->nullable();
            $table->timestamps();

            $table->index(['key_name']);
            $table->index(['site_id']);
            $table->index(['key_value']);
            $table->index(['key_name', 'key_value']);
            $table->index(['site_id', 'key_name', 'key_value']);
            $table->unique('site_id', 'key_name');

            $table->foreign(['site_id'])->references('id')->on('sites');
        });

        // set themes for all sites
        DB::unprepared("
           UPDATE sites
            SET theme = identifier
            WHERE (theme IS NULL or theme = '')
        ");

        if (!app()->environment('production')) {
            Site::query()->updateOrCreate(
                ['identifier' => Site::DB_IDENTIFIER_CLOUDCRAFT],
                [
                    'domain' => 'cloudcraft.trenchapps.localhost',
                    'allow_wildcard_for_domain' => 0,
                    'company_name' => 'CloudCraft',
                    'theme' => 'cloudcraft'
                ]
            );
        }


        if (!empty($cloudCraft = Site::getByIdentifier(Site::DB_IDENTIFIER_CLOUDCRAFT))) {
            SiteConfig::query()->updateOrCreate(
                ['key_name' => SiteConfig::KEY_NAME_SYSTEM_LOGIN_REDIRECT_PATH, 'site_id' => $cloudCraft->id],
                ['key_value' => '/home', 'comments' => 'Redirect path after login']
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('site_configs');
    }
}
