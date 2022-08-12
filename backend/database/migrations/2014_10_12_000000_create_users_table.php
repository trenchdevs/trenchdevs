<?php

use App\Modules\Sites\Enums\SiteIdentifier;
use App\Modules\Sites\Models\Site;
use App\Modules\Users\Models\User;
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
            $table->enum('role', ['superadmin', 'admin', 'business_owner', 'customer', 'contributor'])->index();
            $table->boolean('is_active')->default(false)->index();
            $table->string('email')->default('')->index();
            $table->string('external_id')->default('')->index();
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('site_id')->references('id')->on('sites');
            $table->unique(['site_id', 'email']);
            $table->unique(['site_id', 'external_id']);

            $table->index(['site_id', 'email']);
            $table->index(['site_id', 'external_id']);
            $table->index('updated_at');
            $table->index('created_at');
        });

        $this->createUsersOnLocal();
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

    private function createUsersOnLocal()
    {
        if (app()->environment('local')) {
            User::query()->create([
                'site_id' => Site::fromIdentifier(SiteIdentifier::TRENCHDEVS)->id,
                'role' => 'superadmin',
                'first_name' => 'Admin',
                'last_name' => 'Trenchdevs',
                'email' => 'trenchdevs-admin@localhost',
                'password' => Hash::make('p2ssw0rd'),
            ]);

            User::query()->create([
                'site_id' => Site::fromIdentifier(SiteIdentifier::DEMO)->id,
                'role' => 'superadmin',
                'first_name' => 'Admin',
                'last_name' => 'TrenchDevs',
                'email' => 'demo-admin@localhost',
                'password' => Hash::make('p2ssw0rd'),
            ]);

            User::query()->create([
                'site_id' => Site::fromIdentifier(SiteIdentifier::CLOUDCRAFT)->id,
                'role' => 'superadmin',
                'first_name' => 'Admin',
                'last_name' => 'CloudCraft',
                'email' => 'cloudcraft-admin@localhost',
                'password' => Hash::make('p2ssw0rd'),
            ]);
        }
    }
}
