<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer__customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('email');
            $table->string('password');
            $table->string('ref_code');
            $table->string('gg_auth')->nullable();
            $table->tinyInteger('status_gg_auth')->nullable()->default(0);
            $table->tinyInteger('status_kyc')->nullable()->default(0);
            $table->unsignedInteger('sponsor_id')->nullable();
            $table->integer('sponsor_floor')->nullable()->default(0);
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('customer__customers');
    }
}
