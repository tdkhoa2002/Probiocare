<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingThemeOptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting__themeoption_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('theme_option_id')->unsigned();
            $table->string('locale')->index();
            $table->string('value')->nullable();
            $table->text('description')->nullable();
            $table->unique(['theme_option_id', 'locale']);
            $table->foreign('theme_option_id')->references('id')->on('setting__themeoptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting__themeoption_translations', function (Blueprint $table) {
            $table->dropForeign(['theme_option_id']);
        });
        Schema::dropIfExists('setting__themeoption_translations');
    }
}
