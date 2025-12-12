@extends('layouts.admin')

@section('title', 'Nouvel avis')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Nouvel avis pour {{ $agent->nom_complet }}</h1>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.avis.store', $agent) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom du client *</label>
                <input type="text" name="nom_client" value="{{ old('nom_client') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('nom_client')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Note *</label>
                <select name="note" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Choisir une note</option>
                    <option value="5" {{ old('note') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5/5)</option>
                    <option value="4" {{ old('note') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4/5)</option>
                    <option value="3" {{ old('note') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3/5)</option>
                    <option value="2" {{ old('note') == 2 ? 'selected' : '' }}>⭐⭐ (2/5)</option>
                    <option value="1" {{ old('note') == 1 ? 'selected' : '' }}>⭐ (1/5)</option>
                </select>
                @error('note')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire *</label>
                <textarea name="commentaire" rows="6" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('commentaire') }}</textarea>
                @error('commentaire')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="valide" value="1" {{ old('valide', true) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Avis validé (visible sur le mini-site)</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.avis.index', $agent) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Créer l'avis
            </button>
        </div>
    </form>
</div>
@endsection