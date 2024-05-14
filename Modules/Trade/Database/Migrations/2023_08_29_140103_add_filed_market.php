<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledMarket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade__markets', function (Blueprint $table) {
            $table->double('volume_pair_24h')->nullable()->default(0)->after('volume_24h');
            $table->string('service_base_code')->nullable()->after('volume_pair_24h');
            $table->string('service_base_id')->nullable()->after('service_base_code');
            $table->string('service_quote_code')->nullable()->after('service_base_id');
            $table->string('service_quote_id')->nullable()->after('service_quote_code');
            $table->string('service_customer_id')->nullable()->after('service_quote_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade__markets', function (Blueprint $table) {
            $table->dropColumn([
                'volume_pair_24h',
                'service_base_code',
                'service_base_id',
                'service_quote_code',
                'service_quote_id',
                'service_customer_id'
            ]);
        });
    }
}
