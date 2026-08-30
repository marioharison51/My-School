<x-sidebar-layout title="Gestion des utilisateurs">

    <div class="space-y-4">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-end">
            <a href="{{ route('admin.users.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                + Créer un utilisateur
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Rôle</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b">
                            <td class="py-2">{{ $user->name }}</td>
                            <td class="py-2">{{ $user->email }}</td>
                            <td class="py-2">{{ \App\Enums\Role::from($user->role)->label() }}</td>
                            <td class="py-2">
                                <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="border-gray-300 rounded-md text-sm">
                                        @foreach (\App\Enums\Role::cases() as $role)
                                            <option value="{{ $role->value }}" @selected($user->role === $role->value)>{{ $role->label() }}</option>
                                        @endforeach
                                    </select>
                                    <x-primary-button>Modifier</x-primary-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</x-sidebar-layout>
