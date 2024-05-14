<?php

namespace Modules\Loyalty\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Customer\Helpers\CustomerHelper;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\IncreaseBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Loyalty\Repositories\OrderRepository;
use Modules\Customer\Repositories\CustomerRepository;

class CalCommissionLoyalty implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $order = app(OrderRepository::class)->find($this->orderId);
            $term = $order->term;
            $package = $term->package;
            $commissions =  $package->commissions;
            $customer = app(CustomerRepository::class)->find($order->customer_id);
            $customerFloors = CustomerHelper::getParentCustomer($customer);
            $currencyStake = $package->currencyStake;
            $requireEntry = $package->require_entry;
            foreach ($commissions as $commission) {
                $key = array_search(1, array_column($customerFloors, 'level'));
                if ($key !== false && isset($customerFloors[$key]) && $commission->commission != 0) {
                    $cus = $customerFloors[$key];
                    if($requireEntry === 1) {
                        $checkCusOrder = app(OrderRepository::class)->findByAttributes([
                            'customer_id' => $cus['id'],
                            // 'packageterm_id' => $term->id
                        ]);
                        if(!$checkCusOrder) {
                            continue;
                        }
                    }
                    $this->hanldeCalcommission($cus, $order, $commission, $currencyStake);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }

    private function hanldeCalcommission($customer, $order, $commission, $currencyStake)
    {
        try {
            $amount = $commission->commission;
            if ($commission->type == 1) {
                $amount = ($order->amount_stake * $commission->commission) / 100;
            }

            $checkTransaction = app(TransactionRepository::class)->findByAttributes([
                'customer_id' => $customer['id'],
                'currency_id' => $currencyStake->id,
                'order' => $order->id,
                'action' => TypeTransactionActionEnum::COMMISSION_LOYALTY,
            ]);
            if (!$checkTransaction) {
                event(new IncreaseBalanceWallet($amount, $customer['id'], $currencyStake->id, TypeTransactionActionEnum::COMMISSION_LOYALTY, $order->id));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }
}
