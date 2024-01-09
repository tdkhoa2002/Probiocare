<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Transformers\FullProductTransformer;
use Modules\Product\Transformers\ProductTransformer;
use Modules\Product\Transformers\SmallProductTransformer;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function indexServerSide(Request $request)
    {
        return ProductTransformer::collection($this->product->serverPaginationFilteringFor($request));
    }

    public function store(CreateProductRequest $request)
    {
        $this->product->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('product::products.messages.product created'),
        ]);
    }

    public function find(Request $request)
    {
        $productId = $request->productId;
        $product = $this->product->find($productId);
        return new FullProductTransformer($product);
    }

    public function update($productId, UpdateProductRequest $request)
    {
        $product = $this->product->find($productId);
        $this->product->update($product, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('product::products.messages.product updated'),
        ]);
    }

    public function destroy(Request $request)
    {
        $productId = $request->productId;
        $product = $this->product->find($productId);
        $this->product->destroy($product);
        return response()->json([
            'errors' => false,
            'message' => trans('product::products.messages.product deleted'),
        ]);
    }
}
