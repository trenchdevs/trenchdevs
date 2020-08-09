<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwsSnsLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aws_sns_logs', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->text('headers');
            $table->json('raw_json')->comment('Actual json from request');
            $table->ipAddress('ip');
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
        Schema::dropIfExists('aws_sns_logs');
    }
}
