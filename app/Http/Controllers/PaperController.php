<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function addCart(Request $request)
    {
        $paper = Test::findOrFail($request->paper_id);

        $cart = session()->get('paper_cart', []);

        if (!isset($cart[$paper->id])) {

            $cart[$paper->id] = [
                'name' => $paper->name,
                'price' => $paper->offer_price
            ];

        }

        session()->put('paper_cart', $cart);

        return response()->json(['status' => true]);
    }

    public function cart()
    {
        $cart = session('paper_cart', []);

        return view('front.paper-cart', compact('cart'));
    }

    public function remove($id)
    {
        $cart = session()->get('paper_cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('paper_cart', $cart);

        return redirect()->back();
    }

    public function checkout()
    {
        $cart = session('paper_cart');

        if (!$cart) {
            return redirect()->back();
        }

        $paper_ids = array_keys($cart);

        $paper_ids = implode(',', $paper_ids);

        return redirect()->route('user.process-order', [
            'type' => 'paper',
            'id' => $paper_ids
        ]);
    }
}
