<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agent->nom_complet }} - {{ $agent->titre ?? 'Conseiller Immobilier' }} | GEST'IMMO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        .font-heading {
            font-family: 'Montserrat', sans-serif;
        }

        /* Boutons navigation onglets */
        .advisor-nav-btn {
            @apply px-6 py-3 rounded-full font-bold text-sm uppercase tracking-wide transition-all duration-300 shadow-sm border border-gray-100 flex items-center gap-2;
        }

        .advisor-nav-btn:not(.active) {
            @apply bg-white text-gray-500 hover:bg-gray-50 hover:shadow-md hover:text-blue-700;
        }

        .advisor-nav-btn.active {
            @apply bg-blue-700 text-white shadow-lg border-blue-700 transform scale-105;
        }
    </style>
</head>

<body class="bg-gray-50" x-data="miniSite()">

    <!-- HEADER CONSEILLER -->
    <div class="bg-white border-b border-gray-200 pt-8 pb-10">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Logo GEST'IMMO en haut -->
            <div class="flex items-center gap-1 mb-8">
                <img src="{{ asset('images/logo3d.png') }}" alt="Logo" class="w-20 h-20">
                <div class="flex flex-col leading-none">
                    <span class="font-heading font-extrabold text-xl text-blue-700 tracking-tight">
                        GEST'<span class="text-red-800">IMMO</span>
                    </span>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">L'investissement en plus
                        simple</span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-8 items-start">
                <!-- Photo & Réseaux Sociaux -->
                <div class="flex-shrink-0 mx-auto md:mx-0 relative flex flex-col items-center">
                    <div class="relative group">
                        <div
                            class="p-1.5 bg-white rounded-full shadow-2xl border-2 border-gray-100 group-hover:border-blue-700 transition duration-500">
                            @if ($agent->photo)
                                <img src="{{ Storage::url($agent->photo) }}"
                                    class="w-44 h-44 rounded-full object-cover transform group-hover:scale-[1.02] transition duration-500"
                                    alt="{{ $agent->nom_complet }}">
                            @else
                                <div
                                    class="w-44 h-44 rounded-full bg-blue-700 flex items-center justify-center text-white font-bold text-5xl">
                                    {{ strtoupper(substr($agent->prenom, 0, 1) . substr($agent->nom, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        @if ($agent->disponible)
                            <span
                                class="absolute bottom-4 right-4 bg-green-500 w-5 h-5 border-4 border-white rounded-full animate-pulse"
                                title="Disponible"></span>
                        @endif
                    </div>

                    <!-- Réseaux Sociaux -->
                    @if ($agent->reseaux_sociaux && count(array_filter($agent->reseaux_sociaux)) > 0)
                        <div class="mt-6 flex gap-4">
                            @if (!empty($agent->reseaux_sociaux['linkedin']))
                                <a href="{{ $agent->reseaux_sociaux['linkedin'] }}" target="_blank"
                                    class="w-12 h-12 rounded-full bg-[#0077b5] text-white flex items-center justify-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 transform hover:scale-110">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                            @endif

                            @if (!empty($agent->reseaux_sociaux['instagram']))
                                <a href="{{ $agent->reseaux_sociaux['instagram'] }}" target="_blank"
                                    class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 transform hover:scale-110">
                                    <i class="fab fa-instagram text-xl"></i>
                                </a>
                            @endif

                            @if (!empty($agent->reseaux_sociaux['facebook']))
                                <a href="{{ $agent->reseaux_sociaux['facebook'] }}" target="_blank"
                                    class="w-12 h-12 rounded-full bg-[#1877F2] text-white flex items-center justify-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 transform hover:scale-110">
                                    <i class="fab fa-facebook-f text-xl"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Infos & Stats -->
                <div class="flex-grow text-center md:text-left pt-2">
                    <h1 class="font-heading font-extrabold text-3xl md:text-4xl text-gray-900 mb-2">
                        {{ $agent->nom_complet }}</h1>
                    @if ($agent->titre)
                        <p class="text-lg text-gray-500 font-medium mb-6">{{ $agent->titre }}</p>
                    @endif

                    <div class="flex flex-wrap justify-center md:justify-start gap-3 mb-8">
                        <span
                            class="px-4 py-2 bg-gray-50 text-gray-700 rounded-lg text-xs font-bold uppercase tracking-wide border border-gray-200 flex items-center shadow-sm">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-700"></i> {{ $agent->secteur }}
                        </span>
                        @if ($agent->langues)
                            <span
                                class="px-4 py-2 bg-gray-50 text-gray-700 rounded-lg text-xs font-bold uppercase tracking-wide border border-gray-200 flex items-center shadow-sm">
                                <i class="fas fa-language mr-2 text-blue-700"></i> {{ $agent->langues }}
                            </span>
                        @endif
                        @if ($agent->avisValides->count() > 0)
                            <span
                                class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold uppercase tracking-wide border border-blue-100 flex items-center shadow-sm">
                                <i class="fas fa-star mr-2"></i>
                                {{ number_format($agent->avisValides->avg('note'), 1) }}/5
                                ({{ $agent->avisValides->count() }} Avis)
                            </span>
                        @endif
                    </div>

                    @if ($agent->accroche)
                        <p
                            class="text-gray-600 text-sm max-w-2xl leading-relaxed hidden md:block border-l-4 border-blue-700 pl-4">
                            "{{ $agent->accroche }}"
                        </p>
                    @endif
                </div>

                <!-- BOUTONS ACTIONS -->
                <div class="flex flex-col gap-3 w-full md:w-auto mt-6 md:mt-0">
                    <button @click="scrollToContact()"
                        class="bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-white text-base px-8 py-3 rounded-xl font-bold shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-envelope text-lg"></i> CONTACTER
                    </button>

                    <a href="tel:{{ $agent->telephone }}"
                        class="bg-white text-blue-700 border-2 border-blue-700 hover:bg-blue-50 text-base px-8 py-3 rounded-xl font-bold shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2 group whitespace-nowrap">
                        <i class="fas fa-phone group-hover:rotate-12 transition-transform text-lg"></i>
                        <span>{{ $agent->telephone }}</span>
                    </a>
                </div>
            </div>

            <!-- INFO LEGALE -->
            @if ($agent->info_legale)
                <div class="mt-10 pt-8 border-t border-gray-100 text-center md:text-left">
                    <p class="text-sm font-bold text-gray-900">{{ $agent->nom_complet }} - Conseiller Indépendant en
                        Immobilier.</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $agent->info_legale }}</p>
                </div>
            @endif

            <!-- NAVIGATION ONGLETS -->
            <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-6">
                <button @click="activeTab = 'services'" :class="activeTab === 'services' ? 'active' : ''"
                    class="advisor-nav-btn">
                    <i class="fas fa-briefcase"></i> Mes Services
                </button>
                <button @click="activeTab = 'reviews'" :class="activeTab === 'reviews' ? 'active' : ''"
                    class="advisor-nav-btn">
                    <i class="fas fa-comments"></i> Avis Clients ({{ $agent->avisValides->count() }})
                </button>
                @if ($agent->parcours)
                    <button @click="activeTab = 'bio'" :class="activeTab === 'bio' ? 'active' : ''"
                        class="advisor-nav-btn">
                        <i class="fas fa-user"></i> Mon Parcours
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- CONTENU PRINCIPAL -->
    <div class="max-w-6xl mx-auto px-4 py-12 grid md:grid-cols-3 gap-10">

        <!-- COLONNE GAUCHE (Contenu) -->
        <div class="md:col-span-2 space-y-8">

            <!-- TAB: SERVICES -->
            <div x-show="activeTab === 'services'" x-transition>
                <div class="space-y-6">
                    @forelse($agent->servicesActifs as $service)
                        <div
                            class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col md:flex-row gap-6 hover:shadow-xl transition duration-300">
                            <!-- Image du service -->
                            <div class="w-full md:w-1/3 bg-gray-900 rounded-lg overflow-hidden flex items-center justify-center"
                                style="min-height: 200px;">
                                @if ($service->image)
                                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->titre }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="text-white text-center p-6">
                                        <i class="fas fa-briefcase text-4xl mb-3 text-cyan-400"></i>
                                        <span class="font-bold uppercase tracking-wider text-sm">SERVICE</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Contenu du service -->
                            <div class="w-full md:w-2/3 flex flex-col justify-center">
                                <h3 class="font-bold text-xl text-gray-900 mb-2">{{ $service->titre }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $service->description }}</p>

                                @if ($service->points_forts && count($service->points_forts) > 0)
                                    <ul class="text-xs text-gray-500 space-y-1">
                                        @foreach ($service->points_forts as $point)
                                            <li><i class="fas fa-check text-green-500 mr-2"></i>{{ $point }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 rounded-xl shadow-lg text-center">
                            <i class="fas fa-briefcase text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500">Aucun service configuré pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB: AVIS -->
            <div x-show="activeTab === 'reviews'" x-transition>
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

                    <!-- MESSAGE DE SUCCÈS (EN HAUT) -->
                    @if (session('success_avis'))
                        <div
                            class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 text-sm flex items-center gap-2 rounded">
                            <i class="fas fa-check-circle text-lg"></i>
                            <div>
                                <strong>Merci !</strong> {{ session('success_avis') }}
                            </div>
                        </div>
                    @endif

                    <div
                        class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-gray-100 pb-6">
                        <div>
                            <h2 class="font-heading font-bold text-2xl text-gray-900">Ce qu'ils disent de moi</h2>
                            @if ($agent->avisValides->count() > 0)
                                <div
                                    class="mt-2 bg-green-50 text-green-700 px-4 py-1 rounded-full font-bold text-xs inline-flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> 100% Avis Vérifiés
                                </div>
                            @endif
                        </div>
                        <button @click="showReviewForm = !showReviewForm"
                            class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md flex items-center gap-2 transform active:scale-95">
                            <i class="fas fa-pen"></i> <span
                                x-text="showReviewForm ? 'Annuler' : 'Écrire un avis'"></span>
                        </button>
                    </div>

                    <!-- FORMULAIRE AJOUT AVIS -->
                    <div x-show="showReviewForm" x-transition
                        class="mb-10 bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-star text-yellow-400"></i> Partagez votre expérience
                        </h3>

                        <form action="{{ route('minisite.avis', $agent->slug) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Votre
                                        Nom</label>
                                    <input type="text" name="nom_client" required
                                        class="w-full p-3 bg-white rounded-lg border border-gray-200 focus:border-blue-700 outline-none text-sm transition shadow-sm"
                                        placeholder="Ex: Pierre D.">
                                    @error('nom_client')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:w-1/3">
                                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Note
                                        Globale</label>
                                    <select name="note" required
                                        class="w-full p-3 bg-white rounded-lg border border-gray-200 focus:border-blue-700 outline-none text-sm font-bold text-yellow-500 shadow-sm cursor-pointer">
                                        <option value="5">⭐⭐⭐⭐⭐ 5/5</option>
                                        <option value="4">⭐⭐⭐⭐ 4/5</option>
                                        <option value="3">⭐⭐⭐ 3/5</option>
                                        <option value="2">⭐⭐ 2/5</option>
                                        <option value="1">⭐ 1/5</option>
                                    </select>
                                    @error('note')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Votre
                                    message</label>
                                <textarea name="commentaire" rows="3" required
                                    class="w-full p-3 bg-white rounded-lg border border-gray-200 focus:border-blue-700 outline-none text-sm transition shadow-sm"
                                    placeholder="Racontez votre expérience..."></textarea>
                                @error('commentaire')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex gap-3 justify-end pt-2">
                                <button type="button" @click="showReviewForm = false"
                                    class="text-gray-500 hover:text-gray-800 text-sm font-bold px-4 py-2 transition">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-2.5 rounded-lg text-sm shadow-md transition transform active:scale-95">
                                    Publier mon avis
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Liste des avis -->
                    @if ($agent->avisValides->count() > 0)
                        <div class="grid gap-8">
                            @foreach ($agent->avisValides as $avis)
                                <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-4 mb-3">
                                        <div
                                            class="w-12 h-12 rounded-full bg-blue-700 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                                            {{ strtoupper(substr($avis->nom_client, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-base">{{ $avis->nom_client }}
                                            </div>
                                            <div class="flex text-yellow-400 text-xs mt-0.5">
                                                @for ($i = 0; $i < $avis->note; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="ml-auto text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded">
                                            {{ $avis->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="relative pl-6">
                                        <i class="fas fa-quote-left absolute top-0 left-0 text-gray-300 text-xs"></i>
                                        <p class="text-gray-600 text-sm italic leading-relaxed">
                                            "{{ $avis->commentaire }}"</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-comments text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500">Aucun avis pour le moment. Soyez le premier à laisser un avis !
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- TAB: PARCOURS -->
            @if ($agent->parcours)
                <div x-show="activeTab === 'bio'" x-transition>
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <h2 class="font-heading font-bold text-2xl text-gray-900 mb-6">Mon Parcours</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-line">
                                {{ $agent->parcours }}</p>

                            @if ($agent->bio)
                                <div
                                    class="my-6 p-4 border-l-4 border-blue-700 bg-blue-50 text-blue-700 italic text-sm">
                                    {{ $agent->bio }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- COLONNE DROITE (Formulaire Contact Sticky) -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 sticky top-24 overflow-hidden">
                <div class="bg-blue-700 p-6 text-center">
                    <h3 class="font-heading font-bold text-white text-lg">Demander un Audit</h3>
                    <p class="text-blue-100 text-xs mt-1">Gratuit & Sans engagement</p>
                </div>

                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('minisite.contact', $agent->slug) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wide">Votre
                                objectif</label>
                            <select name="objectif"
                                class="w-full p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm focus:border-blue-700 outline-none transition cursor-pointer text-gray-700 font-medium">
                                <option>Cashflow Positif</option>
                                <option>Patrimoine / Retraite</option>
                                <option>Défiscalisation</option>
                                <option>Transaction</option>
                                <option>Gestion locative</option>
                            </select>
                        </div>

                        <input type="text" name="nom" placeholder="Nom complet" required
                            class="w-full p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm focus:border-blue-700 outline-none transition">

                        <input type="tel" name="telephone" placeholder="Téléphone"
                            class="w-full p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm focus:border-blue-700 outline-none transition">

                        <input type="email" name="email" placeholder="Email" required
                            class="w-full p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm focus:border-blue-700 outline-none transition">

                        <textarea name="message" rows="4" placeholder="Votre message..." required
                            class="w-full p-3 bg-gray-50 rounded-lg border border-gray-200 text-sm focus:border-blue-700 outline-none transition"></textarea>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-white font-bold py-4 rounded-lg shadow-xl transform active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                            <span>Valider ma demande</span>
                            <i class="fas fa-paper-plane animate-pulse"></i>
                        </button>

                        <p class="text-[10px] text-gray-400 text-center mt-2 leading-tight">
                            En validant, vous acceptez d'être recontacté par {{ $agent->prenom }} {{ $agent->nom }}
                            pour étudier votre projet.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 pt-12 pb-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <!-- LOGO + NOM GEST'IMMO -->
            <div class="flex items-center justify-center gap-3 mb-8">
                <img src="{{ asset('images/logo3d.png') }}" alt="GEST'IMMO" class="h-16 w-auto">
                <div class="flex flex-col leading-none text-left">
                    <span class="font-heading font-extrabold text-xl text-blue-700 tracking-tight">
                        GEST'<span class="text-red-800">IMMO</span>
                    </span>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">L'investissement en plus
                        simple</span>
                </div>
            </div>

            <!-- INFO LÉGALE CONSEILLER -->
            @if ($agent->info_legale)
                <div class="mb-6 pb-6 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-900">{{ $agent->nom_complet }} - Conseiller Indépendant en
                        Immobilier.</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $agent->info_legale }}</p>
                </div>
            @endif

            <!-- MENTION LÉGALE RÉSEAU -->
            <div class="max-w-4xl mx-auto mb-8">
                <p class="text-[10px] text-gray-400 leading-relaxed">
                    Tous les conseillers GEST'IMMO sont des agents commerciaux indépendants de la SARL GEST'IMMO France
                    immatriculés au RSAC, titulaires de la carte de démarchage immobilier pour le compte de la société
                    GEST'IMMO France SARL.
                </p>
            </div>

            <!-- LIENS BAS DE PAGE -->
            <div class="flex flex-wrap justify-center gap-6 text-xs text-gray-500 mb-4 font-medium">
                <a href="https://gestimmo-presta.fr/mentions-legales" class="hover:text-blue-700 transition">Mentions
                    Légales</a>
                <a href="https://gestimmo-presta.fr/confidentialite" class="hover:text-blue-700 transition">Politique
                    de Confidentialité</a>
                <a href="https://gestimmo-presta.fr/cookies" class="hover:text-blue-700 transition">Cookies</a>
                <a href="#" class="hover:text-blue-700 transition">Médiation</a>
            </div>

            <p class="text-gray-400 text-[10px]">© {{ date('Y') }} GEST'IMMO. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        function miniSite() {
            return {
                activeTab: 'services',
                showReviewForm: false,
                scrollToContact() {
                    document.querySelector('.sticky').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        }
    </script>
</body>

</html>
