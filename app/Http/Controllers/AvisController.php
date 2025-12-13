<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Agent;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function index(Agent $agent)
    {
        $avis = $agent->avis()->latest()->paginate(10);
        return view('admin.avis.index', compact('agent', 'avis'));
    }

    public function create(Agent $agent)
    {
        return view('admin.avis.create', compact('agent'));
    }

    public function store(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'nom_client' => 'required|string|max:255',
            'commentaire' => 'required|string|max:1000',
            'note' => 'required|integer|min:1|max:5',
            'valide' => 'boolean',
        ]);

        $validated['agent_id'] = $agent->id;
        $validated['valide'] = $request->has('valide');

        Avis::create($validated);

        return redirect()
            ->route('admin.avis.index', $agent)
            ->with('success', 'Avis créé avec succès !');
    }

    public function edit(Agent $agent, Avis $avis)
    {
        return view('admin.avis.edit', compact('agent', 'avis'));
    }

    public function update(Request $request, Agent $agent, Avis $avis)
    {
        $validated = $request->validate([
            'nom_client' => 'required|string|max:255',
            'commentaire' => 'required|string|max:1000',
            'note' => 'required|integer|min:1|max:5',
            'valide' => 'boolean',
        ]);

        $validated['valide'] = $request->has('valide');

        $avis->update($validated);

        return redirect()
            ->route('admin.avis.index', $agent)
            ->with('success', 'Avis mis à jour !');
    }

    public function destroy(Agent $agent, Avis $avis)
    {
        $avis->delete();

        return redirect()
            ->route('admin.avis.index', $agent)
            ->with('success', 'Avis supprimé !');
    }

    // Action rapide pour valider/invalider
    public function toggleValidation(Agent $agent, Avis $avis)
    {
        $avis->update(['valide' => !$avis->valide]);

        return back()->with('success', $avis->valide ? 'Avis validé !' : 'Avis masqué !');
    }
}
