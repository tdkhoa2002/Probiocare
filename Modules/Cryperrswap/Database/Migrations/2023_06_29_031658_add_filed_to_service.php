<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cryperrswap__services', function (Blueprint $table) {
            $table->string('refcode')->nullable();
            $table->float('afftax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cryperrswap__services', function (Blueprint $table) {
            $table->dropColumn(['refcode','afftax']);
        });
    }
}
