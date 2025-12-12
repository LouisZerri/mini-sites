<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnonceController extends Controller
{
    public function index(Agent $agent)
    {
        $annonces = $agent->annonces()->latest()->paginate(10);
        return view('admin.annonces.index', compact('agent', 'annonces'));
    }

    public function create(Agent $agent)
    {
        return view('admin.annonces.create', compact('agent'));
    }

    public function store(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'nullable|numeric|min:0',
            'type' => 'required|in:vente,location',
            'photos.*' => 'nullable|image|max:5120',
            'visible' => 'boolean',
        ]);

        $validated['agent_id'] = $agent->id;

        // Upload des photos
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('annonces', 'public');
            }
            $validated['photos'] = $photoPaths;
        }

        $annonce = Annonce::create($validated);

        return redirect()
            ->route('admin.annonces.index', $agent)
            ->with('success', 'Annonce créée avec succès !');
    }

    public function show(Agent $agent, Annonce $annonce)
    {
        return view('admin.annonces.show', compact('agent', 'annonce'));
    }

    public function edit(Agent $agent, Annonce $annonce)
    {
        return view('admin.annonces.edit', compact('agent', 'annonce'));
    }

    public function update(Request $request, Agent $agent, Annonce $annonce)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'nullable|numeric|min:0',
            'type' => 'required|in:vente,location',
            'photos.*' => 'nullable|image|max:5120',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'string',
            'visible' => 'boolean',
        ]);

        // Gérer la suppression sélective de photos
        if ($request->has('delete_photos') && $annonce->photos) {
            $currentPhotos = $annonce->photos;
            $photosToDelete = $request->delete_photos;

            // Supprimer les fichiers
            foreach ($photosToDelete as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            // Garder seulement les photos non supprimées
            $remainingPhotos = array_values(array_filter($currentPhotos, function ($photo) use ($photosToDelete) {
                return !in_array($photo, $photosToDelete);
            }));

            $validated['photos'] = $remainingPhotos;
        }

        // Upload des nouvelles photos (remplace TOUTES les photos si présent)
        if ($request->hasFile('photos')) {
            // Supprimer TOUTES les anciennes photos
            if ($annonce->photos) {
                foreach ($annonce->photos as $oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('annonces', 'public');
            }
            $validated['photos'] = $photoPaths;
        }

        $annonce->update($validated);

        return redirect()
            ->route('admin.annonces.index', $agent)
            ->with('success', 'Annonce mise à jour !');
    }

    public function destroy(Agent $agent, Annonce $annonce)
    {
        // Supprimer les photos
        if ($annonce->photos) {
            foreach ($annonce->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $annonce->delete();

        return redirect()
            ->route('admin.annonces.index', $agent)
            ->with('success', 'Annonce supprimée !');
    }
}
