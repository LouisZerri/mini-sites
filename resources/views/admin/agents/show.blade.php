@extends('layouts.admin')

@section('title', $agent->nom_complet)

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">{{ $agent->nom_complet }}</h1>
        <div class="flex gap-3">
            <a href="{{ $agent->url }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Voir le mini-site
            </a>
            <a href="{{ route('admin.agents.edit', $agent) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Modifier
            </a>
        </div>
    </div>

    <!-- Infos agent -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex items-start gap-6">
            @if ($agent->photo)
                <div class="h-32 w-32 rounded-full overflow-hidden">
                    <img src="{{ Storage::url($agent->photo) }}" alt="{{ $agent->nom_complet }}"
                        class="w-full h-full object-cover" style="object-position: 50% 20%;">
                </div>
            @else
                <div
                    class="h-32 w-32 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-4xl">
                    {{ strtoupper(substr($agent->prenom, 0, 1) . substr($agent->nom, 0, 1)) }}
                </div>
            @endif

            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900">{{ $agent->nom_complet }}</h2>
                @if ($agent->titre)
                    <p class="text-lg text-gray-600 mb-4">{{ $agent->titre }}</p>
                @endif

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><strong>Email:</strong> {{ $agent->email }}</div>
                    <div><strong>Téléphone:</strong> {{ $agent->telephone }}</div>
                    <div><strong>Secteur:</strong> {{ $agent->secteur }}</div>
                    <div><strong>Langues:</strong> {{ $agent->langues }}</div>
                    <div>
                        <strong>Statut:</strong>
                        @if ($agent->actif)
                            <span class="text-green-600">Actif</span>
                        @else
                            <span class="text-red-600">Inactif</span>
                        @endif
                    </div>
                    <div>
                        <strong>Disponibilité:</strong>
                        @if ($agent->disponible)
                            <span class="text-green-600">Disponible</span>
                        @else
                            <span class="text-gray-600">Non disponible</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services et Avis -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Services -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Services
                    ({{ $agent->services ? $agent->services->count() : 0 }})</h3>
                <a href="{{ route('admin.services.create', $agent) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    + Ajouter
                </a>
            </div>

            @if ($agent->services && $agent->services->count() > 0)
                <div class="space-y-3">
                    @foreach ($agent->services as $service)
                        <div class="border border-gray-200 rounded p-3">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">{{ $service->titre }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($service->description, 80) }}</p>
                                </div>
                                <a href="{{ route('admin.services.edit', [$agent, $service]) }}"
                                    class="text-blue-600 hover:text-blue-900 text-sm ml-2">
                                    Modifier
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Aucun service configuré.</p>
            @endif

            <a href="{{ route('admin.services.index', $agent) }}"
                class="block text-center text-blue-600 hover:text-blue-900 mt-4 text-sm">
                Gérer les services →
            </a>
        </div>

        <!-- Avis -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Avis ({{ $agent->avis->count() }})</h3>
                <a href="{{ route('admin.avis.create', $agent) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    + Ajouter
                </a>
            </div>

            @php
                $avisPending = $agent->avis->where('valide', false)->count();
            @endphp

            @if ($avisPending > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-4">
                    <p class="text-sm text-yellow-700">
                        <strong>{{ $avisPending }}</strong> avis en attente de validation
                    </p>
                </div>
            @endif

            @if ($agent->avisValides->count() > 0)
                <div class="space-y-3">
                    @foreach ($agent->avisValides->take(3) as $avis)
                        <div class="border border-gray-200 rounded p-3">
                            <div class="flex justify-between items-start mb-2">
                                <div class="font-bold text-gray-900">{{ $avis->nom_client }}</div>
                                <div class="text-yellow-400">
                                    @for ($i = 0; $i < $avis->note; $i++)
                                        ⭐
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">{{ Str::limit($avis->commentaire, 80) }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Aucun avis validé.</p>
            @endif

            <a href="{{ route('admin.avis.index', $agent) }}"
                class="block text-center text-blue-600 hover:text-blue-900 mt-4 text-sm">
                Gérer les avis →
            </a>
        </div>
    </div>
@endsection
