<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('frontend.orders.cart', compact('cart', 'total'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->main_image,
                'slug' => $product->slug
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produit ajouté au panier!');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->quantity as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Panier mis à jour!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Produit retiré du panier!');
    }

        public function checkout()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour finaliser votre commande.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Votre panier est vide!');
        }

        // CALCULER LE TOTAL MANQUANT
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // AJOUTER $total DANS compact()
        return view('frontend.orders.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour passer commande.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Votre panier est vide!');
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'total_amount' => 0,
                'payment_method' => $request->payment_method,
            ]);

            $totalAmount = 0;

            foreach ($cart as $id => $item) {
                $product = Product::find($id);

                if ($product && $product->stock >= $item['quantity']) {
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                    ]);

                    $totalAmount += $orderItem->total_price;

                    // Mettre à jour le stock
                    $product->decrement('stock', $item['quantity']);
                }
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            session()->forget('cart');

            return redirect()->route('home')
                ->with('success', 'Commande passée avec succès! Votre numéro de commande est: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('error', 'Une erreur est survenue lors de la commande.');
        }
    }
}
