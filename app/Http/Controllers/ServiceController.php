<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Agent $agent)
    {
        $services = $agent->services()->orderBy('ordre')->get();
        return view('admin.services.index', compact('agent', 'services'));
    }

    public function create(Agent $agent)
    {
        return view('admin.services.create', compact('agent'));
    }

    public function store(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'points_forts' => 'nullable|array',
            'points_forts.*' => 'string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'boolean',
        ]);

        $validated['agent_id'] = $agent->id;
        $validated['actif'] = $request->has('actif');
        
        // Filtrer les points forts vides
        if (isset($validated['points_forts'])) {
            $validated['points_forts'] = array_filter($validated['points_forts']);
        }

        // Upload de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()
            ->route('admin.services.index', $agent)
            ->with('success', 'Service créé avec succès !');
    }

    public function edit(Agent $agent, Service $service)
    {
        return view('admin.services.edit', compact('agent', 'service'));
    }

    public function update(Request $request, Agent $agent, Service $service)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'points_forts' => 'nullable|array',
            'points_forts.*' => 'string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');
        
        // Filtrer les points forts vides
        if (isset($validated['points_forts'])) {
            $validated['points_forts'] = array_filter($validated['points_forts']);
        }

        // Upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()
            ->route('admin.services.index', $agent)
            ->with('success', 'Service mis à jour !');
    }

    public function destroy(Agent $agent, Service $service)
    {
        // Supprimer l'image
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index', $agent)
            ->with('success', 'Service supprimé !');
    }
}