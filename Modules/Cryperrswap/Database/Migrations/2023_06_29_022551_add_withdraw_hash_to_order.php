<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWithdrawHashToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cryperrswap__orders', function (Blueprint $table) {
            $table->string('to_hash')->nullable();
            $table->string('from_hash')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cryperrswap__orders', function (Blueprint $table) {
            $table->dropColumn(['to_hash', 'from_hash']);
        });
    }
}
