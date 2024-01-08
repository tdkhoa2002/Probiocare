<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peertopeer__ads', function (Blueprint $table) {
            $table->boolean('require_kyc')->nullable()->default(false)->after('auto_reply');
            $table->boolean('require_registered')->nullable()->default(false)->after('require_kyc');
            $table->integer('require_registered_day')->nullable()->default(0)->after('require_registered');
            $table->boolean('require_holding')->nullable()->default(false)->after('require_registered_day');
            $table->integer('require_holding_amount')->nullable()->default(0)->after('require_holding');
            $table->renameColumn('fixed_amount', 'fixed_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peertopeer__ads', function (Blueprint $table) {
            $table->dropColumn([
                'require_kyc',
                'require_registered',
                'require_registered_day',
                'require_holding',
                'require_holding_amount'
            ]);
            $table->renameColumn('fixed_price', 'fixed_amount');
        });
    }
}
