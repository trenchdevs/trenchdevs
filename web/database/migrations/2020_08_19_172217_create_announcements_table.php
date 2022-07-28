<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Who created announcement?');
            $table->unsignedBigInteger('account_id')->default(1);
            $table->string('title', 128);
            $table->enum('status', ['pending', 'canceled', 'processing', 'processed', 'errored'])->default('pending');
            $table->text('message'); // can be html
            $table->string('image_url',512)->nullable();
            $table->boolean('create_notifications')->default(1);
            $table->boolean('send_email')->default(1);
            $table->string('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
