<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'qty'        => 'required|integer'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cartUpdated = Cart::updateOrCreate([
            'user_id'    => Auth::id(),
            'product_id' => $request->product_id
        ], [
            'qty'   => $request->qty,
            'total' => $product->price * $request->qty
        ]);

        if ($cartUpdated) {
            $cart = Cart::where('user_id', Auth::id())->first();
            return apiResponse(true, __('Cart updated.'), $cart);
        }

        return apiResponse(true, __('Unable to update cart!'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
