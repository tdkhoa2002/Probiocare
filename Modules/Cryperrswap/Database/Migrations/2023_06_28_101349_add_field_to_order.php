<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cryperrswap__orders', function (Blueprint $table) {
            $table->string('order_service_token')->nullable()->after('order_service_id');
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
            $table->dropColumn('order_service_token');
        });
    }
}
