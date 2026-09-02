<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès refusé — {{ config('app.name', 'Mety School') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md text-center">
        <div class="flex items-center justify-center gap-2 mb-8">
            <x-application-logo class="h-8 w-8 text-primary-600" />
            <span class="font-bold text-lg text-gray-900">{{ config('app.name', 'Mety School') }}</span>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-8 border border-gray-100">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-red-50 mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <h1 class="text-lg font-semibold text-gray-900 mb-2">Accès refusé</h1>

            <p class="text-sm text-gray-500 mb-6">
                @php $msg = $exception->getMessage() ?? null; @endphp
                {{ $msg ?: "Vous n'avez pas la permission d'accéder à cette page." }}
            </p>

            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-primary-700 hover:bg-primary-600 text-white font-medium rounded-md text-sm">
                    Retour au tableau de bord
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2.5 bg-primary-700 hover:bg-primary-600 text-white font-medium rounded-md text-sm">
                    Se connecter
                </a>
            @endauth
        </div>
    </div>

</body>
</html>
