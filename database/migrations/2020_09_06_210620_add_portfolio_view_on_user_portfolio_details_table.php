<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPortfolioViewOnUserPortfolioDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_portfolio_details', function (Blueprint $table) {
            $table->string('portfolio_view')->default('portfolio.show')->after('tagline');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_portfolio_details', function (Blueprint $table) {
            $table->dropColumn('portfolio_view');
        });
    }
}
