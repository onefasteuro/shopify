<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductsStorefrontTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('products', function (Blueprint $table) {
		    $table->string('storefront_id', 60)->index('storefront_id')->after('id');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('products', function (Blueprint $table) {
		    $table->dropColumn('storefront_id');
	    });
    }
}
