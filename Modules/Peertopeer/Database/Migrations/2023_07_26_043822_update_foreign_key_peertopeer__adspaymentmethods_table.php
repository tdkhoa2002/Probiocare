<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForeignKeyPeertopeerAdspaymentmethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peertopeer__adspaymentmethods', function (Blueprint $table) {
            $table->dropForeign(['paymentmethod_id']);
            $table->foreign('paymentmethod_id')->references('id')->on('paymentmethod_customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peertopeer__adspaymentmethods', function (Blueprint $table) {
            $table->dropForeign(['paymentmethod_id']);
            $table->foreign('paymentmethod_id')->references('id')->on('paymentmethods')->onDelete('cascade');
        });
    }
}
