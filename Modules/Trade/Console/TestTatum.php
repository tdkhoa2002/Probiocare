<?php

namespace Modules\Trade\Console;

use Illuminate\Console\Command;
use Modules\Trade\Libraries\Tatum;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestTatum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'test:tatum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tatumApiKey = setting('trade::tatum_api_key');
        $a = new Tatum($tatumApiKey);
         $b = $a->createVirtualCurrency('PHUC_66',112);
        // $b = $a->createAccount('VC_PHUC_6',2);
        //$b = $a->createTrade("BUY", 1.2, 823456, 'VC_P/BNB', '648c809571c4ceadffb8706d', '648c7384d77f2be11445dbe5');
        //$b = $a->createSubscriptionPartialTradeMatch('649425a5dd9e855735a9ce24', 'https://dashboard.tatum.io/webhook-handler');
        //   $b = $a->sendTransaction();
        //    $c = $a->getBuyTradesBody();
        dd($b);
    }
}
