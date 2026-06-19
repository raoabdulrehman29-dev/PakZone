<?php

namespace App\Http\Controllers;

use App\Models\Customer\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Coupon;

class CartController extends Controller
{
    public function index()
    {
      if(auth()->user())
        {
            $cart=Cart::where('user_id',$user->id);
            return Inertia::render('Cart/Index', ['cart'=> $cart]);
        }
        else{
            return "user logn required";
        }
    }
    public function add(AddToCartRequest  $request)
    {
        $validated=$request->validate([
            'product_id',
            'quantity',
            'varient_id',
        ]);
        if($validated && $request->product)
            {
                 if($request->product->stock >= 0)
                    {
                        if(auth()->user())
                            {
                                $cart=Cart::findorfail($request->product);
                                if($cart)
                                    {
                        $cart($valiadted->productCOunt++);
                        return inertia::redirect('Cart/Index',"item added to cart successfully");
                                    }
                                    else
                                    {
                                        $cart($validated);
                                    }
                            }
                            else{
                                $session($validated);
                                   return inertia::redirect('Cart/Index',"item added to cart successfully");

                            }
                    }

            }

    }
    public function update(UpdateCartRequest $request,$id)
    {
        $validated=$request->valiate(['quantity']);
        $cart=Cart::where('product_id',$id)->where('status','owned')->where('stock','available')->findOrFail();
        if($cart->$validated)
            {
               $cart($request->product->count++);
                $count=Cart::withcount('products');
                return Inertia::redirect('Cart/Index', ['cart' => $cart, 'count' => $count]);
            }
    }
    public function destroy($id)
    {
        $cart=Cart::where('id',$id)->findOrFail();
        if($cart)
            {
                $cart->delete();
                return Inertia::redirect([
                    'cart' => $cart
                ]);
            }
    }
    public function saveForLater($id)
    {
        $later=Cart::whrere('id',$id)->where('status','owned')->findOrFail();
        if($later)
            {
                $later->status='saved';
                return redirect('Cart/Index')->with('success','item added to saved list ');
            }
    }
    public function applyCoupon(Request $request)
    {
        $code=$request->coupon->code;
       $validated=Coupon::where('coupon_code',$code)->where('status','is_active')->where('time','not_expireed')->where('minOrder','>=',order->price)->get();
    $discount=($request->price-$product->price);
    $cart=Cart::where('id',$request_id)->update('price',$discount);
    return Inertia::redirect('/Cart?index',['cart',$cart]);
    }
    

}
