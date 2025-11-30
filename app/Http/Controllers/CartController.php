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

        // 1️⃣ Find or create an open cart for this user
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'open'],
            ['total_amount' => 0]
        );

        // 2️⃣ Get product price (assuming product table exists)
        $price = 100; // default
        // If you have product table, uncomment:
        // $price = Product::find($request->product_id)->price ?? 0;

        $qty = $request->quantity ?? 1;
        $lineTotal = $qty * $price;

        // 3️⃣ Add item to cart_items table
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
