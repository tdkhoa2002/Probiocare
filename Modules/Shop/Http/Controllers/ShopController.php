<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Shop\Repositories\ShopRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\CategoryRepository;

class ShopController extends Controller
{
    private $countryRepository;
    private $shopRepository;
    private $productRepository;
    private $cateRepository;

    public function __construct(
        CountryRepository $countryRepository,
        ShopRepository $shopRepository,
        ProductRepository $productRepository,
        CategoryRepository $cateRepository
    ) {
        $this->countryRepository = $countryRepository;
        $this->shopRepository = $shopRepository;
        $this->productRepository = $productRepository;
        $this->cateRepository = $cateRepository;
    }

    public function index()
    {
        return view('shop::index');
    }

    public function create(Request $request)
    {
        $countries = $this->countryRepository->all();
        return view('shops.register', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        try {
            $dataRequest = $request->all();
            $customer = auth()->guard('customer')->user();
            $country = $this->countryRepository->find($dataRequest['country_id']);
            if (!$country) {
                return back()->withErrors(trans('customer::countries.not_found'));
            }

            if ($customer->status == false) {
                return back()->withErrors(trans('customer::customers.message.customer_not_active'));
            } else {
                $shop = $customer->shop;
                if ($shop == null) {
                    $data = [
                        'name' => $dataRequest['name'],
                        'email' => $dataRequest['email'],
                        'country_id' => $dataRequest['country_id'],
                        'phone_number' => $dataRequest['phoneNumber'],
                        'address' => $dataRequest['address'],
                        'description' => $dataRequest['description'],
                        'status' => 0,
                        'image_url' => "",
                        'customer_id' => $customer->id
                    ];
                    $this->shopRepository->create($data);
                    return redirect()
                        ->route('fe.shop.shop.info')
                        ->withSuccess(trans('shop::shops.message.shop_created'));
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function createProduct() {
        try {
            $categories = $this->cateRepository->all();
            return view('shops.create-product', compact('categories'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function storeProduct(Request $request) {
        try {
            $dataRequest = $request->all();
            $customer = auth()->guard('customer')->user();
            $shop = $customer->shop;
            $data = [
                'name' => $dataRequest['name'],
                'code' => $dataRequest['code'],
                'price' => $dataRequest['price'],
                'price_sale' => $dataRequest['price-sale'],
                'status' => 0,
                'description' => $dataRequest['description'],
                'shop_id' => $shop->id
            ];
            $this->productRepository->create($data);
            return redirect()
            ->route('fe.shop.shop.info')
            ->withSuccess(trans('shop::shops.message.product_created'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {
        return view('shops.profile');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('shop::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
