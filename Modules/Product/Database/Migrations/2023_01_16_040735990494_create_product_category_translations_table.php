<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__category_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            // $table->string('title');
            // $table->string('slug');
            // $table->text('sumary')->nullable();
            // $table->text('body')->nullable();
            // $table->string('meta_title')->nullable();
            // $table->string('meta_description')->nullable();
            // $table->string('og_title')->nullable();
            // $table->string('og_description')->nullable();
            // $table->string('og_image')->nullable();
            // $table->string('og_type')->nullable();
            // $table->integer('category_id')->unsigned();
            // $table->string('locale')->index();
            // $table->unique(['category_id', 'locale']);
            // $table->foreign('category_id')->references('id')->on('product__categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__category_translations');
    }
}
