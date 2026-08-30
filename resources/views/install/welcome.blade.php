<x-install-layout :step="1">
    <h1 class="text-xl font-bold text-gray-900 mb-2">Bienvenue 👋</h1>
    <p class="text-gray-500 text-sm mb-6">
        Configurons votre espace {{ config('app.name', 'Mety School') }} en quelques étapes.
    </p>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('install.welcome.save') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="app_name" value="Nom de votre établissement" />
            <x-text-input id="app_name" name="app_name" type="text" class="mt-1 block w-full"
                   placeholder="ex: Collège Sainte-Marie"
                   :value="old('app_name', $appName)" required autofocus />
            <p class="mt-1 text-xs text-gray-400">Ce nom apparaîtra partout dans l'application (titre, en-têtes, etc.).</p>
        </div>

        <div>
            <x-input-label for="app_url" value="Adresse du site" />
            <x-text-input id="app_url" name="app_url" type="url" class="mt-1 block w-full"
                   :value="old('app_url', $detectedUrl)" required />
            <p class="mt-1 text-xs text-gray-400">
                Détectée automatiquement à partir de l'adresse utilisée pour accéder à cette page.
                Modifiez-la seulement si elle est incorrecte.
            </p>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">Continuer</x-primary-button>
        </div>
    </form>
</x-install-layout>
