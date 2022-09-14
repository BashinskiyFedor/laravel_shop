<?php

namespace App\Domain\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function newFactory(): CategoryFactory
    {
        return new CategoryFactory();
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
