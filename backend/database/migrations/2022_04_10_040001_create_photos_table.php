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
            $table->unsignedBigInteger('s3_id')->comment('File id')->index();
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['site_id', 'user_id', 's3_id']);
            $table->index(['site_id', 's3_id']);
            $table->index(['user_id', 's3_id']);

            $table->foreign('site_id')->references('id')->on('sites');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('s3_id')->references('id')->on('aws_s3_uploads');
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
