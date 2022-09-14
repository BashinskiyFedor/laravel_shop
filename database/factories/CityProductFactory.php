<?php

namespace Database\Factories;

use App\Domain\Product\CityProduct;
use App\Domain\City\City;
use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityProductFactory extends Factory
{
    protected $model = CityProduct::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'city_id' => City::factory()
        ];
    }
}
