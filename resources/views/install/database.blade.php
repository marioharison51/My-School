<x-install-layout :step="2">
    <h1 class="text-xl font-bold text-gray-900 mb-2">Base de données</h1>

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm break-words">
            {{ session('error') }}
        </div>
    @endif

    @if ($hasExistingData)
        <p class="text-gray-500 text-sm mb-6">
            Une installation existante avec des données a été détectée. Que souhaitez-vous faire ?
        </p>

        <form method="POST" action="{{ route('install.database.save') }}" class="space-y-3">
            @csrf

            <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary-400">
                <input type="radio" name="choice" value="keep" class="mt-1 text-primary-600 focus:ring-primary-500" checked>
                <span>
                    <span class="block font-medium text-gray-900">Conserver les données existantes</span>
                    <span class="block text-sm text-gray-500">Les élèves, notes, paiements déjà enregistrés restent intacts.</span>
                </span>
            </label>

            <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary-400">
                <input type="radio" name="choice" value="fresh" class="mt-1 text-primary-600 focus:ring-primary-500">
                <span>
                    <span class="block font-medium text-gray-900">Repartir de zéro</span>
                    <span class="block text-sm text-red-600">⚠️ Efface définitivement toutes les données actuelles.</span>
                </span>
            </label>

            <div class="pt-4">
                <x-primary-button class="w-full justify-center">Continuer</x-primary-button>
            </div>
        </form>
    @else
        <p class="text-gray-500 text-sm mb-6">
            Aucune donnée existante détectée. Nous allons préparer une base de données vierge.
        </p>

        <form method="POST" action="{{ route('install.database.save') }}">
            @csrf
            <input type="hidden" name="choice" value="fresh">
            <x-primary-button class="w-full justify-center">Continuer</x-primary-button>
        </form>
    @endif
</x-install-layout>
