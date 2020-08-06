<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSuperadminRoleToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `users` CHANGE COLUMN `role` `role` ENUM('superadmin','admin','business_owner','customer','contributor') NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `account_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `users` CHANGE COLUMN `role` `role` ENUM('admin','business_owner','customer') NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `account_id`");
    }
}
