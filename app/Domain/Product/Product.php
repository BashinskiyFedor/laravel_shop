<?php

namespace App\Domain\Product;

use App\Domain\Inventory\Projections\Inventory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Category\Category;
use App\Domain\City\City;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'manages_inventory' => 'boolean',
    ];

    protected static function newFactory(): ProductFactory
    {
        return new ProductFactory();
    }

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function cities() : BelongsToMany
    {
        return $this->belongsToMany(City::class);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItemPrice(): Price
    {
        return new Price($this->item_price, $this->vat_percentage);
    }

    public function managesInventory(): bool
    {
        return $this->manages_inventory ?? false;
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function hasAvailableInventory(int $requestedAmount): bool
    {
        return $this->inventory->amount >= $requestedAmount;
    }

    public function scopeCategoryId(Builder $query, Category $category) : Builder
    {
        return $query->whereHas('categories', fn($q) => $q->where('categories.id', $category->id));
    }

    // public function scopeCityId(Builder $query, City $city) : Builder
    // {
    //     return $query->whereHas('cities', fn($q) => $q->where('cities.id', $city->id));
    // }

    public function scopeCities(Builder $query, ...$cities) : Builder
    {
        return $query->whereHas('cities', fn($q) => $q->whereIn('cities.id', $cities));
    }
}
