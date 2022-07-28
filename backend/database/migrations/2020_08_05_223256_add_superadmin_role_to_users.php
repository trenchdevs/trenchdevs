<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class AddSuperadminRoleToUsers extends Migration
{
    private static function getDriver() {
        $connection = config('database.default');
        return config("database.connections.{$connection}.driver");
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (AddSuperadminRoleToUsers::getDriver() != 'sqlite') {
            DB::statement("ALTER TABLE `users` CHANGE COLUMN `role` `role` ENUM('superadmin','admin','business_owner','customer','contributor') NOT NULL DEFAULT 'contributor' COLLATE 'utf8mb4_unicode_ci' AFTER `account_id`");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (AddSuperadminRoleToUsers::getDriver() != 'sqlite') {
            DB::statement("ALTER TABLE `users` CHANGE COLUMN `role` `role` ENUM('admin','business_owner','customer') NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `account_id`");
        }
    }
}
