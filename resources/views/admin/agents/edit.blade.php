@extends('layouts.admin')

@section('title', 'Modifier agent')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Modifier {{ $agent->nom_complet }}</h1>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.agents.update', $agent) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom', $agent->prenom) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('prenom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom', $agent->nom) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('nom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $agent->email) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                <input type="text" name="telephone" value="{{ old('telephone', $agent->telephone) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('telephone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Secteur *</label>
                <input type="text" name="secteur" value="{{ old('secteur', $agent->secteur) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('secteur')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                @if($agent->photo)
                    <img src="{{ Storage::url($agent->photo) }}" class="w-20 h-20 rounded-full object-cover mb-2">
                @endif
                <input type="file" name="photo" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="actif" value="1" {{ old('actif', $agent->actif) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Agent actif</span>
                </label>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Biographie</label>
            <textarea name="bio" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('bio', $agent->bio) }}</textarea>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.agents.show', $agent) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection