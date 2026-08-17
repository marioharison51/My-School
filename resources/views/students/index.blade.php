                    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liste des élèves
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <form method="GET" class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Filtrer par classe :</label>
                        <select name="class" onchange="this.form.submit()" class="rounded-md border-gray-300 text-sm">
                            <option value="">Toutes les classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class }}" @selected(request('class') === $class)>
                                    {{ $class }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <a href="{{ route('students.create') }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                        + Inscrire un élève
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 pr-4">Nom</th>
                            <th class="py-2 pr-4">Prénom</th>
                            <th class="py-2 pr-4">Classe</th>
                            <th class="py-2 pr-4">Téléphone parent</th>
                            <th class="py-2 pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($students as $student)
                            <tr>
                                <td class="py-2 pr-4">{{ $student->last_name }}</td>
                                <td class="py-2 pr-4">{{ $student->first_name }}</td>
                                <td class="py-2 pr-4">{{ $student->current_class }}</td>
                                <td class="py-2 pr-4">{{ $student->parent_phone }}</td>
                                <td class="py-2 pr-4 flex gap-3">
                                    <a href="{{ route('students.edit', $student) }}" class="text-indigo-600">Modifier</a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}"
                                          onsubmit="return confirm('Supprimer cet élève ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-gray-500">Aucun élève trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $students->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               </x-app-layout>
