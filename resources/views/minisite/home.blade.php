<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agent->nom_complet }} - Agent Immobilier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <div class="flex-grow">
        <!-- Header -->
        <header class="bg-white shadow-md sticky top-0 z-40" style="border-top: 4px solid {{ $agent->couleur_primaire }}">
            <div class="max-w-6xl mx-auto px-4 py-4">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        @if ($agent->photo)
                            <img src="{{ Storage::url($agent->photo) }}" alt="{{ $agent->nom_complet }}"
                                class="w-16 h-16 rounded-full object-cover ring-4 ring-white shadow-lg">
                        @else
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-xl ring-4 ring-white shadow-lg"
                                style="background-color: {{ $agent->couleur_primaire }}">
                                {{ strtoupper(substr($agent->prenom, 0, 1) . substr($agent->nom, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $agent->nom_complet }}</h1>
                            <p class="text-gray-600 text-sm flex items-center gap-2">
                                <i class="fas fa-map-marker-alt"></i>
                                Agent Immobilier - {{ $agent->secteur }}
                            </p>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <a href="tel:{{ $agent->telephone }}"
                            class="text-lg font-semibold hover:underline flex items-center gap-2"
                            style="color: {{ $agent->couleur_primaire }}">
                            <i class="fas fa-phone"></i>
                            {{ $agent->telephone }}
                        </a>
                        <a href="mailto:{{ $agent->email }}"
                            class="text-sm text-gray-600 hover:underline flex items-center gap-2 justify-center md:justify-end mt-1">
                            <i class="fas fa-envelope"></i>
                            {{ $agent->email }}
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Bio -->
        @if ($agent->bio)
            <section class="max-w-6xl mx-auto px-4 py-8 opacity-0 animate-fade-in-up stagger-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
                    <h2 class="text-2xl font-bold mb-3 flex items-center gap-2"
                        style="color: {{ $agent->couleur_primaire }}">
                        <i class="fas fa-user-circle"></i>
                        À propos
                    </h2>
                    <p class="text-gray-700 leading-relaxed">{{ $agent->bio }}</p>
                </div>
            </section>
        @endif

        <!-- Annonces -->
        @if ($agent->annonces->count() > 0)
            <section class="max-w-6xl mx-auto px-4 py-8 opacity-0 animate-fade-in-up stagger-2" x-data="{
                isOpen: false,
                currentImages: [],
                currentIndex: 0,
            
                get currentImage() {
                    return this.currentImages[this.currentIndex] ? '{{ Storage::url('') }}' + this.currentImages[this.currentIndex] : '';
                },
            
                get totalImages() {
                    return this.currentImages.length;
                },
            
                openGallery(photos, startIndex) {
                    this.currentImages = photos;
                    this.currentIndex = startIndex;
                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';
                },
            
                close() {
                    this.isOpen = false;
                    document.body.style.overflow = 'auto';
                },
            
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.totalImages;
                },
            
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.totalImages) % this.totalImages;
                }
            }"
                @keydown.window.escape="close()" @keydown.window.arrow-right="isOpen && next()"
                @keydown.window.arrow-left="isOpen && prev()">

                <h2 class="text-2xl font-bold mb-6 flex items-center gap-2"
                    style="color: {{ $agent->couleur_primaire }}">
                    <i class="fas fa-home"></i>
                    Mes annonces
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($agent->annonces as $annonce)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-scale">
                            <!-- Photo principale -->
                            @if ($annonce->photos && count($annonce->photos) > 0)
                                <div class="relative h-56 cursor-pointer group"
                                    @click="openGallery(@js($annonce->photos), 0)">
                                    <img src="{{ Storage::url($annonce->photos[0]) }}" alt="{{ $annonce->titre }}"
                                        class="w-full h-full object-cover">
                                    @if (count($annonce->photos) > 1)
                                        <div
                                            class="absolute bottom-3 right-3 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm flex items-center gap-1">
                                            <i class="fas fa-images"></i>
                                            {{ count($annonce->photos) }}
                                        </div>
                                    @endif
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                                        <i
                                            class="fas fa-search-plus text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="h-56 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-5xl"></i>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">{{ $annonce->titre }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ Str::limit($annonce->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold" style="color: {{ $agent->couleur_primaire }}">
                                        {{ number_format($annonce->prix, 0, ',', ' ') }} €
                                    </span>
                                    <span class="text-sm text-white px-3 py-1 rounded-full"
                                        style="background-color: {{ $agent->couleur_secondaire }}">
                                        {{ ucfirst($annonce->type) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Mini galerie -->
                            @if ($annonce->photos && count($annonce->photos) > 1)
                                <div class="px-4 pb-4 grid grid-cols-4 gap-2">
                                    @foreach (array_slice($annonce->photos, 1, 4) as $index => $photo)
                                        <img src="{{ Storage::url($photo) }}" alt="Photo {{ $index + 2 }}"
                                            class="w-full h-14 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity"
                                            @click.stop="openGallery(@js($annonce->photos), {{ $index + 1 }})">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Lightbox -->
                <template x-teleport="body">
                    <div x-show="isOpen" x-cloak @click="close()"
                        class="fixed inset-0 z-[9999] flex items-center justify-center"
                        style="background: rgba(0, 0, 0, 0.92);" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">

                        <!-- Container central -->
                        <div class="relative w-full h-full flex items-center justify-center p-8">

                            <!-- Image -->
                            <div @click.stop class="relative max-w-6xl max-h-full">
                                <img :src="currentImage" alt="Photo"
                                    class="max-w-full max-h-[90vh] w-auto h-auto object-contain shadow-2xl"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100">
                            </div>

                            <!-- Bouton fermer -->
                            <button @click="close()"
                                class="absolute top-6 right-6 w-12 h-12 flex items-center justify-center rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 text-white backdrop-blur-sm transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Flèche gauche -->
                            <button x-show="totalImages > 1" @click.stop="prev()"
                                class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 text-white backdrop-blur-sm transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Flèche droite -->
                            <button x-show="totalImages > 1" @click.stop="next()"
                                class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 text-white backdrop-blur-sm transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <!-- Compteur -->
                            <div
                                class="absolute bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 rounded-full bg-white bg-opacity-10 backdrop-blur-sm text-white text-sm font-medium">
                                <span x-text="(currentIndex + 1) + ' / ' + totalImages"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </section>
        @endif

        <!-- Avis -->
        @if ($agent->avisValides->count() > 0)
            <section class="max-w-6xl mx-auto px-4 py-8 opacity-0 animate-fade-in-up stagger-3">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-2"
                    style="color: {{ $agent->couleur_primaire }}">
                    <i class="fas fa-star"></i>
                    Avis clients
                    <span
                        class="text-base font-normal text-gray-600">({{ number_format($agent->moyenne_avis, 1) }}/5)</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($agent->avisValides as $avis)
                        <div class="bg-white rounded-2xl shadow-lg p-5 hover-scale">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold"
                                    style="background-color: {{ $agent->couleur_primaire }}">
                                    {{ strtoupper(substr($avis->nom_client, 0, 1)) }}
                                </div>
                                <div class="ml-3 flex-1">
                                    <span class="font-bold">{{ $avis->nom_client }}</span>
                                    <div class="text-yellow-500">
                                        {{ str_repeat('⭐', $avis->note) }}
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 italic text-sm">"{{ $avis->commentaire }}"</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Contact -->
        <section class="max-w-6xl mx-auto px-4 py-8 opacity-0 animate-fade-in-up stagger-3">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-5 flex items-center gap-2"
                    style="color: {{ $agent->couleur_primaire }}">
                    <i class="fas fa-envelope"></i>
                    Me contacter
                </h2>

                @if (session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('minisite.contact', $agent->slug) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="nom" placeholder="Votre nom *" required
                            class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <input type="email" name="email" placeholder="Votre email *" required
                            class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <input type="tel" name="telephone" placeholder="Votre téléphone"
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <textarea name="message" rows="5" placeholder="Votre message *" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    <button type="submit"
                        class="text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity flex items-center gap-2"
                        style="background-color: {{ $agent->couleur_primaire }}">
                        <i class="fas fa-paper-plane"></i>
                        Envoyer le message
                    </button>
                </form>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-12 py-6">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>© {{ date('Y') }} {{ $agent->nom_complet }} - Tous droits réservés</p>
            @if ($agent->reseaux_sociaux)
                <div class="flex justify-center gap-4 mt-3">
                    @if (isset($agent->reseaux_sociaux['linkedin']))
                        <a href="{{ $agent->reseaux_sociaux['linkedin'] }}" target="_blank"
                            class="text-xl hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    @endif
                    @if (isset($agent->reseaux_sociaux['facebook']))
                        <a href="{{ $agent->reseaux_sociaux['facebook'] }}" target="_blank"
                            class="text-xl hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </footer>
</body>

</html>
