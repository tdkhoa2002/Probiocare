<?php

namespace Modules\Staking\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Customer\Helpers\CustomerHelper;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Staking\Repositories\OrderRepository;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\IncreaseBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;

class CalCommissionStake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'cal:commission-stake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    protected $customerRepository;
    protected $orderRepository;
    protected $transactionRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository,
        TransactionRepository $transactionRepository
    ) {
        parent::__construct();
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $orderId = $this->argument('orderId');

            $order = $this->orderRepository->find($orderId);
            if ($order) {
                $term = $order->term;
                $package = $term->package;
                $commissions =  $package->commissions;
                $customer = $this->customerRepository->find($order->customer_id);
                $customerFloors = CustomerHelper::getParentCustomer($customer);
                $currencyStake = $package->currencyStake;
                foreach ($commissions as $commission) {
                    $key = array_search($commission->level, array_column($customerFloors, 'level'));
                    if ($key !== false && isset($customerFloors[$key]) && $commission->commission != 0) {
                        $cus = $customerFloors[$key];
                        $this->hanldeCalcommission($cus, $order, $commission, $currencyStake);
                    }
                }
            } else {
                return "order not found";
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    private function hanldeCalcommission($customer, $order, $commission, $currencyStake)
    {
        $amount = $commission->commission;
        if ($commission->type == 1) {
            $amount = ($order->amount_stake * $commission->commission) / 100;
        }

        $checkTransaction = $this->transactionRepository->findByAttributes([
            'customer_id' => $customer['id'],
            'currency_id' => $currencyStake->id,
            'order' => $order->id,
            'action' => TypeTransactionActionEnum::COMMISSION_STAKING,
        ]);
        if (!$checkTransaction) {
            event(new IncreaseBalanceWallet($amount, $customer['id'], $currencyStake->id, TypeTransactionActionEnum::COMMISSION_STAKING, $order->id));
        }
    }

    protected function getArguments()
    {
        return [
            ['orderId', InputArgument::REQUIRED, 'orderId'],
        ];
    }
}
