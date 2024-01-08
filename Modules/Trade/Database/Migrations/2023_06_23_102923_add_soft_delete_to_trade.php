<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToTrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade__markets', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('trade__trades', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('trade__tradehistories', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade__markets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('trade__trades', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('trade__tradehistories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
