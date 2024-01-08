<?php

namespace Modules\Cryperrswap\Console;

use Illuminate\Console\Command;
use Modules\Cryperrswap\Services\FixedFloatApi;

class TestFixedFloar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'test:fixed';

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
        $fixedFloatApi = new FixedFloatApi('aAekfUGRZ64LZjsSeTwTGwOsPxVVbIqDaahkPEUo', 'wpGbjqVgzR1VRjokHxxQMCYTm8N2wgIAGHHZ7hXz');
        $data = $fixedFloatApi->ccies();
        dd($data);
    }
}
