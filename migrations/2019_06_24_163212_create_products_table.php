<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
	        $table->bigInteger('id')->index('id')->primary()->unique();
            $table->string('handle', 100)->index('handle');
            $table->string('title');
            $table->string('type', 50)->index('type');
            $table->integer('min_price')->index('min_price');
            $table->integer('max_price')->index('max_price');
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
