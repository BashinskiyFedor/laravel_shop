<?php

namespace App\Domain\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\City\City;
use Database\Factories\CityProductFactory;

class CityProduct extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'city_product';

    protected static function newFactory(): CityProductFactory
    {
        return new CityProductFactory();
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function City()
    {
        return $this->belongsTo(City::class);
    }
}
