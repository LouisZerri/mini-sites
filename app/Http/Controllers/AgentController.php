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
            'titre' => 'nullable|string|max:255',
            'email' => 'required|email|unique:agents',
            'telephone' => 'required|string|max:20',
            'secteur' => 'required|string|max:255',
            'langues' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:5120',
            'bio' => 'nullable|string',
            'accroche' => 'nullable|string|max:500',
            'info_legale' => 'nullable|string|max:500',
            'parcours' => 'nullable|string',
            'actif' => 'boolean',
            'disponible' => 'boolean',
            'reseaux_sociaux.linkedin' => 'nullable|url',
            'reseaux_sociaux.facebook' => 'nullable|url',
            'reseaux_sociaux.instagram' => 'nullable|url',
        ]);

        // Upload de la photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('agents', 'public');
        }

        // Gestion des réseaux sociaux
        $validated['reseaux_sociaux'] = array_filter($request->input('reseaux_sociaux', []), function ($value) {
            return !empty($value);
        });

        $agent = Agent::create($validated);

        return redirect()->route('admin.agents.index')->with('success', 'Agent créé avec succès !');
    }

    public function show(Agent $agent)
    {
        $agent->load(['services', 'avisValides']);
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
            'titre' => 'nullable|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'telephone' => 'required|string|max:20',
            'secteur' => 'required|string|max:255',
            'langues' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:5120',
            'bio' => 'nullable|string',
            'accroche' => 'nullable|string|max:500',
            'info_legale' => 'nullable|string|max:500',
            'parcours' => 'nullable|string',
            'actif' => 'boolean',
            'disponible' => 'boolean',
            'reseaux_sociaux.linkedin' => 'nullable|url',
            'reseaux_sociaux.facebook' => 'nullable|url',
            'reseaux_sociaux.instagram' => 'nullable|url',
        ]);

        // Upload de la nouvelle photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo
            if ($agent->photo) {
                Storage::disk('public')->delete($agent->photo);
            }
            $validated['photo'] = $request->file('photo')->store('agents', 'public');
        }

        // Gestion des réseaux sociaux
        $validated['reseaux_sociaux'] = array_filter($request->input('reseaux_sociaux', []), function ($value) {
            return !empty($value);
        });

        $agent->update($validated);

        return redirect()->route('admin.agents.index')->with('success', 'Agent mis à jour !');
    }

    public function destroy(Agent $agent)
    {
        // Supprimer la photo de l'agent
        if ($agent->photo) {
            Storage::disk('public')->delete($agent->photo);
        }

        // Supprimer toutes les photos de tous les services de l'agent
        foreach ($agent->services as $service) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
        }

        // Supprimer l'agent (les services et avis seront supprimés en cascade)
        $agent->delete();

        return redirect()->route('admin.agents.index')->with('success', 'Agent supprimé avec succès !');
    }
}
