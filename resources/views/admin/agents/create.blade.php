@extends('layouts.admin')

@section('title', 'Nouvel agent')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Nouvel agent</h1>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.agents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Prénom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('prenom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('nom')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Titre -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Titre professionnel</label>
                <input type="text" name="titre" value="{{ old('titre') }}" 
                    placeholder="Ex: Expert en Investissement Locatif"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Affiché sous le nom sur le mini-site</p>
                @error('titre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Téléphone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('telephone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Secteur -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Secteur *</label>
                <input type="text" name="secteur" value="{{ old('secteur') }}" required
                    placeholder="Ex: Lyon"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('secteur')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Langues -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Langues parlées</label>
                <input type="text" name="langues" value="{{ old('langues', 'FR') }}" 
                    placeholder="Ex: FR / EN / ES"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('langues')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
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
                    placeholder="Ex: Spécialiste de l'immobilier locatif à haut rendement..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('accroche') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Affichée sous les badges sur le mini-site (max 500 caractères)</p>
                @error('accroche')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Biographie</label>
                <textarea name="bio" rows="4"
                    placeholder="Présentation générale..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parcours -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mon Parcours</label>
                <textarea name="parcours" rows="4"
                    placeholder="Ex: Ancien gestionnaire de patrimoine..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('parcours') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Affiché dans l'onglet "Mon Parcours" du mini-site</p>
                @error('parcours')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info légale -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Informations légales</label>
                <input type="text" name="info_legale" value="{{ old('info_legale') }}" 
                    placeholder="Ex: Agent commercial - 123 456 789 RSAC Lyon"
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
                        <input type="url" name="reseaux_sociaux[linkedin]" value="{{ old('reseaux_sociaux.linkedin') }}" 
                            placeholder="https://linkedin.com/in/..."
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-facebook text-blue-500 text-xl w-6"></i>
                        <input type="url" name="reseaux_sociaux[facebook]" value="{{ old('reseaux_sociaux.facebook') }}" 
                            placeholder="https://facebook.com/..."
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-instagram text-pink-500 text-xl w-6"></i>
                        <input type="url" name="reseaux_sociaux[instagram]" value="{{ old('reseaux_sociaux.instagram') }}" 
                            placeholder="https://instagram.com/..."
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Statuts -->
            <div class="md:col-span-2 flex gap-6">
                <label class="flex items-center">
                    <input type="checkbox" name="actif" value="1" {{ old('actif', true) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Compte actif</span>
                </label>
                
                <label class="flex items-center">
                    <input type="checkbox" name="disponible" value="1" {{ old('disponible', true) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Disponible (pastille verte)</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.agents.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 cursor-pointer">
                Créer l'agent
            </button>
        </div>
    </form>
</div>
@endsection