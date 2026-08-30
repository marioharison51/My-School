<x-install-layout :step="4">
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary-100 mb-4">
            <svg class="w-7 h-7 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-xl font-bold text-gray-900 mb-2">Installation terminée 🎉</h1>
        <p class="text-gray-500 text-sm mb-6">
            {{ config('app.name') }} est prêt à être utilisé. Connectez-vous avec le compte
            administrateur que vous venez de créer.
        </p>

        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-primary-700 text-white font-semibold rounded-md hover:bg-primary-600 transition">
            Aller à la page de connexion
        </a>
    </div>
</x-install-layout>
