<?php

namespace Modules\ShoppingCart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Jobs\JobSendEmailCodeLogin;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\CategoryRepository;
use Modules\ShoppingCart\CartItem;
use Modules\ShoppingCart\Emails\OrderConfirm;
use Modules\ShoppingCart\Enums\StatusOrderEnum;
use Modules\ShoppingCart\Facades\Cart;
use Modules\ShoppingCart\Repositories\OrderRepository;
use Modules\ShoppingCart\Repositories\OrderDetailRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\ShoppingCart\Services\Alepay;
use Srmklive\PayPal\Services\Paypal as PayPalClient;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;


class PublicController extends BasePublicController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    private $categoryRepository;
    private $orderRepository;
    private $orderDetailRepository;
    private $customerRepository;
    private $walletRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        OrderRepository $orderRepository,
        OrderDetailRepository $orderDetailRepository,
        CustomerRepository $customerRepository,
        WalletRepository $walletRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->customerRepository = $customerRepository;
        $this->walletRepository = $walletRepository;
    }

    public function quickBuy(Request $request)
    {
        $productId = $request->productId;
        $product = $this->productRepository->findByAttributes(['id' => $productId, 'status' => true]);
        if ($product) {
            if ($product->product_status == 3) {
                return response()->json(['error' => true, 'message' => trans('product::products.messages.outofstock')]);
            }
            $avatar = $product->getAvatar();
            $authCheck = auth()->guard('customer')->check();
            $price = $product->price;
            if ($authCheck && $product->price_member > 0) {
                $price = $product->price_member;
            }
            Cart::add([
                'id' => $productId, 'name' => $product->title, 'qty' => 1, 'price' => $price,
                'options' => ['avatar' =>  $avatar->path_string, 'slug' => $product->slug, 'code' => $product->code, 'price_old' => $product->price_sale]
            ]);
            return response()->json(['error' => false, 'message' =>  trans('shoppingcart::orders.messages.add_product_success'), 'url' => route('fe.shoppingcart.getCart')]);
        } else {
            return response()->json(['error' => true, 'message' => trans('product::products.messages.not_found')]);
        }
    }

    public function addToCart(Request $request)
    {
        $productId = $request->productId;
        $product = $this->productRepository->findByAttributes(['id' => $productId, 'status' => true]);
        if ($product) {
            if ($product->product_status == 3) {
                return response()->json(['error' => true, 'message' => trans('product::products.messages.outofstock')]);
            }
            $avatar = $product->getAvatar();
            $authCheck = auth()->guard('customer')->check();
            $price = $product->price;
            if ($authCheck && $product->price_member > 0) {
                $price = $product->price_member;
            }
            Cart::add([
                'id' => $productId, 'name' => $product->title, 'qty' => 1, 'price' => $price,
                'options' => ['avatar' =>  $avatar->path_string, 'slug' => $product->slug, 'code' => $product->code, 'price_old' => $product->price_sale]
            ]);
            return response()->json(['error' => false, 'message' =>  trans('shoppingcart::orders.messages.add_product_success'), 'count' => Cart::count(), 'title' => $product->title]);
        } else {
            return response()->json(['error' => true, 'message' => trans('product::products.messages.not_found')]);
        }
    }

    public function deleteItem(Request $request)
    {
        try {
            $rowId = $request->rowId;
            Cart::remove($rowId);
            $plc = 0;
            $subtotal = Cart::subtotalPrice();
            $total = $subtotal + $plc;
            return response()->json(['error' => false, 'total' => number_format($total), 'subtotal' => number_format($subtotal)]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateQty(Request $request)
    {
        try {
            $plc = 0;
            $rowId = $request->rowId;
            Cart::update($rowId, $request->qty);
            $subtotal = Cart::subtotalPrice();
            $total = $subtotal + $plc;
            $cart = Cart::get($rowId);
            $rowTotal = $cart->price * $request->qty;
            return response()->json(['error' => false, 'total' => number_format($total), 'subtotal' => number_format($subtotal), 'count' => Cart::count(), 'rowTotal' => number_format($rowTotal)]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function loadCart()
    {
        try {
            return response()->json(['html' => view('partials.cart')->render()]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getCart()
    {
        $customer = auth()->guard('customer')->user();
        $wallet = $this->walletRepository->findByAttributes([
            'customer_id' => $customer->id,
            'currency_id' => 2
        ]);
        if(!$wallet) {
            $plc = 0;
        } else {
            $plc = $wallet->balance;
        }
        $subtotal = Cart::subtotalPrice();
        $total = $subtotal - $plc;
        $carts = Cart::content();
        return view('shoppingCarts.cart', ['carts' => $carts, 'plc' => $plc, 'total' => number_format($total), 'subtotal' => number_format($subtotal)]);
    }

    public function getThankYou($code)
    {
        $order = $this->orderRepository->findByAttributes(['order_code' => $code]);
        if ($order) {
            return view('shoppingCarts.thank-you', compact('code'));
        } else {
            return redirect()->route('homepage');
        }
    }

    public function getPaymentFail($code)
    {
        $order = $this->orderRepository->findByAttributes(['order_code' => $code]);
        if ($order) {
            return view('shoppingCarts.payment-fail', compact('code'));
        } else {
            return redirect()->route('homepage');
        }
    }

    public function getDetailCart($code)
    {
        $order = $this->orderRepository->findByAttributes(['order_code' => $code]);
        if ($order) {
            $orderDetails = $order->orderDetails;
            return view('shoppingCarts.detail', compact('code', 'order', 'orderDetails'));
        } else {
            return redirect()->route('homepage');
        }
    }


    public function getCheckout()
    {
        $customer = auth()->guard('customer')->user();
        $count = Cart::count();
        if ($count == 0) {
            return redirect()->route('fe.shoppingcart.getCart')->withErrors(['message' => 'Giỏ hàng của bạn chưa có sản phẩm nào.']);
        } else {
            $wallet = $this->walletRepository->findByAttributes([
                'customer_id' => $customer->id,
                'currency_id' => 2
            ]);
            if(!$wallet) {
                $plc = 0;
            } else {
                $plc = $wallet->balance;
            }
            $subtotal = Cart::subtotalPrice();
            $total = $subtotal - $plc;
            $carts = Cart::content();
            return view('shoppingCarts.checkout', ['carts' => $carts, 'plc' => $plc, 'total' => number_format($total), 'subtotal' => number_format($subtotal)]);
        }
    }

    public function checkout(Request $request)
    {
        try {
            $customer = $customer = auth()->guard('customer')->user();
            $count = Cart::count();
            $total = Cart::total();
            if ($count > 0 &&  $total > 0) {
                $carts = Cart::content();
                $rand = strtoupper(substr(uniqid(sha1(time())), 0, 10));
                $subtotal = Cart::subtotalPrice();
                $wallet = $this->walletRepository->findByAttributes([
                    'customer_id' => $customer->id,
                    'currency_id' => 2
                ]);
                if(!$wallet) {
                    $plc = 0;
                } else {
                    $plc = $wallet->balance;
                }
                $total = $subtotal - $plc;

                $order = [
                    'order_code' => $rand,
                    'fullname' => $request->full_name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'note' => null,
                    'total' => $total,
                    'time_ship' => null,
                    'payment_method' => $request->payment_method,
                    'delivery_method' => $request->delivery_method,
                    'status' => StatusOrderEnum::CREATED
                ];
                $order = $this->orderRepository->create($order);
                foreach ($carts as $cart) {
                    $orderDetail = [
                        'order_id' => $order->id,
                        'product_id' => $cart->id,
                        'price' => $cart->price,
                        'qty' => $cart->qty,
                        'total' => $cart->price * $cart->qty
                    ];
                    $this->orderDetailRepository->create($orderDetail);
                    //
                    $product = $this->productRepository->find($cart->id);
                    $rq = [
                        'total_sold' => $product->total_sold + $cart->qty
                    ];
                    
                    $updatedProduct = $this->productRepository->update($product, $rq);
                }
                if ($request->payment_method == 3 || $request->payment_method == 2) {
                    return $this->hanldeCheckoutAlepay($order);
                } elseif ($request->payment_method == 4) {
                    return $this->processTransaction($order);
                } else {
                    $email = new OrderConfirm($order);
                    Mail::to($request->email)->send($email);
                    Cart::destroy();
                    return response()->json(['error' => false, 'message' => trans('shoppingcart::orders.messages.order_success'), 'url' => route('fe.shoppingcart.getThankYou', $rand)]);
                }
            } else {
                return response()->json(['error' => true, 'message' => "Giỏ hàng đang trống, hãy chọn mua sản phẩm"]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function createTransaction() {
        return view('shoppingCarts.paypal');
    }

    public function processTransaction() {
        try {
            
            $auth = auth()->guard('customer')->user();
            $customer = $auth->profile;
            // dd($auth);
            $fullname = $auth->profile->getFullNameAttribute();
            //
            $count = Cart::count();
            $total = Cart::total();
            if ($count > 0 &&  $total > 0) {
                //Send email when pay
                // $isEmail = true;
                // $customerEmail = $this->customerRepository->findByAttributes(['email' => $auth["email"]]);
                // if ($customerEmail->status_gg_auth == 2) {
                //     $isEmail = false;
                // }
                // if ($isEmail) {
                //     JobSendEmailCodeLogin::dispatch($customerEmail);
                // }
                //
                $carts = Cart::content();
                $rand = strtoupper(substr(uniqid(sha1(time())), 0, 10));
                $subtotal = Cart::subtotalPrice();
                $wallet = $this->walletRepository->findByAttributes([
                    'customer_id' => $auth->id,
                    'currency_id' => 2
                ]);
                if(!$wallet) {
                    $plc = 0;
                } else {
                    $plc = $wallet->balance;
                }
                $total = $subtotal - $plc;

                $order = [
                    'order_code' => $rand,
                    'fullname' => $fullname,
                    'email' => $auth->email,
                    'phone_number' => $customer->phone_number,
                    'address' => $customer->address,
                    'note' => null,
                    'total' => $total,
                    'time_ship' => null,
                    'payment_method' => 1,
                    'delivery_method' => 1,
                    'status' => StatusOrderEnum::PAYMENT_COMPLETED
                ];
                $order = $this->orderRepository->create($order);
                foreach ($carts as $cart) {
                    $orderDetail = [
                        'order_id' => $order->id,
                        'product_id' => $cart->id,
                        'price' => $cart->price,
                        'qty' => $cart->qty,
                        'total' => $cart->price * $cart->qty
                    ];
                    $this->orderDetailRepository->create($orderDetail);
                    //
                    $product = $this->productRepository->find($cart->id);
                    $rq = [
                        'total_sold' => $product->total_sold + $cart->qty
                    ];
                    
                    $updatedProduct = $this->productRepository->update($product, $rq);
                }
            }
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route("fe.shoppingcart.successTransaction", ['order_code' => $order->order_code]),
                    "cancel_url" => route("fe.shoppingcart.cancelTransaction"),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => 1 //$total
                        ]
                    ]
                ]
            ]);
            
            if(isset($response["id"]) && $response['id'] != null) {
                foreach($response['links'] as $links) {
                    if($links['rel'] == 'approve') {
                        $approvalUrl = $links['href'];
                        break;
                    }
                }
                if($approvalUrl) {
                    return redirect()->away($approvalUrl);
                } else {
                    return redirect()->route('fe.shoppingcart.getCart')->with('error', 'Something went wrong.');
                }
            } else {
                return redirect()->route('fe.shoppingcart.getCart')->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function successTransaction($order_code, Request $request) {
        // dd($request);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        Cart::destroy();
        $order = $this->orderRepository->findByAttributes(['order_code' => $order_code, 'status' => StatusOrderEnum::PAYMENTING]);
        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            $this->orderRepository->update($order, ['status' => StatusOrderEnum::PAYMENT_COMPLETED]);
            return redirect()->route('fe.shoppingcart.getThankYou', $order_code)->with('success', 'Transaction complete.');
        } else {
            $this->orderRepository->update($order, ['status' => StatusOrderEnum::PAYMENT_FAILED]);
            return response()->json(['error' => true, 'message' => trans('shoppingcart::orders.messages.order_payment_fail'), 'url' => route('fe.shoppingcart.alepayCheckoutFail', $order->order_code)]);
        }
    }

    public function cancelTransaction(Request $request) {
        return redirect()->route('fe.shoppingcart.getCart')->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    private function hanldeCheckoutAlepay($order)
    {
        try {
            $alepay = new Alepay;
            $dataRequest = [
                'orderDescription' => $order->order_code,
                'orderCode' => $order->order_code,
                'amount' => $order->total,
                'currency' => 'VND',
                'totalItem' => $order->orderDetails->count(),
                'returnUrl' => route('fe.shoppingcart.alepayCheckoutSuccess', $order->order_code),
                'cancelUrl' => route('fe.shoppingcart.alepayCheckoutFail', $order->order_code),
                'buyerName' => $order->fullname,
                'buyerEmail' => $order->email,
                'buyerPhone' => $order->phone_number,
                'buyerAddress' => $order->address,
                'buyerCity' => 'Ho Chi Minh',
                'buyerCountry' => 'Viet Nam',
                'allowDomestic' => true,
                'checkoutType' => 3
            ];

            $data = $alepay->requestPayment($dataRequest);
            Cart::destroy();
            if ($data !== false && isset($data->code) && $data->code == "000") {
                $this->orderRepository->update($order, ['payment_code' => $data->transactionCode, 'status' => StatusOrderEnum::PAYMENTING]);
                return response()->json(['error' => false, 'message' => trans('shoppingcart::orders.messages.order_success'), 'type' => 'alepay', 'url' => $data->checkoutUrl]);
            } else {
                $this->orderRepository->update($order, ['payment_code' => $data->transactionCode, 'status' => StatusOrderEnum::PAYMENT_FAILED]);
                return response()->json(['error' => true, 'message' => trans('shoppingcart::orders.messages.order_payment_fail'), 'url' => route('fe.shoppingcart.alepayCheckoutFail', $order->order_code)]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function alepayCheckoutSuccess($order_code, Request $request)
    {
        if (isset($request->transactionCode) && isset($request->errorCode) && $request->errorCode == '000') {
            $order = $this->orderRepository->findByAttributes(['order_code' => $order_code, 'status' => StatusOrderEnum::PAYMENTING, 'payment_code' => $request->transactionCode]);
            if ($order) {
                Mail::to($order->email)->send(new OrderConfirm($order));
                $this->orderRepository->update($order, ['status' => StatusOrderEnum::PAYMENT_COMPLETED]);
                return redirect()->route('fe.shoppingcart.getThankYou', $order_code)->withError(trans('shoppingcart::orders.messages.order_payment_success'));
            } else {
                return redirect()->route('homepage')->withErrors(trans('shoppingcart::orders.messages.order_not_found'));
            }
        } else {
            return redirect()->route('homepage')->withErrors(trans('shoppingcart::orders.messages.order_not_found'));
        }
    }

    public function alepayCheckoutFail($order_code)
    {
        $order = $this->orderRepository->findByAttributes(['order_code' => $order_code]);
        if ($order) {
            $this->orderRepository->update($order, ['status' => StatusOrderEnum::PAYMENT_FAILED]);
            return redirect()->route('fe.shoppingcart.getPaymentFail', $order_code)->withError(trans('shoppingcart::orders.messages.order_payment_fail'));
        } else {
            return redirect()->route('homepage')->withErrors(trans('shoppingcart::orders.messages.order_not_found'));
        }
    }

    public function connectWallet() {
        $response = Http::acceptJson()->get(config('wallet.api_connect_wallet'));
        if ($response->successful()) {
            return $response->json();
        } else {
            return false;
        }
    }

    public function buyProductWeb3(Request $request) {
        try {
            $auth = auth()->guard('customer')->user();
            $customer = $auth->profile;
            $fullname = $auth->profile->getFullNameAttribute();
            //
            $count = Cart::count();
            $total = Cart::total();
            if ($count > 0 &&  $total > 0) {
                $carts = Cart::content();
                $rand = strtoupper(substr(uniqid(sha1(time())), 0, 10));
                $subtotal = Cart::subtotalPrice();
                $wallet = $this->walletRepository->findByAttributes([
                    'customer_id' => $auth->id,
                    'currency_id' => 2
                ]);
                if(!$wallet) {
                    $plc = 0;
                } else {
                    $plc = $wallet->balance;
                }
                $total = $subtotal - $plc;

                $order = [
                    'order_code' => $rand,
                    'fullname' => $fullname,
                    'email' => $auth->email,
                    'phone_number' => $customer->phone_number,
                    'address' => $customer->address,
                    'note' => null,
                    'total' => $total,
                    'time_ship' => null,
                    'payment_method' => 1,
                    'delivery_method' => 1,
                    'status' => StatusOrderEnum::PAYMENT_COMPLETED
                ];
                $order = $this->orderRepository->create($order);
                foreach ($carts as $cart) {
                    $orderDetail = [
                        'order_id' => $order->id,
                        'product_id' => $cart->id,
                        'price' => $cart->price,
                        'qty' => $cart->qty,
                        'total' => $cart->price * $cart->qty
                    ];
                    $this->orderDetailRepository->create($orderDetail);
                    //
                    $product = $this->productRepository->find($cart->id);
                    $rq = [
                        'total_sold' => $product->total_sold + $cart->qty
                    ];
                    
                    $updatedProduct = $this->productRepository->update($product, $rq);
                }
                if ($order) {
                    Cart::destroy();
                    return redirect()->route('fe.shoppingcart.getThankYou', $rand)->with('success', 'Transaction complete.');
                } else {
                    return redirect()->route('homepage');
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
