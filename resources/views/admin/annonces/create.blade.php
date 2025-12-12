@extends('layouts.admin')

@section('title', 'Nouvelle annonce')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Nouvelle annonce pour {{ $agent->nom_complet }}</h1>
</div>

<div class="bg-white shadow-md rounded-lg p-6" x-data="photoManager()">
    <form action="{{ route('admin.annonces.store', $agent) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'annonce *</label>
                <input type="text" name="titre" value="{{ old('titre') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('titre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prix (€)</label>
                <input type="number" name="prix" value="{{ old('prix') }}" step="0.01" min="0"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('prix')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="vente" {{ old('type') === 'vente' ? 'selected' : '' }}>Vente</option>
                    <option value="location" {{ old('type') === 'location' ? 'selected' : '' }}>Location</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="6" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Photos</label>
                
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
                            <img :src="photo.preview" class="w-full max-w-md h-64 object-contain rounded-lg border border-gray-200 bg-gray-50">
                        </div>
                    </div>
                </template>
                
                <button type="button" @click="addPhoto" 
                    class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    + Ajouter une photo
                </button>
                
                @error('photos.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="visible" value="1" {{ old('visible', true) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Annonce visible sur le mini-site</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.annonces.index', $agent) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Créer l'annonce
            </button>
        </div>
    </form>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function photoManager() {
    return {
        photos: [{ preview: null, file: null }],
        
        addPhoto() {
            this.photos.push({ preview: null, file: null });
        },
        
        removePhoto(index) {
            this.photos.splice(index, 1);
            if (this.photos.length === 0) {
                this.photos.push({ preview: null, file: null });
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