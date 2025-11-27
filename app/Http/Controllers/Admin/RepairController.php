<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:admin,manager');
    // }

    public function index()
    {
        $repairs = Repair::latest()->paginate(10);
        return view('admin.repairs.index', compact('repairs'));
    }

    public function show(Repair $repair)
    {
        return view('admin.repairs.show', compact('repair'));
    }

    public function updateStatus(Request $request, Repair $repair)
    {
        $request->validate([
            'status' => 'required|in:pending,diagnosis,repairing,repaired,ready,delivered,cancelled'
        ]);

        $repair->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Statut de la réparation mis à jour!');
    }

    public function updateEstimate(Request $request, Repair $repair)
    {
        $request->validate([
            'estimated_cost' => 'nullable|numeric|min:0',
            'estimated_completion' => 'nullable|date',
            'technician_notes' => 'nullable|string'
        ]);

        $repair->update($request->only(['estimated_cost', 'estimated_completion', 'technician_notes']));

        return redirect()->back()->with('success', 'Devis mis à jour!');
    }
}
