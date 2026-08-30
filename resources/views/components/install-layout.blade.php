@props(['step' => 1])
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Installation — {{ config('app.name', 'Mety School') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800 min-h-screen">

        <div class="min-h-screen flex flex-col items-center pt-10 pb-10 px-4">

            <div class="flex items-center gap-2 mb-8">
                <x-application-logo class="h-9 w-9 text-primary-600" />
                <span class="font-bold text-xl text-gray-900">{{ config('app.name', 'Mety School') }}</span>
            </div>

            <div class="w-full max-w-lg mb-8">
                <div class="flex items-center justify-between text-xs font-medium">
                    @foreach (['Bienvenue', 'Base de données', 'Administrateur', 'Terminé'] as $i => $label)
                        <div class="flex-1 flex flex-col items-center {{ $i > 0 ? 'ml-2' : '' }}">
                            <div class="w-full h-1.5 rounded-full {{ ($i + 1) <= $step ? 'bg-primary-600' : 'bg-gray-200' }}"></div>
                            <span class="mt-1 {{ ($i + 1) == $step ? 'text-primary-700' : 'text-gray-400' }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="w-full max-w-lg bg-white shadow-sm rounded-lg p-8">
                {{ $slot }}
            </div>

        </div>

    </body>
</html>
