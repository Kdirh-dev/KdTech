<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Add a product to the session wishlist (works for guests and users).
     */
    public function add(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('is_active', true)->first();
        if (! $product) {
            return redirect()->back()->with('error', 'Produit introuvable.');
        }

        $wishlist = $request->session()->get('wishlist', []);
        if (! in_array($product->id, $wishlist)) {
            $wishlist[] = $product->id;
            $request->session()->put('wishlist', $wishlist);
        }

        return redirect()->back()->with('success', 'Produit ajouté aux favoris.');
    }
}
