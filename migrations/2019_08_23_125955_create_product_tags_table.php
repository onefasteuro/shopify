<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('facet')->index('facet')->default(0);
            $table->string('tag_name', 50)->index('tag_name');
            $table->string('tag_value', 100)->index('tag_value');
            $table->string('tag_slug', 50)->index('tag_slug');
            $table->bigInteger('product_id')->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_tags');
    }
}
