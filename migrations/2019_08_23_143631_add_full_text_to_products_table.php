<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFullTextToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('products', function (Blueprint $table) {
		    $table->dateTime('date_created')->after('type')->index('date_created');
		
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
	        $table->dropColumn('date_created');
        });
    }
}
