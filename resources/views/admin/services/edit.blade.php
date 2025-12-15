@extends('layouts.admin')

@section('title', 'Modifier ' . $service->titre)

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Modifier {{ $service->titre }}</h1>
    <p class="text-gray-600 mt-1">
        <a href="{{ route('admin.services.index', $agent) }}" class="text-blue-600 hover:underline">← Retour aux services</a>
    </p>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.services.update', [$agent, $service]) }}" method="POST" enctype="multipart/form-data" x-data="serviceForm()">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Titre -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Titre du service *</label>
                <input type="text" name="titre" value="{{ old('titre', $service->titre) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('titre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image actuelle -->
            @if($service->image)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image actuelle</label>
                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->titre }}" class="h-48 w-auto rounded-lg object-cover">
            </div>
            @endif

            <!-- Nouvelle image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ $service->image ? 'Changer l\'image' : 'Ajouter une image' }}</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="4" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Points forts -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Points forts</label>
                
                <div class="space-y-2">
                    <template x-for="(point, index) in points" :key="index">
                        <div class="flex gap-2">
                            <input type="text" :name="'points_forts[' + index + ']'" x-model="points[index]"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                            <button type="button" @click="removePoint(index)" 
                                class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                                ✕
                            </button>
                        </div>
                    </template>
                </div>
                
                <button type="button" @click="addPoint()" 
                    class="mt-3 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    + Ajouter un point fort
                </button>
            </div>

            <!-- Ordre et statut -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordre d'affichage</label>
                    <input type="number" name="ordre" value="{{ old('ordre', $service->ordre) }}" min="0"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="flex items-center">
                    <label class="flex items-center mt-6">
                        <input type="checkbox" name="actif" value="1" {{ old('actif', $service->actif) ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-medium text-gray-700">Service actif</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.services.index', $agent) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 cursor-pointer">
                Enregistrer
            </button>
        </div>
    </form>
</div>

<script>
function serviceForm() {
    return {
        points: @json(old('points_forts', $service->points_forts ?? ['', ''])),
        addPoint() {
            this.points.push('');
        },
        removePoint(index) {
            this.points.splice(index, 1);
        }
    }
}
</script>
@endsection