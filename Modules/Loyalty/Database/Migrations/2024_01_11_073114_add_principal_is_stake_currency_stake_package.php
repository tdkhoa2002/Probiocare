<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrincipalIsStakeCurrencyStakePackage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty__package', function (Blueprint $table) {
            $table->boolean('principal_is_stake_currency')->nullable()->default(true)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty__package', function (Blueprint $table) {
            $table->dropColumn('principal_is_stake_currency');
        });
    }
}
