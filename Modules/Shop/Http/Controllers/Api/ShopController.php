<?php

namespace Modules\Shop\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Shop\Entities\Shop;
use Modules\Shop\Repositories\ShopRepository;

class ShopController extends Controller
{
    private $shopRepository;
    public function __construct(
        ShopRepository $shopRepository
    ) {
        $this->shopRepository = $shopRepository;
    }
    public function index()
    {
        return view('shop::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('shop::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->shopRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('shop::shops.messages.shop created'),
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('shop::show');
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

    public function createProduct(Request $request) {
        dd($request);
    }
}
