<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeProductCategoryIdColumnNullableInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_category_id']);

            $table->unsignedBigInteger('product_category_id')
                ->nullable()
                ->after('account_id')
                ->change();

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_category_id']);

            $table->unsignedBigInteger('product_category_id')
                ->nullable(FALSE)
                ->after('account_id')
                ->change();

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories');
        });
    }
}
