@extends('layouts.admin')

@section('title', 'Modifier ' . $agent->nom_complet)

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Modifier {{ $agent->nom_complet }}</h1>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.agents.update', $agent) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Prénom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom', $agent->prenom) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('prenom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom', $agent->nom) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('nom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Titre -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Titre professionnel</label>
                <input type="text" name="titre" value="{{ old('titre', $agent->titre) }}" 
                    placeholder="Ex: Expert en Investissement Locatif"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('titre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $agent->email) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Téléphone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                <input type="text" name="telephone" value="{{ old('telephone', $agent->telephone) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('telephone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Secteur -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Secteur *</label>
                <input type="text" name="secteur" value="{{ old('secteur', $agent->secteur) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('secteur')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Langues -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Langues parlées</label>
                <input type="text" name="langues" value="{{ old('langues', $agent->langues) }}" 
                    placeholder="Ex: FR / EN / ES"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('langues')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo actuelle -->
            @if($agent->photo)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo actuelle</label>
                <img src="{{ Storage::url($agent->photo) }}" alt="{{ $agent->nom_complet }}" class="h-32 w-32 rounded-full object-cover">
            </div>
            @endif

            <!-- Nouvelle photo -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ $agent->photo ? 'Changer la photo' : 'Ajouter une photo' }}</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Accroche -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Accroche (description courte)</label>
                <textarea name="accroche" rows="2" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('accroche', $agent->accroche) }}</textarea>
                @error('accroche')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Biographie</label>
                <textarea name="bio" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('bio', $agent->bio) }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parcours -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mon Parcours</label>
                <textarea name="parcours" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('parcours', $agent->parcours) }}</textarea>
                @error('parcours')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info légale -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Informations légales</label>
                <input type="text" name="info_legale" value="{{ old('info_legale', $agent->info_legale) }}" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('info_legale')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Réseaux sociaux -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-3">Réseaux sociaux</label>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <i class="fab fa-linkedin text-blue-600 text-xl w-6"></i>
                        <input type="url" name="reseaux_sociaux[linkedin]" value="{{ old('reseaux_sociaux.linkedin', $agent->reseaux_sociaux['linkedin'] ?? '') }}" 
                            placeholder="https://linkedin.com/in/..."
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-facebook text-blue-500 text-xl w-6"></i>
                        <input type="url" name="reseaux_sociaux[facebook]" value="{{ old('reseaux_sociaux.facebook', $agent->reseaux_sociaux['facebook'] ?? '') }}" 
                            placeholder="https://facebook.com/..."
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-instagram text-pink-500 text-xl w-6"></i>
                        <input type="url" name="reseaux_sociaux[instagram]" value="{{ old('reseaux_sociaux.instagram', $agent->reseaux_sociaux['instagram'] ?? '') }}" 
                            placeholder="https://instagram.com/..."
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Statuts -->
            <div class="md:col-span-2 flex gap-6">
                <label class="flex items-center">
                    <input type="checkbox" name="actif" value="1" {{ old('actif', $agent->actif) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Compte actif</span>
                </label>
                
                <label class="flex items-center">
                    <input type="checkbox" name="disponible" value="1" {{ old('disponible', $agent->disponible) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Disponible (pastille verte)</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.agents.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection