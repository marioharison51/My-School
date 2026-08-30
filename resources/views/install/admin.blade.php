<x-install-layout :step="3">
    <h1 class="text-xl font-bold text-gray-900 mb-2">Compte administrateur</h1>
    <p class="text-gray-500 text-sm mb-6">
        Créez le tout premier compte administrateur de l'établissement.
    </p>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('install.admin.save') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nom complet" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                   :value="old('name')" required autofocus />
        </div>

        <div>
            <x-input-label for="email" value="Adresse email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                   :value="old('email')" required />
        </div>

        <div>
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">Créer le compte</x-primary-button>
        </div>
    </form>
</x-install-layout>
