<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxTotalStakeStaking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staking__packageterms', function (Blueprint $table) {
            $table->double('max_total_stake')->default(0)->nullable()->after('total_stake');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staking__packageterms', function (Blueprint $table) {
            $table->dropColumn('max_total_stake');
        });
    }
}
