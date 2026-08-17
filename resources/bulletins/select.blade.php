<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Générer un bulletin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="" onsubmit="event.preventDefault(); window.location = '/bulletins/' + document.getElementById('student_id').value + '?term=' + document.getElementById('term').value;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Élève</label>
                            <select id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Choisir un élève --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->last_name }} {{ $student->first_name }} ({{ $student->current_class }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Trimestre</label>
                            <select id="term" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Choisir un trimestre --</option>
                                @foreach ($terms as $term)
                                    <option value="{{ $term }}">{{ $term }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                            Voir le bulletin
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
