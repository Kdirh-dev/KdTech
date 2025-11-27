<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->where('stock', '>', 0);

        // Filtrage par catégorie
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filtrage par recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filtrage par prix
        if ($request->has('price_range')) {
            switch ($request->price_range) {
                case '0-100':
                    $query->whereBetween('price', [0, 100]);
                    break;
                case '100-500':
                    $query->whereBetween('price', [100, 500]);
                    break;
                case '500-1000':
                    $query->whereBetween('price', [500, 1000]);
                    break;
                case '1000+':
                    $query->where('price', '>=', 1000);
                    break;
            }
        }

        $products = $query->with('category')->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show($identifier)
    {
        // Accept either slug or id to be resilient when views pass one or the other
        $product = Product::where(function ($q) use ($identifier) {
                if (is_numeric($identifier)) {
                    $q->where('id', $identifier);
                }
                $q->orWhere('slug', $identifier);
            })
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function byCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('category')
            ->paginate(12);

        return view('frontend.products.category', compact('products', 'category'));
    }
}
