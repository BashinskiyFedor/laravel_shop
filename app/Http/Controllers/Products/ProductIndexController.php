<?php

namespace App\Http\Controllers\Products;

use App\Domain\Category\Category;
use App\Domain\City\City;
use App\Domain\Product\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class ProductIndexController
{
    public function __invoke(Request $request)
    {
        $products = $this->getProducts();

        $categories = Category::all();
        $cities = City::all();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'cities' => $cities,
            'activeFilterCategory' => $request->filter['category_id'] ?? '',
            'activeFilterCities' => $request->filter['cities'] ?? []
        ]);
    }

    public function getProducts()
    {
        return QueryBuilder::for(Product::class)
                                ->allowedFilters([
                                    AllowedFilter::scope('category_id'),
                                    AllowedFilter::scope('cities'),
                                ])
                                ->paginate();
    }
}
