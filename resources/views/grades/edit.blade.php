<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Saisie des notes — {{ $exam->title }} ({{ $exam->course->subject }}, {{ $exam->course->class_name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p class="text-sm text-gray-500 mb-4">Note maximale : {{ $exam->max_score }}</p>

                <form method="POST" action="{{ route('grades.update', $exam) }}">
                    @csrf
                    @method('PUT')

                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="py-2 pr-4">Élève</th>
                                <th class="py-2 pr-4">Note / {{ $exam->max_score }}</th>
                                <th class="py-2 pr-4">Commentaire</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($students as $student)
                                @php $existing = $existingGrades->get($student->id); @endphp
                                <tr>
                                    <td class="py-2 pr-4">{{ $student->last_name }} {{ $student->first_name }}</td>
                                    <td class="py-2 pr-4">
                                        <input type="number" step="0.01" min="0" max="{{ $exam->max_score }}"
                                               name="scores[{{ $student->id }}]"
                                               value="{{ old('scores.' . $student->id, $existing->score ?? '') }}"
                                               class="w-24 rounded-md border-gray-300 shadow-sm">
                                    </td>
                                    <td class="py-2 pr-4">
                                        <input type="text"
                                               name="comments[{{ $student->id }}]"
                                               value="{{ old('comments.' . $student->id, $existing->comment ?? '') }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                            Enregistrer les notes
                        </button>
                        <a href="{{ route('exams.index') }}" class="text-gray-600">Retour</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
