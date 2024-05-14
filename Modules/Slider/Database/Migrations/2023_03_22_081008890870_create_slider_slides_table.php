<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider__slides', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('slider_id')->unsigned();
            $table->foreign('slider_id')->references('id')->on('slider__sliders')->onDelete('cascade');
            $table->string('name', 100);
            $table->integer('page_id')->unsigned()->nullable();
            $table->integer('position')->unsigned()->default(0);
            $table->string('target', 10)->nullable();
            $table->string('external_image_url', 255)->nullable()->default(null);
            $table->string('youtube_video_url')->nullable()->default(null);
            $table->string('classes', 1024)->nullable();
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
        Schema::dropIfExists('slider__slides');
    }
}
