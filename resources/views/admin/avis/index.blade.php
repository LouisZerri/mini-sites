@extends('layouts.admin')

@section('title', 'Avis de ' . $agent->nom_complet)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Avis de {{ $agent->nom_complet }}</h1>
        <p class="text-gray-600 mt-1">{{ $avis->total() }} avis - {{ $agent->avisValides->count() }} validé(s)</p>
    </div>
    <div class="space-x-2">
        <a href="{{ route('admin.agents.show', $agent) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            ← Retour à l'agent
        </a>
        <a href="{{ route('admin.avis.create', $agent) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            + Nouvel avis
        </a>
    </div>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaire</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($avis as $unAvis)
            <tr class="{{ !$unAvis->valide ? 'bg-gray-50' : '' }}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $unAvis->nom_client }}</div>
                    <div class="text-sm text-gray-500">{{ $unAvis->created_at->format('d/m/Y') }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ Str::limit($unAvis->commentaire, 100) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center text-yellow-500 text-lg">
                        {{ str_repeat('⭐', $unAvis->note) }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <form action="{{ route('admin.avis.toggle', [$agent, $unAvis]) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-xs font-semibold rounded-full transition-colors
                            {{ $unAvis->valide ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                            {{ $unAvis->valide ? '✓ Validé' : '✗ En attente' }}
                        </button>
                    </form>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.avis.edit', [$agent, $unAvis]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                    <form action="{{ route('admin.avis.destroy', [$agent, $unAvis]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="text-red-600 hover:text-red-900">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    <p class="mb-4">Aucun avis pour cet agent.</p>
                    <a href="{{ route('admin.avis.create', $agent) }}" class="text-blue-600 hover:text-blue-800">
                        Créer le premier avis →
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $avis->links() }}
</div>
@endsection