<?php

namespace Modules\Trade\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Trade\Libraries\Tatum;

class CreateHookTatum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'sync:link-hook-tatum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync:link-hook-tatum';

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
        $tatum = new Tatum($tatumApiKey);
        $customerId = $this->argument('customer_id');
        // $link = "https://webhook.site/a90fe85e-c3ab-40d0-b0a8-deadd0df0c97";
        $link = route('wh.trade.trade.handleTrade');
        $tatum->createSubscriptionPartialTradeMatch($customerId, $link);
        $tatum->createSubscriptionTradeMatch($customerId, $link);
    }

    protected function getArguments()
    {
        return [
            ['customer_id', InputArgument::REQUIRED, 'customer_id'],
        ];
    }
}
