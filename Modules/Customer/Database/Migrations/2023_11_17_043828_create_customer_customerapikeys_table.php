<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCustomerapikeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer__customerapikeys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('ip_whitelist')->nullable();
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customer__customers')->onDelete('cascade');
            $table->string('token', 80)->unique()->index();
            $table->integer('call_count')->default(0);
            $table->timestamp('last_called_at')->nullable();
            $table->timestamp('expired_at')->nullable(); //user set
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_customerapikeys');
    }
}
