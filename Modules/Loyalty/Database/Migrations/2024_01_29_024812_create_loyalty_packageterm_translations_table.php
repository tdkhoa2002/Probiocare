<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyPackagetermTranslationsTable extends Migration
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
            $table->integer('packageterm_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['packageterm_id', 'locale']);
            $table->foreign('packageterm_id')->references('id')->on('loyalty__packageterms')->onDelete('cascade');
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
            $table->dropForeign(['packageterm_id']);
        });
        Schema::dropIfExists('loyalty__packageterm_translations');
    }
}
