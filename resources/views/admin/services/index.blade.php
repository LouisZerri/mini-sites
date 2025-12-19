@extends('layouts.admin')

@section('title', 'Services de ' . $agent->nom_complet)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Services de {{ $agent->nom_complet }}</h1>
        <p class="text-gray-600 mt-1">
            <a href="{{ route('admin.agents.show', $agent) }}" class="text-blue-600 hover:underline">← Retour à la fiche agent</a>
        </p>
    </div>
    <a href="{{ route('admin.services.create', $agent) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        + Créer un service
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ordre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($services as $service)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                    {{ $service->ordre }}
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $service->titre }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-600">{{ Str::limit($service->description, 100) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($service->actif)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Actif
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Inactif
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.services.edit', [$agent, $service]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                    <form action="{{ route('admin.services.destroy', [$agent, $service]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ce service ?')" class="text-red-600 hover:text-red-900 cursor-pointer">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    Aucun service. Créez-en un pour qu'il apparaisse sur le mini-site !
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection