<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id')->index();
            $table->string('email')->unique()->nullable();
            $table->string('contact_number', 32)->nullable();
            $table->text('response_text');
            $table->string('hash', 32);
            $table->json('meta_json');
            $table->timestamps();

            $table->foreign('story_id')->references('id')->on('stories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_responses');
    }
}
