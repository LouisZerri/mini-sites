@extends('layouts.admin')

@section('title', 'Modifier l\'annonce')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Modifier l'annonce</h1>
        <p class="text-gray-600 mt-1">{{ $agent->nom_complet }}</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6" x-data="photoManager()">
        <form action="{{ route('admin.annonces.update', [$agent, $annonce]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'annonce *</label>
                    <input type="text" name="titre" value="{{ old('titre', $annonce->titre) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix (€)</label>
                    <input type="number" name="prix" value="{{ old('prix', $annonce->prix) }}" step="0.01"
                        min="0"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    @error('prix')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                    <select name="type" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="vente" {{ old('type', $annonce->type) === 'vente' ? 'selected' : '' }}>Vente
                        </option>
                        <option value="location" {{ old('type', $annonce->type) === 'location' ? 'selected' : '' }}>Location
                        </option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea name="description" rows="6" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $annonce->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if ($annonce->photos && count($annonce->photos) > 0)
                    <div class="md:col-span-2" x-data="{ photosToDelete: [] }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photos actuelles</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            @foreach ($annonce->photos as $index => $photo)
                                <div class="relative" x-data="{ deleted: false }">
                                    <img src="{{ Storage::url($photo) }}" alt="Photo"
                                        class="w-full h-48 object-cover rounded-lg border border-gray-200"
                                        :class="{ 'opacity-50 grayscale': deleted }">

                                    <button type="button"
                                        @click="deleted = !deleted; if(deleted) { photosToDelete.push('{{ $photo }}') } else { photosToDelete = photosToDelete.filter(p => p !== '{{ $photo }}') }"
                                        class="absolute top-1 right-1 rounded-full w-6 h-6 flex items-center justify-center font-bold shadow-lg transition-colors text-sm"
                                        :class="deleted ? 'bg-green-600 hover:bg-green-700 text-white' :
                                            'bg-red-600 hover:bg-red-700 text-white'">
                                        <span x-text="deleted ? '↺' : '×'"></span>
                                    </button>

                                    <input type="hidden" :name="deleted ? 'delete_photos[]' : ''"
                                        :value="deleted ? '{{ $photo }}' : ''">
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-600">
                            💡 Cliquez sur <span class="font-bold text-red-600">×</span> pour marquer une photo à supprimer.
                            Cliquez sur <span class="font-bold text-green-600">↺</span> pour annuler.
                        </p>
                        <p class="text-sm text-orange-600 bg-orange-50 p-3 rounded mt-2">
                            ⚠️ Uploader de nouvelles photos en bas remplacera TOUTES les photos (actuelles + nouvelles)
                        </p>
                    </div>
                @endif

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nouvelles photos (optionnel)</label>

                    <!-- Liste des photos -->
                    <template x-for="(photo, index) in photos" :key="index">
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-3 mb-3">
                                <input type="file" :name="'photos[]'" accept="image/*"
                                    @change="handleFileChange($event, index)"
                                    class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

                                <button type="button" @click="removePhoto(index)"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 whitespace-nowrap">
                                    Supprimer
                                </button>
                            </div>

                            <!-- Prévisualisation en dessous -->
                            <div x-show="photo.preview" class="mt-3">
                                <img :src="photo.preview"
                                    class="w-full max-w-md h-64 object-contain rounded-lg border border-gray-200 bg-gray-50">
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="addPhoto"
                        class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        + Ajouter une photo
                    </button>

                    <p class="mt-2 text-sm text-gray-500">Laisser vide pour garder les photos actuelles</p>

                    @error('photos.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="visible" value="1"
                            {{ old('visible', $annonce->visible) ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-700">Annonce visible sur le mini-site</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.annonces.index', $agent) }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function photoManager() {
            return {
                photos: [{
                    preview: null,
                    file: null
                }],

                addPhoto() {
                    this.photos.push({
                        preview: null,
                        file: null
                    });
                },

                removePhoto(index) {
                    this.photos.splice(index, 1);
                    if (this.photos.length === 0) {
                        this.photos.push({
                            preview: null,
                            file: null
                        });
                    }
                },

                handleFileChange(event, index) {
                    const file = event.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.photos[index].preview = e.target.result;
                            this.photos[index].file = file;
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        }
    </script>
@endsection
