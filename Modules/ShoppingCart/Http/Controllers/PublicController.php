<?php

namespace Modules\ShoppingCart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\CategoryRepository;
use Modules\ShoppingCart\CartItem;
use Modules\ShoppingCart\Emails\OrderConfirm;
use Modules\ShoppingCart\Facades\Cart;
use Modules\ShoppingCart\Repositories\OrderRepository;
use Modules\ShoppingCart\Repositories\OrderDetailRepository;

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
            return response()->json(['error' => false, 'total' => number_format( $total), 'subtotal' => number_format($subtotal), 'count' => Cart::count(), 'rowTotal' => number_format($rowTotal)]);
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
            $subtotal = Cart::subtotal(0);
            $total = $subtotal + $plc;
            $carts = Cart::content();
            return view('shoppingCarts.checkout', compact('carts', 'total', 'plc', 'subtotal'));
        }
    }

    public function checkout(Request $request)
    {
        try {
            $count = Cart::count();
            $total = Cart::total();
            if ($count > 0 &&  $total > 0) {
                $carts = Cart::content();
                $rand = strtoupper(substr(uniqid(sha1(time())), 0, 10));
                $total = $carts->reduce(function ($total, CartItem $cartItem) {
                    return $total + ($cartItem->qty * $cartItem->price);
                }, 0);

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
                }
                $email = new OrderConfirm($order);
                Mail::to($request->email)->send($email);
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
}
