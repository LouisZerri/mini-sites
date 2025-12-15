@extends('layouts.admin')

@section('title', 'Agents')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Agents</h1>
    <a href="{{ route('admin.agents.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        + Créer un agent
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Secteur</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($agents as $agent)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        @if($agent->photo)
                            <img src="{{ Storage::url($agent->photo) }}" alt="{{ $agent->nom_complet }}" class="h-10 w-10 rounded-full object-cover">
                        @else
                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($agent->prenom, 0, 1) . substr($agent->nom, 0, 1)) }}
                            </div>
                        @endif
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $agent->nom_complet }}</div>
                            @if($agent->titre)
                                <div class="text-sm text-gray-500">{{ $agent->titre }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $agent->email }}</div>
                    <div class="text-sm text-gray-500">{{ $agent->telephone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $agent->secteur }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex gap-2">
                        @if($agent->actif)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Inactif
                            </span>
                        @endif
                        
                        @if($agent->disponible)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Disponible
                            </span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ $agent->url }}" target="_blank" class="text-green-600 hover:text-green-900 mr-3">Mini-site</a>
                    <a href="{{ route('admin.agents.show', $agent) }}" class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
                    <a href="{{ route('admin.agents.edit', $agent) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                    <form action="{{ route('admin.agents.destroy', $agent) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Êtes-vous sûr ? Cela supprimera aussi tous les services et avis.')" class="text-red-600 hover:text-red-900 cursor-pointer">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    Aucun agent trouvé.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $agents->links() }}
</div>
@endsection