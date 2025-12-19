<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Agent;
use App\Models\PredefinedService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Agent $agent)
    {
        $services = $agent->services()->orderBy('ordre')->get();
        return view('admin.services.index', compact('agent', 'services'));
    }

    public function create(Agent $agent)
    {
        $predefinedServices = PredefinedService::getActiveByCategory();
        $categoryLabels = PredefinedService::getCategoryLabels();
        
        return view('admin.services.create', compact('agent', 'predefinedServices', 'categoryLabels'));
    }

    public function store(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'points_forts' => 'nullable|array',
            'points_forts.*' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'boolean',
        ]);

        $validated['agent_id'] = $agent->id;
        $validated['actif'] = $request->has('actif');
        
        if (isset($validated['points_forts'])) {
            $validated['points_forts'] = array_values(array_filter($validated['points_forts']));
        }

        Service::create($validated);

        return redirect()
            ->route('admin.services.index', $agent)
            ->with('success', 'Service créé avec succès !');
    }

    public function edit(Agent $agent, Service $service)
    {
        $categoryLabels = PredefinedService::getCategoryLabels();
        
        return view('admin.services.edit', compact('agent', 'service', 'categoryLabels'));
    }

    public function update(Request $request, Agent $agent, Service $service)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'points_forts' => 'nullable|array',
            'points_forts.*' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');
        
        if (isset($validated['points_forts'])) {
            $validated['points_forts'] = array_values(array_filter($validated['points_forts']));
        }

        $service->update($validated);

        return redirect()
            ->route('admin.services.index', $agent)
            ->with('success', 'Service mis à jour !');
    }

    public function destroy(Agent $agent, Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index', $agent)
            ->with('success', 'Service supprimé !');
    }
}