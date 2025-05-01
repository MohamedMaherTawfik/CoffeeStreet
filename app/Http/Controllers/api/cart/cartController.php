<?php

namespace App\Http\Controllers\api\cart;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\cartItems;
use App\Models\Products;
use App\services\CartServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    use apiResponse;
    // private $cartRepository;
    // public function __construct(CartServices $cartRepository)
    // {
    //     $this->cartRepository = $cartRepository;
    // }

    public function getCartItems()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        $cartItems = CartItems::with('product')->where('cart_id', $cart->id)->get();
        $products = Products::whereIn('id', $cartItems->pluck('products_id'))->get();
        return $this->apiResponse($products, 'Cart items fetched successfully');
    }

    public function addToCart(Request $request)
    {
        $cart = cart::where('user_id', Auth::user()->id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::user()->id,
            ]);
            CartItems::create([
                'cart_id' => Cart::where('user_id', Auth::user()->id)->first()->id,
                'products_id' => request('id'),
                'quantity' => $request['quantity'],
            ]);
            return $this->apiResponse($cart, 'Product Added Success');
        } else {
            if (isset(cartItems::where('cart_id', $cart->id)->where('products_id', request('id'))->first()->id)) {
                CartItems::where('cart_id', $cart->id)->where('products_id', request('id'))->increment('quantity', $request['quantity']);
                return $this->apiResponse($cart, 'Qantity Added Success');
            } else {
                CartItems::create([
                    'cart_id' => $cart->id,
                    'products_id' => request('id'),
                    'quantity' => $request['quantity'],
                ]);
                return $this->apiResponse($cart, 'Product Added Success');
            }
        }
    }

    public function deleteFromCart()
    {
        dd(request('id'));
        $cart = Cart::where('user_id', Auth::user()->id)->first();
        $item = CartItems::where('cart_id', $cart->id)->where('products_id', request('id'))->delete();
        return $this->apiResponse($item, 'Product Deleted Success');
    }

    public function clearCart()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();
        CartItems::where('cart_id', $cart->id)->delete();
        return $this->apiResponse($cart, 'Cart Cleared Success');
    }


}
