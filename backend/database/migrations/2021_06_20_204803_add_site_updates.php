<?php

use App\Modules\Sites\Models\Site;
use App\Modules\Users\Models\User;
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
        if (!empty($trenchDevs = Site::getByIdentifier(Site::DB_IDENTIFIER_TRENCHDEVS))) {
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

    }
}
