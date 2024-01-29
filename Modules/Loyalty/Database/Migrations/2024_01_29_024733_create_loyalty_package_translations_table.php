<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyPackageTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('loyalty__package_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->text('description');
            $table->integer('package_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['package_id', 'locale']);
            $table->foreign('package_id')->references('id')->on('loyalty__packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty__package_translations', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
        });
        Schema::dropIfExists('loyalty__package_translations');
    }
}
