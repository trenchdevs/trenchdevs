<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained();
            $table->foreignId('product_category_id')->constrained();
            $table->string('name');
            $table->string('description', 255)
                ->nullable();
            $table->string('sku', 255)
                ->index();
            $table->unsignedInteger('stock')
                ->default(0);
            $table->string('image_url')
                ->index()
                ->default('');
            $table->unsignedDecimal('shipping_cost', 10, 4)
                ->default(0);
            $table->unsignedDecimal('handling_cost', 10, 4)
                ->default(0);
            $table->unsignedDecimal('product_cost', 10, 4)
                ->default(0);
            $table->unsignedDecimal('msrp', 10, 4)
                ->default(0);
            $table->unsignedDecimal('final_cost', 10, 4)
                ->default(0);
            $table->decimal('markup_percentage', 10, 4)
                ->default(1);
            $table->json('attributes')
                ->nullable();
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('products');
    }
}
