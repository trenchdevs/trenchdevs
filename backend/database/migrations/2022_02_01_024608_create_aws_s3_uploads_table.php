<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsS3UploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_s3_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('s3_url')->unique()->index();
            $table->string('s3_path')->unique()->index();
            $table->string('identifier')->index();
            $table->enum('status', ['uploaded', 'marked_for_deletion', 'deleted'])->index();
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('aws_s3_uploads');
    }
}
