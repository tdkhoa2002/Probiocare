<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldShowPaymentmethod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paymentmethod_attrs', function (Blueprint $table) {
            $table->enum('type', ['text', 'number', 'email'])->default('text')->after('is_require');
            $table->boolean('is_show')->nullable()->default(false)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymentmethod_attrs', function (Blueprint $table) {
            $table->dropColumn(['type', 'is_show']);
        });
    }
}
