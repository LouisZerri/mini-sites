<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Mail;

class MiniSiteController extends Controller
{
    public function index(Request $request, $slug)
    {
        // Récupérer l'agent depuis le slug
        $agent = Agent::where('slug', $slug)
            ->where('actif', true)
            ->firstOrFail();

        // Charger les relations
        $agent->load([
            'annonces' => function ($query) {
                $query->where('visible', true)->latest()->limit(6);
            },
            'avisValides' => function ($query) {
                $query->latest()->limit(5);
            }
        ]);

        return view('minisite.home', compact('agent'));
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
        ]);

        try {
            // Envoyer l'email au conseiller
            Mail::to($agent->email)->send(new ContactMail($validated, $agent));

            return back()->with('success', 'Votre message a été envoyé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi du message. Veuillez réessayer.');
        }
    }
}
