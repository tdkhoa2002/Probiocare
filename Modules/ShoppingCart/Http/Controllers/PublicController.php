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

    public function addToCart(Request $request)
    {
        $productId = $request->productId;
        $product = $this->productRepository->findByAttributes(['id' => $productId, 'status' => true]);
        if ($product) {
            if ($product->product_status == 3) {
                return response()->json(['error' => true, 'message' => "Sản phẩm đã hết hàng."]);
            }
            $avatar = $product->getAvatar();
            Cart::add([
                'id' => $productId, 'name' => $product->title, 'qty' => 1, 'price' => $product->price_sale,
                'options' => ['avatar' =>  $avatar->path_string, 'slug' => $product->slug, 'code' => $product->code, 'price_old' => $product->price]
            ]);
            return response()->json(['error' => false, 'message' => "Thêm vào giỏ hàng thành công.", 'count' => Cart::count(), 'title' => $product->title]);
        } else {
            return response()->json(['error' => true, 'message' => "Sản phẩm không tồn tại."]);
        }
    }

    public function deleteItem(Request $request)
    {
        try {
            $rowId = $request->rowId;
            Cart::remove($rowId);
            $total = Cart::total();
            return response()->json(['error' => false, 'total' =>  $total, 'count' => Cart::count()]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateQty(Request $request)
    {
        try {
            $rowId = $request->rowId;
            Cart::update($rowId, $request->qty);
            $total = Cart::total();
            return response()->json(['error' => false, 'total' =>  $total, 'count' => Cart::count()]);
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
        $total = Cart::total();
        $carts = Cart::content();
        return view('shoppingCarts.cart', compact('carts', 'total'));
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
            $total = Cart::total();
            $carts = Cart::content();
            return view('shoppingCarts.checkout', compact('carts', 'total'));
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
                    'fullname' => $request->customer_name,
                    'email' => $request->customer_email,
                    'phone_number' => $request->customer_phone,
                    'address' => $request->customer_address . ',' . $request->city,
                    'note' => $request->customer_note,
                    'total' => $total,
                    'time_ship' => $request->time_ship,
                    'payment_method' => $request->payment_method,
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
                Mail::to($request->customer_email)->send($email);
                Cart::destroy();
                return response()->json(['error' => false, 'message' => "Đặt hàng thành công", 'url' => route('fe.shoppingcart.getThankYou', $rand)]);
            } else {
                return response()->json(['error' => true, 'message' => "Giỏ hàng đang trống, hãy chọn mua sản phẩm"]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
