<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des utilisateurs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nom</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Rôle actuel</th>
                            <th class="py-2">Modifier le rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2">{{ $user->role }}</td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="border-gray-300 rounded-md text-sm">
                                            <option value="administrateur" {{ $user->role == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                                            <option value="enseignant" {{ $user->role == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                                            <option value="eleve" {{ $user->role == 'eleve' ? 'selected' : '' }}>Élève</option>
                                            <option value="parent" {{ $user->role == 'parent' ? 'selected' : '' }}>Parent</option>
                                            <option value="comptable" {{ $user->role == 'comptable' ? 'selected' : '' }}>Comptable</option>
                                        </select>
                                        <button type="submit" class="px-3 py-1 bg-gray-900 text-white rounded text-sm">
                                            Mettre à jour
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
