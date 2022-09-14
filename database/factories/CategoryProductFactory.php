<?php

namespace Database\Factories;

use App\Domain\Product\CategoryProduct;
use App\Domain\Category\Category;
use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryProductFactory extends Factory
{
    protected $model = CategoryProduct::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'category_id' => Category::factory()
        ];
    }
}
