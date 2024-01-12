<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyPackagesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty__packages_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->text('description');
            $table->integer('package_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['package_id', 'locale']);
            $table->foreign('package_id')->references('id')->on('loyalty__package')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty__packages_translations', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
        });
        Schema::dropIfExists('loyalty__packages_translations');
    }
}
