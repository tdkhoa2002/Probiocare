<?php

use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Repositories\ProductRepository;

if (!function_exists('getCategoryHomepage')) {
    function getCategoryHomepage()
    {
        return app(CategoryRepository::class)->getCategoryHomepage();
    }
}

if (!function_exists('getCategoryParentHomepage')) {
    function getCategoryParentHomepage()
    {
        return app(CategoryRepository::class)->getCategoryParentHomepage();
    }
}

if (!function_exists('getCategorySidebar')) {
    function getCategorySidebar()
    {
        return app(CategoryRepository::class)->getCategorySidebar();
    }
}

if (!function_exists('getCategoryMenu')) {
    function getCategoryMenu()
    {
        return app(CategoryRepository::class)->getCategoryMenu();
    }
}

if (!function_exists('getProductNewArrivals')) {
    function getProductNewArrivals()
    {
        return app(ProductRepository::class)->getProductNewArrivals();
    }
}

if (!function_exists('getAllProducts')) {
    function getAllProducts()
    {
        return app(ProductRepository::class)->getAllProducts();
    }
}

if (!function_exists('getProductBestSelling')) {
    function getProductBestSelling()
    {
        return app(ProductRepository::class)->getProductBestSelling();
    }
}
if (!function_exists('getProductEditorChoice')) {
    function getProductEditorChoice()
    {
        return app(ProductRepository::class)->getProductEditorChoice();
    }
}

if (!function_exists('getProductSeen')) {
    function getProductSeen()
    {
        $product_seen = session('product_seen');
        if (is_array($product_seen) && count($product_seen) > 0) {
            return app(ProductRepository::class)->getProductByIds($product_seen);
        } else {
            return [];
        }
    }
}
if (!function_exists('calPercent')) {
    function calPercent($price, $price2)
    {
        $num = ($price2 / $price) * 100;
        return ceil(100 - $num);
    }
}
