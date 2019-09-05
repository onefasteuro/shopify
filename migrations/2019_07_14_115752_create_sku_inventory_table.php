<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id')->index('product_id');
            $table->bigInteger('variant_id')->index('variant_id');
            $table->string('sku', 40)->index('sku');
            $table->bigInteger('inventory')->default(0);
            $table->string('inventory_policy', 50)->default('DENY');
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
        Schema::dropIfExists('sku_inventory');
    }
}
