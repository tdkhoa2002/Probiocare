<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('product__categories')->onDelete('cascade');
            $table->string('code');
            $table->boolean('show_homepage')->default(false);
            $table->boolean('is_best_selling')->default(false);
            $table->boolean('is_new_arrivals')->default(false);
            $table->boolean('is_best_choice')->default(false);
            $table->boolean('is_promotion')->default(false);
            $table->tinyInteger('product_status')->nullable()->default(0);
            $table->double('price')->default(0);
            $table->double('price_sale')->default(0);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('product__products');
    }
}
