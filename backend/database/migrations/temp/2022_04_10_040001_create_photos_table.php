<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id') ->comment('What account the entry is associated')->index();
            $table->unsignedBigInteger('user_id')->comment('User who created entry')->index();
            $table->string('path')->unique();
            $table->string('url');
            $table->boolean('is_active');
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
        Schema::dropIfExists('photos');
    }
}
