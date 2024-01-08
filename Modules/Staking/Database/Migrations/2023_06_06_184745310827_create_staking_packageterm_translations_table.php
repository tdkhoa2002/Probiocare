<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakingPackageTermTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staking__packageterm_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->integer('package_term_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['package_term_id', 'locale']);
            $table->foreign('package_term_id')->references('id')->on('staking__packageterms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staking__packageterm_translations', function (Blueprint $table) {
            $table->dropForeign(['package_term_id']);
        });
        Schema::dropIfExists('staking__packageterm_translations');
    }
}
