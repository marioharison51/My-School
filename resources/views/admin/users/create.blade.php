<x-sidebar-layout title="Créer un utilisateur">

    <div class="max-w-lg">
        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
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
                    <x-input-label for="role" value="Rôle" />
                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                        <option value="">-- Choisir un rôle --</option>
                        @foreach (\App\Enums\Role::cases() as $role)
                            <option value="{{ $role->value }}" @selected(old('role') === $role->value)>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="password" value="Mot de passe" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <x-primary-button>Créer le compte</x-primary-button>
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 text-sm">Annuler</a>
                </div>
            </form>

        </div>
    </div>

</x-sidebar-layout>
