<?php

use App\Modules\Sites\Models\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 32)->index()->unique()->comment('Unique identifier for code');
            $table->string('theme', 64)->index();
            $table->string('company_name', 64)->nullable()->index();
            $table->string('domain', 128)->unique()->index();
            $table->boolean('allow_wildcard_for_domain')
                ->comment('1: allow * wildcard for subdomain e.g. for trenchdevs')
                ->default(false)
                ->index();
            $table->string('logo', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        if (app()->environment('local')) {
            Site::query()->create([
                'domain' => 'trenchdevs.localhost',
                'company_name' => 'Sbadmin',
                'identifier' => 'trenchdevs',
                'theme' => 'trenchdevs'
            ]);

            Site::query()->create([
                'domain' => 'demo.localhost',
                'company_name' => 'Demo',
                'identifier' => 'demo',
                'theme' => 'demo',
            ]);


        } else {

            Site::query()->create([
                'domain' => 'trenchdevs.org',
                'company_name' => 'Sbadmin',
                'identifier' => 'trenchdevs',
                'theme' => 'trenchdevs',
            ]);

            Site::query()->create([
                'domain' => 'demo.trenchapps.com',
                'company_name' => 'TrenchApps',
                'identifier' => 'trenchapps',
                'theme' => 'demo',
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
