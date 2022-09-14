<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain\Product\Product;
use App\Domain\Category\Category;
use App\Domain\City\City;
use App\Domain\Product\CategoryProduct;
use App\Domain\Product\CityProduct;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    // - Фильтр по категории – должен позволять выбрать только одну категорию товаров.
    // - Фильтр по городу – должен позволять выбрать один или несколько городов, в которых есть нужный товар.
    // - Можно выбрать категорию и города одновременно.

    public function testFilterByCategory()
    {

        $categories = Category::factory(2)->create();
        $categoriesKeys = collect($categories->modelKeys());

        $cities = City::factory(3)->create();
        $citiesKeys = collect($cities->modelKeys());

        for ($i = 0; $i <= 50; $i++) {
            $products = Product::factory(1)->create();
            $productKeys = collect($products->modelKeys());

            foreach ($productKeys as $key) {
                CategoryProduct::factory([
                    'category_id' => $categoriesKeys->random(),
                    'product_id' => $key
                ])->create();

                CityProduct::factory([
                    'city_id' => $citiesKeys->random(),
                    'product_id' => $key
                ])->create();
            }
        }

        $response = $this->call("GET", "/", ['filter' => ['category_id' => $categories->first()->id]]);


        $products = Product::query()->whereHas('categories', fn($q) => $q->where('categories.id', $categories->first()->id))->paginate();

        $this->assertEquals($response->getOriginalContent()->getData()['products'], $products);

    }

    public function testFilterByCities()
    {

        $categories = Category::factory(2)->create();
        $categoriesKeys = collect($categories->modelKeys());

        $cities = City::factory(3)->create();
        $citiesKeys = collect($cities->modelKeys());
        $citiesKeysArray = $citiesKeys->toArray();

        for ($i = 0; $i <= 50; $i++) {
            $products = Product::factory(1)->create();
            $productKeys = collect($products->modelKeys());

            foreach ($productKeys as $key) {
                CategoryProduct::factory([
                    'category_id' => $categoriesKeys->random(),
                    'product_id' => $key
                ])->create();

                CityProduct::factory([
                    'city_id' => $citiesKeys->random(),
                    'product_id' => $key
                ])->create();
            }
        }

        $response = $this->call("GET", "/", ['filter' => ['cities' => $citiesKeysArray]]);


        $products = Product::query()->whereHas('cities', fn($q) => $q->whereIn('cities.id', $citiesKeysArray))->paginate();

        $this->assertEquals($response->getOriginalContent()->getData()['products'], $products);

    }

    public function testFilterByCitiesAndCategories()
    {
        $categories = Category::factory(2)->create();
        $categoriesKeys = collect($categories->modelKeys());

        $cities = City::factory(3)->create();
        $citiesKeys = collect($cities->modelKeys());
        $citiesKeysArray = $citiesKeys->toArray();

        for ($i = 0; $i <= 50; $i++) {
            $products = Product::factory(1)->create();
            $productKeys = collect($products->modelKeys());

            foreach ($productKeys as $key) {
                CategoryProduct::factory([
                    'category_id' => $categoriesKeys->random(),
                    'product_id' => $key
                ])->create();

                CityProduct::factory([
                    'city_id' => $citiesKeys->random(),
                    'product_id' => $key
                ])->create();
            }
        }

        $response = $this->call("GET", "/", [
            'filter' => [
                'cities' => $citiesKeysArray,
                'category_id' => $categories->first()->id
            ]]);

        $products = Product::query()
                            ->whereHas('cities', fn($q) => $q->whereIn('cities.id', $citiesKeysArray))
                            ->whereHas('categories', fn($q) => $q->where('categories.id', $categories->first()->id))
                            ->paginate();

        $this->assertEquals($response->getOriginalContent()->getData()['products'], $products);

    }
}
