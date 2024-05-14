<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyPackageTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty__packageterms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('loyalty__packages')->onDelete('cascade');
            $table->integer('day_reward')->default(0);
            $table->double('apr_reward')->default(0);
            $table->double('total_stake')->default(0)->nullable();
            $table->double('max_total_stake')->default(0)->nullable();
            $table->enum('type',['LOCKED', 'FLEXIBLE', 'LOCKED-PRINCIPLE-PREPAID']);
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
        Schema::dropIfExists('loyalty__packageterms');
    }
}