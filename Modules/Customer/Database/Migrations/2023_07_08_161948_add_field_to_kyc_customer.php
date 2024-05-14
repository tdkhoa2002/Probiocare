<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToKycCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer__customerkycs', function (Blueprint $table) {
            $table->unsignedInteger('country_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday');
            $table->text('reason')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer__customerkycs', function (Blueprint $table) {
            $table->dropColumn(['country_id', 'first_name', 'last_name', 'birthday']);
        });
    }
}
