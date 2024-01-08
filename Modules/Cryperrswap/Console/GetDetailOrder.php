<?php

namespace Modules\Cryperrswap\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Cryperrswap\Repositories\OrderRepository;
use Modules\Cryperrswap\Services\FixedFloatApi;

class GetDetailOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'get-detail:order';

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
        $orders = $this->orderRepository->getOrderProccess();
        foreach ($orders as $order) {
            $currency = $order->fromCurrency;
            if ($currency) {
                $service = $currency->service;
                if ($service) {
                    $fixedFloatApi = new FixedFloatApi($service->api_key, $service->serect_key);
                    $statusOrder = $fixedFloatApi->order(['id' => $order->order_service_id, 'token' => $order->order_service_token]);
                    if (isset($statusOrder['error']) && $statusOrder['error'] == true) {
                        \Log::error("GetDetailOrder:", $statusOrder['message']);
                    } else {
                        if (isset($statusOrder['status'])) {
                            $dataUpdate = [
                                'status' => $statusOrder['status']
                            ];

                            if ($statusOrder['status'] == 'DONE') {
                                $dataUpdate['to_hash'] = $statusOrder['to']['tx']['id'];
                                $dataUpdate['from_hash'] = $statusOrder['from']['tx']['id'];
                            }
                            $this->orderRepository->update($order, $dataUpdate);
                        }
                    }
                }
            }
        }
    }
}
