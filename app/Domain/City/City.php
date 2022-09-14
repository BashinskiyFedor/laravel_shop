<?php

namespace App\Domain\City;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Database\Factories\CityFactory;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): CityFactory
    {
        return new CityFactory();
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
