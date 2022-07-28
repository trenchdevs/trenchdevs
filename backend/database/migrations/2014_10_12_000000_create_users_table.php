<?php

use App\Domains\Sites\Models\Site;
use App\Domains\Users\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->default(1)->index();
            $table->string('email');
            $table->string('external_id')->nullable();
            $table->enum('role', ['superadmin','admin','business_owner','customer','contributor']);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites');
        });

        if (app()->environment('local')) {
            User::query()->create([
                'site_id' => Site::fromIdentifier(Site::DB_IDENTIFIER_TRENCHDEVS)->id,
                'role' => 'superadmin',
                'first_name' => 'Admin',
                'last_name' => 'Trenchdevs',
                'email' => 'trenchdevs-admin@localhost',
                'password' => Hash::make('p2ssw0rd'),
            ]);

            User::query()->create([
                'site_id' => Site::fromIdentifier(Site::DB_IDENTIFIER_DEMO)->id,
                'role' => 'superadmin',
                'first_name' => 'Admin',
                'last_name' => 'Trenchdevs',
                'email' => 'demo-admin@localhost',
                'password' => Hash::make('p2ssw0rd'),
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
}
