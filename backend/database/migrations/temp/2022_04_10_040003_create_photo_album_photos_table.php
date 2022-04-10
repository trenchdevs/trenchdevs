<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoAlbumPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_album_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photo_id')  ->comment('What photo the entry is associated')->index();
            $table->unsignedBigInteger('photo_album_id')->comment('What photo album the entry is associated')->index();
            $table->boolean('is_featured')->nullable();
            $table->timestamps();

            $table->foreign('photo_id')->references('id')->on('photos');
            $table->foreign('photo_album_id')->references('id')->on('photo_albums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_album_photos');
    }
}
