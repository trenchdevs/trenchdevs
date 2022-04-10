<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string("type", 32)->nullable();
            $table->string("title", 255);
            $table->string("contents", 512)->nullable();
            $table->string("image_url", 255)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['site_id', 'user_id', 'type']);
            $table->foreign(['site_id'])->references(['id'])->on('sites');
            $table->foreign(['user_id'])->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('activities');
    }
}
