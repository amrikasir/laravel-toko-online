<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * function to get cart list
     */
    public function index(){
        // get cart list with model keranjang
        $carts = \App\Keranjang::where('user_id', auth()->id())->get();

        // return cart list in json format
        return response()->json(['data' => $carts]);
    }

    /**
     * function to add product to cart
     */
    public function store(Request $request){
        // check if product is not found
        if(!\App\Product::find($request->product_id)){
            // return error message in json format
            return response()->json(['message' => 'Product not found'], 404);
        }

        // check if cart is not found
        if(\App\Keranjang::where('user_id', auth()->id())->where('product_id', $request->product_id)->first()){
            // return error message in json format
            return response()->json(['message' => 'Product already exists in cart'], 409);
        }

        // create cart
        $cart = \App\Keranjang::create([
            'user_id'       => auth()->id(),
            'product_id'    => $request->product_id,
            'qty'           => $request->qty
        ]);

        // return cart detail in json format with message
        return response()->json([
            'data'      => $cart,
            'message'   => 'Product has been added to cart'
        ]);
    }

    /**
     * function to update cart
     */
    public function update(Request $request, $id){
        // find cart by id
        $cart = \App\Keranjang::find($id);

        // update cart
        $cart->update($request->all());

        // return cart detail in json format with message
        return response()->json([
            'data'      => $cart,
            'message'   => 'Cart has been updated'
        ]);
    }

    /**
     * function to delete cart
     */
    public function destroy($id){
        // find cart by id
        $cart = \App\Keranjang::find($id);

        // delete cart
        $cart->delete();

        // return message in json format
        return response()->json(['message' => 'Cart has been deleted']);
    }
}
