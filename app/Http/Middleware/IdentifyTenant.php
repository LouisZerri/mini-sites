<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Agent;
use Illuminate\Support\Facades\View;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // Si c'est le domaine principal, on passe (admin)
        if ($host === 'gestimmo-conseillers.local' || $host === 'localhost') {
            return $next($request);
        }

        // Extraire le slug du sous-domaine
        $slug = str_replace('.gestimmo-conseillers.local', '', $host);

        // Récupérer l'agent
        $agent = Agent::where('slug', $slug)
            ->where('actif', true)
            ->first();

        if (!$agent) {
            abort(404, 'Agent non trouvé');
        }

        // Partager l'agent avec toutes les vues
        View::share('agent', $agent);

        // Ajouter l'agent à la requête
        $request->merge(['current_agent' => $agent]);

        return $next($request);
    }
}
