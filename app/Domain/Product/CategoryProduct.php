<?php

namespace App\Domain\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Category\Category;
use Database\Factories\CategoryProductFactory;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'category_product';

    protected static function newFactory(): CategoryProductFactory
    {
        return new CategoryProductFactory();
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
}
