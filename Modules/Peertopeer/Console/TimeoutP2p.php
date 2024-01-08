<?php

namespace Modules\Peertopeer\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Peertopeer\Repositories\OrderRepository;

class TimeoutP2p extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'cronjob:timeout-p2p';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    protected $orderRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderRepository $orderRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $orders = $this->orderRepository->getOrderPending();
            foreach ($orders  as $order) {
                $ads = $order->ad;
                $timeout = Carbon::parse($order->created_at)->addMinutes($ads->payment_time_limit);
                if ($timeout->isBefore(now())) {
                    $this->orderRepository->update($order, ['status' => 4]);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
