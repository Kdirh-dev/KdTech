<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:admin,manager');
    // }

    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['features'] = $request->features ? explode(',', $request->features) : [];

        // Gestion des images - CORRIGÉ
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Stocker l'image et obtenir le chemin relatif
                $path = $image->store('products', 'public');
                // Utiliser asset() pour générer l'URL complète
                $imagePaths[] = asset('storage/' . $path);
            }
        }

        $validated['images'] = $imagePaths;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['features'] = $request->features ? explode(',', $request->features) : [];

        // Gestion des images - CORRIGÉ
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = asset('storage/' . $path);
            }
            $validated['images'] = $imagePaths;
        } else {
            // Garder les images existantes si aucune nouvelle image n'est uploadée
            $validated['images'] = $product->images;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès!');
    }

    public function destroy(Product $product)
    {
        // Supprimer les images physiques - CORRIGÉ
        if ($product->images) {
            foreach ($product->images as $imagePath) {
                // Extraire le chemin relatif depuis l'URL complète
                $relativePath = str_replace(asset('storage/'), '', $imagePath);
                Storage::disk('public')->delete($relativePath);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès!');
    }
}
