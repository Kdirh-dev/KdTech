<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:admin,manager');
    // }

    public function index()
{
    // Récupérer les paramètres existants ou initialiser avec des valeurs par défaut
    $heroSettings = Setting::getJsonValue('hero_carousel', [
        [
            'title' => 'Technologie de Pointe à Lomé',
            'subtitle' => 'Découvrez les derniers appareils électroniques et profitez de nos services de réparation experts.',
            'image' => 'https://via.placeholder.com/1200x600/3498db/ffffff?text=KdTech+Hero+1',
            'use_as_background' => true,
            'button1_text' => 'Acheter Maintenant',
            'button1_link' => '/products',
            'button2_text' => 'Réparations',
            'button2_link' => '/repairs'
        ],
        [
            'title' => 'Réparation Express',
            'subtitle' => 'Votre appareil est en panne ? Notre équipe d\'experts le répare rapidement et efficacement.',
            'image' => 'https://via.placeholder.com/1200x600/e74c3c/ffffff?text=Réparation+Express',
            'use_as_background' => true,
            'button1_text' => 'Demander une Réparation',
            'button1_link' => '/repairs',
            'button2_text' => 'Suivre une Réparation',
            'button2_link' => '/repairs/track'
        ],
        [
            'title' => 'Qualité & Garantie',
            'subtitle' => 'Tous nos produits sont garantis et nos réparations bénéficient d\'une certification qualité.',
            'image' => 'https://via.placeholder.com/1200x600/2ecc71/ffffff?text=Qualité+Garantie',
            'use_as_background' => true,
            'button1_text' => 'Produits Garantis',
            'button1_link' => '/products',
            'button2_text' => 'En Savoir Plus',
            'button2_link' => '/about'
        ]
    ]);

    $aboutSettings = Setting::getJsonValue('about_page', [
        'title' => 'À Propos de KdTech',
        'description' => 'Votre partenaire de confiance pour l\'électronique et les réparations à Lomé depuis 2024.',
        'mission' => 'Proposer des produits électroniques de qualité et des services de réparation professionnels à des prix accessibles.',
        'vision' => 'Devenir la référence en matière de technologie et de services après-vente au Togo.',
        'image' => 'https://via.placeholder.com/600x400/2ecc71/ffffff?text=À+Propos+KdTech',
        'team' => [
            [
                'name' => 'Kodjo David',
                'position' => 'Fondateur & CEO',
                'image' => 'https://via.placeholder.com/150x150/3498db/ffffff?text=KD'
            ],
            [
                'name' => 'Technical Manager',
                'position' => 'Responsable Réparations',
                'image' => 'https://via.placeholder.com/150x150/e74c3c/ffffff?text=TM'
            ],
            [
                'name' => 'Service Client',
                'position' => 'Support & Relations Clients',
                'image' => 'https://via.placeholder.com/150x150/2ecc71/ffffff?text=CS'
            ]
        ]
    ]);

    return view('admin.settings.index', compact('heroSettings', 'aboutSettings'));
}

    public function updateHero(Request $request)
    {
        $request->validate([
            'hero' => 'required|array',
            'hero.*.title' => 'required|string|max:255',
            'hero.*.subtitle' => 'required|string',
            'hero.*.button1_text' => 'required|string|max:50',
            'hero.*.button1_link' => 'required|string|max:255',
            'hero.*.button2_text' => 'required|string|max:50',
            'hero.*.button2_link' => 'required|string|max:255',
            'hero_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $heroData = $request->hero;

        // Gestion des images du hero
        if ($request->hasFile('hero_images')) {
            foreach ($request->file('hero_images') as $index => $image) {
                if ($image) {
                    $path = $image->store('hero', 'public');
                    $heroData[$index]['image'] = asset('storage/' . $path);
                }
            }
        }

        // Normalize 'use_as_background' flag (checkboxes submitted only when checked)
        foreach ($heroData as $i => $h) {
            $heroData[$i]['use_as_background'] = isset($h['use_as_background']) && ($h['use_as_background'] == 'on' || $h['use_as_background'] == 1 || $h['use_as_background'] === true);
        }

        Setting::setJsonValue('hero_carousel', $heroData);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Carousel hero mis à jour avec succès!');
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'about_mission' => 'required|string',
            'about_vision' => 'required|string',
            'about_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'team' => 'required|array',
            'team.*.name' => 'required|string|max:255',
            'team.*.position' => 'required|string|max:255',
            'team_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $aboutData = [
            'title' => $request->about_title,
            'description' => $request->about_description,
            'mission' => $request->about_mission,
            'vision' => $request->about_vision,
            'team' => $request->team
        ];

        // Gestion de l'image principale about
        if ($request->hasFile('about_image')) {
            $path = $request->file('about_image')->store('about', 'public');
            $aboutData['image'] = asset('storage/' . $path);
        } else {
            // Garder l'image existante si pas de nouvelle image
            $existingAbout = Setting::getJsonValue('about_page');
            $aboutData['image'] = $existingAbout['image'] ?? asset('images/about.jpg');
        }

        // Gestion des images de l'équipe
        if ($request->hasFile('team_images')) {
            foreach ($request->file('team_images') as $index => $image) {
                if ($image) {
                    $path = $image->store('team', 'public');
                    $aboutData['team'][$index]['image'] = asset('storage/' . $path);
                }
            }
        }

        Setting::setJsonValue('about_page', $aboutData);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Page À Propos mise à jour avec succès!');
    }
}
