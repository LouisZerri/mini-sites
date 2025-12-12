<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::latest()->paginate(10);
        return view('admin.agents.index', compact('agents'));
    }

    public function create()
    {
        return view('admin.agents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:5120',
            'bio' => 'nullable|string',
            'secteur' => 'required|string|max:255',
            'reseaux_sociaux' => 'nullable|array',
            'couleur_primaire' => 'nullable|string|max:7',
            'couleur_secondaire' => 'nullable|string|max:7',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('agents', 'public');
        }

        $agent = Agent::create($validated);

        return redirect()
            ->route('admin.agents.index')
            ->with('success', "Agent {$agent->nom_complet} créé ! Mini-site : {$agent->url}");
    }

    public function show(Agent $agent)
    {
        $agent->load(['annonces', 'avisValides']);
        return view('admin.agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return view('admin.agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:5120',
            'bio' => 'nullable|string',
            'secteur' => 'required|string|max:255',
            'reseaux_sociaux' => 'nullable|array',
            'actif' => 'boolean',
            'couleur_primaire' => 'nullable|string|max:7',
            'couleur_secondaire' => 'nullable|string|max:7',
        ]);

        if ($request->hasFile('photo')) {
            if ($agent->photo) {
                Storage::disk('public')->delete($agent->photo);
            }
            $validated['photo'] = $request->file('photo')->store('agents', 'public');
        }

        $agent->update($validated);

        return redirect()
            ->route('admin.agents.index')
            ->with('success', 'Agent mis à jour !');
    }

    public function destroy(Agent $agent)
    {
        // Supprimer la photo de l'agent
        if ($agent->photo) {
            Storage::disk('public')->delete($agent->photo);
        }

        // Supprimer toutes les photos de toutes les annonces de l'agent
        foreach ($agent->annonces as $annonce) {
            if ($annonce->photos) {
                foreach ($annonce->photos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        // Supprimer l'agent (les annonces et avis seront supprimés en cascade)
        $agent->delete();

        return redirect()->route('admin.agents.index')->with('success', 'Agent supprimé avec succès !');
    }
}
