<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page introuvable — {{ config('app.name', 'Mety School') }}</title>
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
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gray-100 mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.17 15.17a4 4 0 015.66 0M9 10h.01M15 10h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />
                </svg>
            </div>

            <h1 class="text-lg font-semibold text-gray-900 mb-2">Page introuvable</h1>

            <p class="text-sm text-gray-500 mb-6">
                @php $msg = $exception->getMessage() ?? null; @endphp
                {{ $msg && $msg !== 'Not Found' ? $msg : "La page que vous cherchez n'existe pas ou plus." }}
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
