<?php

namespace Database\Seeders;

use App\Domain\Product\Product;
use App\Domain\Category\Category;
use App\Domain\City\City;
use App\Domain\Product\CategoryProduct;
use App\Domain\Product\CityProduct;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory(100)->create();
        $categoriesKeys = collect($categories->modelKeys());

        $cities = City::factory(30)->create();
        $citiesKeys = collect($cities->modelKeys());

        for ($i = 0; $i <= 50; $i++) {
            $products = Product::factory(1000)->create();
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
    }
}
