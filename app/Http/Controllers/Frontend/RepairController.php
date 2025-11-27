<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairController extends Controller
{
    public function index()
    {
        return view('frontend.repairs.index');
    }

    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour demander une réparation.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'device_type' => 'required|string|max:255',
            'device_brand' => 'required|string|max:255',
            'device_model' => 'required|string|max:255',
            'issue_description' => 'required|string'
        ]);

        Repair::create($validated);

        return redirect()->route('repairs.index')
            ->with('success', 'Votre demande de réparation a été soumise avec succès! Nous vous contacterons bientôt.');
    }

    public function track(Request $request)
    {
        $repair = null;

        if ($request->has('repair_number')) {
            $repair = Repair::where('repair_number', $request->repair_number)->first();
        }

        return view('frontend.repairs.track', compact('repair'));
    }
}
