<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product; // If product table exists
use Tymon\JWTAuth\Facades\JWTAuth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'sometimes|numeric|min:1'
        ]);

        $user = JWTAuth::user();

        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'open'],
            ['total_amount' => 0]
        );

       
        $price = 100; // default
        
        $qty = $request->quantity ?? 1;
        $lineTotal = $qty * $price;

       
        $item = CartItem::create([
            'cart_id'    => $cart->id,
            'product_id' => $request->product_id,
            'user_id'    => $user->id,
            'quantity'   => $qty,
            'unit_price' => $price,
            'line_total' => $lineTotal
        ]);

        // 4️⃣ Update cart total
        $cart->total_amount += $lineTotal;
        $cart->save();

        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart'    => $cart,
            'item'    => $item
        ]);
    }
}
