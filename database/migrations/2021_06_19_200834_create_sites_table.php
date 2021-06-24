<?php

use App\Models\Site;
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
            $table->string('domain', 128)->unique()->index();
            $table->string('company_name', 64)->nullable()->index();
            $table->string('identifier', 32)->index()->unique()->comment('Unique identifier for code');
            $table->timestamps();
            $table->softDeletes();
        });


        if (app()->environment('local')) {
            Site::query()->create([
                'domain' => 'trenchdevs.localhost',
                'company_name' => 'TrenchDevs',
                'identifier' => 'trenchdevs'
            ]);

            Site::query()->create([
                'domain' => 'demo.localhost',
                'company_name' => 'Demo',
                'identifier' => 'demo'
            ]);


        } else {

            Site::query()->create([
                'domain' => 'trenchdevs.org',
                'company_name' => 'TrenchDevs',
                'identifier' => 'trenchdevs'
            ]);

            Site::query()->create([
                'domain' => 'trenchapps.com',
                'company_name' => 'TrenchApps',
                'identifier' => 'trenchapps'
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
