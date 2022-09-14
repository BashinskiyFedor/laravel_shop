@php
/** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Domain\Product\Product[] $products */
@endphp

<x-app-layout title="Products">
    <form action="{{route('products')}}" method="get">
        <div class="flex flex-row items-center">
            <div class="basis-1/4 md:basis-1/3" >
                <select name="filter[category_id]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected>Выбор категории</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" @if($activeFilterCategory == $category->id) selected @endif>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="basis-1/4 md:basis-1/3" >
                <select multiple="multiple" name="filter[cities][]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach($cities as $city)
                        <option value="{{$city->id}}" @if(in_array($city->id, $activeFilterCities)) selected @endif>{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="basis-1/4 ml-4 mr-4">
                <x-button type="submit">
                    Найти
                </x-button>
            </div>
        </div>
    </form>

    <div class="grid grid-cols-3 gap-12 mb-4">

        {{-- <div class="flex justify-end mt-4"> --}}

        {{-- </div> --}}
    </div>
    <div class="grid grid-cols-3 gap-12">
        @foreach($products as $product)
            <x-product
                :title="$product->name"
                :price="format_money($product->getItemPrice()->pricePerItemIncludingVat())"
                :actionUrl="action(\App\Http\Controllers\Cart\AddCartItemController::class, [$product])"
          />
        @endforeach
    </div>

    <div class="mx-auto mt-12">
        {{ $products->links() }}
    </div>
</x-app-layout>
