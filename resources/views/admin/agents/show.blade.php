@extends('layouts.admin')

@section('title', 'Détails agent')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">{{ $agent->nom_complet }}</h1>
            <div class="space-x-2">
                <a href="{{ $agent->url }}" target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Voir le mini-site →
                </a>
                <a href="{{ route('admin.agents.edit', $agent) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Modifier
                </a>
                <a href="{{ route('admin.agents.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Retour
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="md:col-span-2 space-y-6">
            <!-- Informations -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Informations</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $agent->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $agent->telephone }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Secteur</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $agent->secteur }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $agent->slug }}</dd>
                    </div>
                </dl>
                @if ($agent->bio)
                    <div class="mt-4">
                        <dt class="text-sm font-medium text-gray-500">Biographie</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $agent->bio }}</dd>
                    </div>
                @endif
            </div>

            <!-- Annonces -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Annonces ({{ $agent->annonces->count() }})</h2>
                    <a href="{{ route('admin.annonces.index', $agent) }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Gérer les annonces →
                    </a>
                </div>
                @forelse($agent->annonces as $annonce)
                    <div class="border-b pb-3 mb-3 last:border-0">
                        <h3 class="font-semibold">{{ $annonce->titre }}</h3>
                        <p class="text-sm text-gray-600">{{ number_format($annonce->prix, 0, ',', ' ') }}€ -
                            {{ ucfirst($annonce->type) }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Aucune annonce</p>
                @endforelse
            </div>

            <!-- Avis -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Avis ({{ $agent->avis->count() }})</h2>
                    <a href="{{ route('admin.avis.index', $agent) }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Gérer les avis →
                    </a>
                </div>
                @forelse($agent->avisValides->take(3) as $avis)
                    <div class="border-b pb-3 mb-3 last:border-0">
                        <div class="flex items-center mb-1">
                            <span class="font-semibold">{{ $avis->nom_client }}</span>
                            <span class="ml-2 text-yellow-500">{{ str_repeat('⭐', $avis->note) }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $avis->commentaire }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Aucun avis validé</p>
                @endforelse

                @if ($agent->avis->where('valide', false)->count() > 0)
                    <div class="mt-4 bg-orange-50 border-l-4 border-orange-500 text-orange-700 p-3 rounded text-sm">
                        ⚠️ {{ $agent->avis->where('valide', false)->count() }} avis en attente de validation
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Photo -->
            <div class="bg-white shadow-md rounded-lg p-6">
                @if ($agent->photo)
                    <img src="{{ Storage::url($agent->photo) }}" alt="{{ $agent->nom_complet }}"
                        class="w-full rounded-lg">
                @else
                    <div
                        class="w-full h-48 bg-blue-600 rounded-lg flex items-center justify-center text-white text-6xl font-bold">
                        {{ strtoupper(substr($agent->prenom, 0, 1) . substr($agent->nom, 0, 1)) }}
                    </div>
                @endif
            </div>

            <!-- Statistiques -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="font-bold mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-500">Annonces</div>
                        <div class="text-2xl font-bold">{{ $agent->annonces->count() }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Avis</div>
                        <div class="text-2xl font-bold">{{ $agent->avisValides->count() }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Note moyenne</div>
                        <div class="text-2xl font-bold">{{ number_format($agent->moyenne_avis, 1) }}/5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
