<?php

namespace Modules\ShoppingCart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\ShoppingCart\Services\Alepay;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\CategoryRepository;
use Modules\ShoppingCart\CartItem;
use Modules\ShoppingCart\Emails\OrderConfirm;
use Modules\ShoppingCart\Facades\Cart;
use Modules\ShoppingCart\Repositories\OrderRepository;
use Modules\ShoppingCart\Repositories\OrderDetailRepository;
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

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        OrderRepository $orderRepository,
        OrderDetailRepository $orderDetailRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
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
            Cart::add([
                'id' => $productId, 'name' => $product->title, 'qty' => 1, 'price' => $product->price_sale,
                'options' => ['avatar' =>  $avatar->path_string, 'slug' => $product->slug, 'code' => $product->code, 'price_old' => $product->price]
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
            Cart::add([
                'id' => $productId, 'name' => $product->title, 'qty' => 1, 'price' => $product->price_sale,
                'options' => ['avatar' =>  $avatar->path_string, 'slug' => $product->slug, 'code' => $product->code, 'price_old' => $product->price]
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
        $plc = 0;
        $subtotal = Cart::subtotalPrice();
        $total = $subtotal + $plc;
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
        $count = Cart::count();
        if ($count == 0) {
            return redirect()->route('fe.shoppingcart.getCart')->withErrors(['message' => 'Giỏ hàng của bạn chưa có sản phẩm nào.']);
        } else {
            $plc = 0;
            $subtotal = Cart::subtotalPrice();
            $total = $subtotal + $plc;
            $carts = Cart::content();
            return view('shoppingCarts.checkout', ['carts' => $carts, 'plc' => $plc, 'total' => number_format($total), 'subtotal' => number_format($subtotal)]);
        }
    }

    public function getAlepay()
    {
        return view('shoppingCarts.alepay.alepay-checkout');
    }

    public function checkout(Request $request)
    {
        try {
            $count = Cart::count();
            $total = Cart::total();
            if ($count > 0 &&  $total > 0) {
                $carts = Cart::content();
                $rand = strtoupper(substr(uniqid(sha1(time())), 0, 10));
                $subtotal = Cart::subtotalPrice();
                $plc = 0;
                $total = $subtotal + $plc;

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
                    'status' => 'CREATED'
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
                // $email = new OrderConfirm($order);
                // Mail::to($request->email)->send($email);
                }
                Cart::destroy();
                return response()->json(['error' => false, 'message' => trans('shoppingcart::orders.messages.order_success'), 'url' => route('fe.shoppingcart.getThankYou', $rand)]);
            } else {
                return response()->json(['error' => true, 'message' => "Giỏ hàng đang trống, hãy chọn mua sản phẩm"]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function alepayPayment(Request $request)
    {
        $params = [
            'amount' => $request->amount,
            'buyerAddress' => $request->buyerAddress,
            'buyerCity' => $request->buyerCity,
            'buyerCountry' => $request->buyerCountry ?? 'Việt Nam',
            'buyerEmail' => $request->buyerEmail,
            'buyerName' => $request->buyerName,
            'buyerPhone' => $request->buyerPhone,
            'cancelUrl' => route('alepay.payment.cancel'),
            'currency' => 'VND',
            'customMerchantId' => '2',
            'orderCode' => $request->orderCode,
            'orderDescription' => $request->orderDescription,
            'paymentHours' => '5',
            'returnUrl' => route('alepay.payment.callback'),
            'totalItem' => $request->totalItem,
            'checkoutType' => 1
        ];

        $alepay = new Alepay();
        $response = $alepay->requestPayment($params);
        //dd($response);
        // Kiểm tra xem có lỗi khi gọi API hay không
        if ($response['code'] !== '000') {
            // Xử lý lỗi nếu cần thiết
            dd($response);
        }
        // Nếu không có lỗi, chuyển hướng người dùng đến trang thanh toán của Alepay
        return redirect($response['checkoutUrl']);
    }

    public function callback(Request $request)
    {
        // Lấy transactionCode từ query parameters hoặc form data
        $transactionCode = $request->query('transactionCode');
        $callbackData = [
            'transactionCode' => $transactionCode
        ];
        // Gọi API get-transaction-info
        $alepay = new Alepay();
        $transactionInfo = $alepay->getTransactionInfo($callbackData);
        if($transactionInfo['code'] !== '000') {
            dd($transactionInfo);
        }
        $transactionInfo['transactionTimeConvert'] = $this->convertMillisecondsToRealTime($transactionInfo['transactionTime']);
        $transactionInfo['successTimeConvert'] = $this->convertMillisecondsToRealTime($transactionInfo['successTime']);
        
        dd($transactionInfo);
        return view('shoppingCarts.alepay.alepay-result', ['callbackData' => $transactionInfo]);
    }

    public function cancel() 
    {
        return redirect()->route('homepage');
    }

    private function convertMillisecondsToRealTime($ms)
    {
        $s = floor($ms / 1000);
        if($s < 60) {
            return $s . ' giây';
        } elseif ($s < 3600) {
            return floor($s / 60) . ' phút';
        }else {
            return floor ($s / 3600) . ' giờ';
        }
    }
}
