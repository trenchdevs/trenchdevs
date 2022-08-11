<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('site_id')->after('id')->default(1)->index();
            $table->enum('status', ['draft', 'published']);
            $table->string('slug', 255)->nullable()->comment('if not specified by default we will use id');
            $table->string('title');
            $table->string('tagline', 255);
            $table->mediumText('markdown_contents');
            $table->string('primary_image_url', 4000);
            $table->dateTime('publication_date')->nullable()->index();

            $table->enum('moderation_status', ['pending', 'approved', 'rejected'])->default('approved')->index();
            $table->unsignedBigInteger('moderated_by')->nullable();
            $table->dateTime('moderated_at')->nullable();
            $table->text('moderation_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['site_id', 'title']);
            $table->unique(['site_id', 'slug']);

            $table->index(['site_id', 'title']);
            $table->index(['site_id', 'slug']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign(['site_id'], 'site_fk')->references('id')->on('sites');
            $table->foreign('moderated_by', 'blogs_moderated_by_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
