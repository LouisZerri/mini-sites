<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\PredefinedService;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\Avis;

class MiniSiteController extends Controller
{
    public function index(Request $request, $slug)
    {
        $agent = Agent::where('slug', $slug)
            ->where('actif', true)
            ->firstOrFail();

        $agent->load([
            'servicesActifs',
            'avisValides' => function ($query) {
                $query->latest()->limit(10);
            }
        ]);

        // Grouper les services par catégorie
        $servicesByCategory = $agent->servicesActifs->groupBy('category');
        $categoryLabels = PredefinedService::getCategoryLabels();

        return view('minisite.home', compact('agent', 'servicesByCategory', 'categoryLabels'));
    }

    public function contact(Request $request, $slug)
    {
        $agent = Agent::where('slug', $slug)
            ->where('actif', true)
            ->firstOrFail();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
            'objectif' => 'nullable|string|max:255',
        ]);

        try {
            Mail::to($agent->email)->send(new ContactMail($validated, $agent));

            return back()->with('success', 'Votre message a été envoyé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi du message. Veuillez réessayer.');
        }
    }

    public function submitAvis(Request $request, $slug)
    {
        $agent = Agent::where('slug', $slug)
            ->where('actif', true)
            ->firstOrFail();

        $validated = $request->validate([
            'nom_client' => 'required|string|max:255',
            'commentaire' => 'required|string|max:1000',
            'note' => 'required|integer|min:1|max:5',
        ]);

        $validated['agent_id'] = $agent->id;
        $validated['valide'] = false;

        Avis::create($validated);

        return back()->with('success_avis', 'Merci pour votre avis ! Il sera publié après validation.');
    }
}