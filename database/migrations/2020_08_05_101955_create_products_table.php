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
            $table->foreignId('product_category_id')->constrained();
            $table->string('name');
            $table->string('description', 250)
                ->nullable();
            $table->unsignedInteger('stock')
                ->default(0);
            $table->string('image_url')
                ->index();
            $table->boolean('is_on_sale')
                ->default(TRUE);
            $table->unsignedDecimal('shipping_cost', 8, 4)
                ->default(0);
            $table->unsignedDecimal('handling_cost', 8, 4)
                ->default(0);
            $table->unsignedDecimal('product_cost', 8, 4)
                ->default(0);
            $table->unsignedDecimal('sale_product_cost', 8, 4)
                ->default(0);
            $table->unsignedDecimal('final_cost', 8, 4)
                ->default(0);
            $table->json('attributes')
                ->nullable();
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
