<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyPackageTermTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty__packageterm_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->integer('package_term_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['package_term_id', 'locale']);
            $table->foreign('package_term_id')->references('id')->on('loyalty__packageterms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty__packageterm_translations', function (Blueprint $table) {
            $table->dropForeign(['package_term_id']);
        });
        Schema::dropIfExists('loyalty__packageterm_translations');
    }
}
