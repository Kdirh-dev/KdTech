<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting; // ← Corriger l'import
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $featuredProducts = Product::where('is_featured', true)
        ->where('is_active', true)
        ->where('stock', '>', 0)
        ->with('category')
        ->limit(8)
        ->get();

    $categories = Category::where('is_active', true)
        ->withCount(['products' => function($query) {
            $query->where('is_active', true)->where('stock', '>', 0);
        }])
        ->having('products_count', '>', 0)
        ->limit(6)
        ->get();

    // Récupérer les slides du hero depuis les settings
    $heroSlides = Setting::getJsonValue('hero_carousel', [
        [
            'title' => 'Technologie de Pointe à Lomé',
            'subtitle' => 'Découvrez les derniers appareils électroniques et profitez de nos services de réparation experts.',
            'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            'button1_text' => 'Acheter Maintenant',
            'button1_link' => '/products',
            'button2_text' => 'Réparations',
            'button2_link' => '/repairs'
        ],
        [
            'title' => 'Réparation Express',
            'subtitle' => 'Votre appareil est en panne ? Notre équipe d\'experts le répare rapidement et efficacement.',
            'image' => 'https://images.unsplash.com/photo-1581093458791-9d66def51cde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            'button1_text' => 'Demander une Réparation',
            'button1_link' => '/repairs',
            'button2_text' => 'Suivre une Réparation',
            'button2_link' => '/repairs/track'
        ],
        [
            'title' => 'Qualité & Garantie',
            'subtitle' => 'Tous nos produits sont garantis et nos réparations bénéficient d\'une certification qualité.',
            'image' => 'https://images.unsplash.com/photo-1556655848-f3a704976c1f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
            'button1_text' => 'Produits Garantis',
            'button1_link' => '/products',
            'button2_text' => 'En Savoir Plus',
            'button2_link' => '/about'
        ]
    ]);

    return view('frontend.home', compact('featuredProducts', 'categories', 'heroSlides'));
}

public function about()
{
    // Récupérer les paramètres de la page about
    $aboutSettings = Setting::getJsonValue('about_page', [
        'title' => 'À Propos de KdTech',
        'description' => 'Votre partenaire de confiance pour l\'électronique et les réparations à Lomé depuis 2024.',
        'mission' => 'Proposer des produits électroniques de qualité et des services de réparation professionnels à des prix accessibles.',
        'vision' => 'Devenir la référence en matière de technologie et de services après-vente au Togo.',
        'image' => 'https://images.unsplash.com/photo-1565688534245-05d6b5be184a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
        'team' => [
            [
                'name' => 'Kodjo David',
                'position' => 'Fondateur & CEO',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80'
            ],
            [
                'name' => 'Technical Manager',
                'position' => 'Responsable Réparations',
                'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80'
            ],
            [
                'name' => 'Service Client',
                'position' => 'Support & Relations Clients',
                'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80'
            ]
        ]
    ]);

    return view('frontend.about', compact('aboutSettings'));
}



    public function contact()
    {
        return view('frontend.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Ici vous pouvez ajouter l'envoi d'email ou sauvegarde en base
        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès! Nous vous contacterons bientôt.');
    }
}
