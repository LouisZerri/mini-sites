@extends('layouts.admin')

@section('title', 'Annonces de ' . $agent->nom_complet)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Annonces de {{ $agent->nom_complet }}</h1>
        <p class="text-gray-600 mt-1">{{ $annonces->total() }} annonce(s)</p>
    </div>
    <div class="space-x-2">
        <a href="{{ route('admin.agents.show', $agent) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            ← Retour à l'agent
        </a>
        <a href="{{ route('admin.annonces.create', $agent) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            + Nouvelle annonce
        </a>
    </div>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Annonce</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($annonces as $annonce)
            <tr>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $annonce->titre }}</div>
                    <div class="text-sm text-gray-500">{{ Str::limit($annonce->description, 60) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $annonce->prix ? number_format($annonce->prix, 0, ',', ' ') . ' €' : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $annonce->type === 'vente' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($annonce->type) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $annonce->photos ? count($annonce->photos) : 0 }} photo(s)
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($annonce->visible)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Visible
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Masquée
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.annonces.edit', [$agent, $annonce]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                    <form action="{{ route('admin.annonces.destroy', [$agent, $annonce]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="text-red-600 hover:text-red-900 cursor-pointer">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <p class="mb-4">Aucune annonce pour cet agent.</p>
                    <a href="{{ route('admin.annonces.create', $agent) }}" class="text-blue-600 hover:text-blue-800">
                        Créer la première annonce →
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $annonces->links() }}
</div>
@endsection