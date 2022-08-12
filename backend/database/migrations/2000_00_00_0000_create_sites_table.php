<?php

use App\Modules\Sites\Enums\SiteIdentifier;
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
            $table->string('theme', 64)->index()->comment("Theme used for backend, routing & regular blade files");
            $table->string('inertia_theme', 64)->default('TrenchDevsAdmin')->comment('Theme used for Inertia JS');
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

        $this->createDefaultSites();
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

    private function createDefaultSites()
    {
        if (app()->environment('local', 'testing')) {
            Site::query()->create([
                'domain' => 'trenchdevs.localhost',
                'company_name' => 'TrenchDevsAdmin',
                'identifier' => SiteIdentifier::TRENCHDEVS,
                'theme' => 'trenchdevs',
                'inertia_theme' => 'TrenchDevsAdmin',
            ]);

            Site::query()->create([
                'domain' => 'demo.localhost',
                'company_name' => 'Demo',
                'identifier' => SiteIdentifier::DEMO,
                'theme' => 'demo',
                'inertia_theme' => 'TrenchDevsAdmin',
            ]);

            Site::query()->updateOrCreate(
                ['identifier' => SiteIdentifier::CLOUDCRAFT],
                [
                    'domain' => 'cloudcraft.trenchapps.localhost',
                    'allow_wildcard_for_domain' => 0,
                    'company_name' => 'CloudCraft',
                    'theme' => 'cloudcraft',
                    'inertia_theme' => 'TrenchDevsAdmin',
                ]
            );


        } else {

            Site::query()->create([
                'domain' => 'trenchdevs.org',
                'company_name' => 'TrenchDevsAdmin',
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
}
