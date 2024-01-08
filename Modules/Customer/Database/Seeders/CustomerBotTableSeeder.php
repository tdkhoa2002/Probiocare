<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerBotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bot = array('email' => 'bot@gmail.com', 'password' => 'botpassword', 'ref_code' => 'bot');
        DB::table('customer__customers')->insert($bot);
    }
}
