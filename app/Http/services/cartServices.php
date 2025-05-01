<?php

namespace App\services;

use App\Models\Cart;
use App\Models\CartItems;
use Illuminate\Support\Facades\Auth;

class CartServices
{
    public function getCartItems()
    {
        $cart =   Cart::where('user_id', Auth::user()->id)->first();
        return CartItems::with('product')->where('cart_id', $cart->id)->get();
    }

    public function deleteFromCart($id)
    {
        $FindCart = Cart::where('user_id', Auth::user()->id)->first();
        return CartItems::where('cart_id', $FindCart->id)->where('products_id', $id)->delete();
    }

    public function clearCart()
    {
        return cart::where('user_id', Auth::user()->id)->delete();
    }

    public function createCart()
    {
        return Cart::create([
            'user_id'=>Auth::user()->id,
        ]);
    }

    public function quantityPlus($cart,$products_id,$fields)
    {
        CartItems::where('cart_id', $cart->id)->where('products_id', $products_id)->increment('quantity', $fields);
    }

    public function newCartItems($quantity,$products_id)
    {
        return CartItems::create([
            'cart_id'=>Cart::where('user_id', Auth::user()->id)->first()->id,
            'products_id'=>$products_id,
            'quantity'=>$quantity
        ]);
    }

    public function ExistCartItems($cart,$products_id,$fields)
    {
        return CartItems::create([
            'cart_id'=>$cart->id,
            'products_id'=>$products_id,
            'quantity'=>$fields,
        ]);
    }
}
