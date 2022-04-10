<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_albums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->comment('What account the entry is associated')->index();
            $table->unsignedBigInteger('user_id')->comment('User who created entry')->index();
            $table->string('name', 191);
            $table->string('description', 191);
            $table->boolean('is_featured')->nullable();
            $table->mediumInteger('rank')->comment("Priority rank in displaying featured album")->default(100);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('site_id')->references('id')->on('accounts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_albums');
    }
}
