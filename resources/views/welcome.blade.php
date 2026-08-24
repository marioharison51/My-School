<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ config('app.name') }} — la gestion de votre école, simplifiée : élèves, notes, paiements, communication.">

        <title>{{ config('app.name', 'Mety School') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-gray-800">

        {{-- Top nav --}}
        <header class="border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <x-application-logo class="h-8 w-8 text-primary-600" />
                    <span class="font-bold text-lg text-gray-900">{{ config('app.name', 'Mety School') }}</span>
                </a>

                <nav class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 bg-primary-700 text-white text-sm font-semibold rounded-md hover:bg-primary-600 transition">
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-primary-700 text-white text-sm font-semibold rounded-md hover:bg-primary-600 transition">
                                    Essayer gratuitement
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        {{-- Hero --}}
        <section class="bg-gradient-to-b from-primary-50 to-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-700 mb-6">
                    <x-application-logo class="h-9 w-9 text-white" />
                </div>

                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">
                    Toute votre école,<br class="hidden sm:block"> dans un seul outil
                </h1>

                <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
                    Élèves, notes, paiements, messages avec les parents : {{ config('app.name', 'Mety School') }}
                    remplace vos cahiers, vos tableurs et vos allers-retours par un seul espace, accessible partout.
                </p>

                <div class="mt-8 flex items-center justify-center gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-primary-700 text-white font-semibold rounded-md hover:bg-primary-600 transition shadow-sm">
                            Essayer gratuitement
                        </a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-md border border-gray-300 hover:bg-gray-50 transition">
                            Se connecter
                        </a>
                    @endif
                </div>
            </div>
        </section>

        {{-- Modules --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Un espace pour chacun</h2>
                <p class="mt-3 text-gray-500">Direction, comptabilité, enseignants, élèves, parents — tout le monde y trouve ce qu'il lui faut.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg text-primary-800 mb-2">Élèves</h3>
                    <p class="text-gray-500 text-sm">Fiches, classes, inscriptions : tout est au même endroit, à jour et accessible en deux clics.</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg text-primary-800 mb-2">Notes et examens</h3>
                    <p class="text-gray-500 text-sm">Les enseignants saisissent les notes, les bulletins se génèrent tout seuls.</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg text-primary-800 mb-2">Paiements</h3>
                    <p class="text-gray-500 text-sm">Frais de scolarité, encaissements, reçus — le comptable garde tout sous contrôle.</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg text-primary-800 mb-2">Communication</h3>
                    <p class="text-gray-500 text-sm">Messages et annonces envoyés en interne, sans passer par des groupes WhatsApp éparpillés.</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg text-primary-800 mb-2">Parents</h3>
                    <p class="text-gray-500 text-sm">Ils suivent les résultats et les paiements de leurs enfants, sans avoir à appeler l'école.</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg text-primary-800 mb-2">Chaque rôle, son espace</h3>
                    <p class="text-gray-500 text-sm">Administration, enseignants, élèves, parents : chacun ne voit que ce qui le concerne.</p>
                </div>
            </div>
        </section>

        {{-- CTA final --}}
        @if (Route::has('register'))
            <section class="bg-primary-700">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                    <h2 class="text-2xl sm:text-3xl font-bold text-white">Envie de simplifier la gestion de votre école ?</h2>
                    <p class="mt-3 text-primary-100">{{ config('app.name', 'Mety School') }} s'installe avec le nom de votre établissement, prêt à l'emploi.</p>
                    <a href="{{ route('register') }}" class="mt-8 inline-flex items-center px-6 py-3 bg-white text-primary-700 font-semibold rounded-md hover:bg-primary-50 transition">
                        Essayer gratuitement
                    </a>
                </div>
            </section>
        @endif

        {{-- Footer --}}
        <footer class="border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Mety School') }}. Tous droits réservés.
            </div>
        </footer>

    </body>
</html>
