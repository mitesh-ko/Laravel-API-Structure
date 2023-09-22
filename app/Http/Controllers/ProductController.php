<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $products = Product::where(function ($q) use ($request) {
            if ($request->name)
                $q->where('name', 'like', '%' . $request->name . '%');
        })->paginate(config('constants.pagination'));

        if ($products->count() > 0)
            return apiResponse(true, __('Products list.'), $products);

        return apiResponse(false, __('Products not available.'), [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(ProductRequest $request)
    {
        $validData = $request->validated();
        $newProduct = Product::create($validData);
        return apiResponse(true, __('New product created successfully.'), $newProduct, Response::HTTP_CREATED);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validData = $request->validated();
        foreach ($validData as $key => $aData) {
            $product->{$key} = $aData;
        }

        if ($product->update())
            return apiResponse(true, __('Product updated successfully.'), $product, Response::HTTP_CREATED);

        return apiResponse(true, __('Unable to updated product.'), $product, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->delete()) {
            return apiResponse(true, __('Product deleted successfully.'), [], Response::HTTP_ACCEPTED);
        }

        /*
         * If some associated record exist in database and user have to
         * delete that first and change the response message according to need
         */
        return apiResponse(false, __('Unable to delete product!'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
