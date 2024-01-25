<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty__packages', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('reward');
            $table->dropColumn('cashback');
            $table->dropColumn('day_reward');
            $table->dropColumn('term_matching');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty__packages', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('reward');
            $table->dropColumn('cashback');
            $table->dropColumn('day_reward');
            $table->dropColumn('term_matching');
            $table->dropColumn('status');
        });
    }
}
