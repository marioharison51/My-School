<x-sidebar-layout title="Examens">
<div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-end mb-4">
                    <a href="{{ route('exams.create') }}"
                       class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded-md text-sm">
                        + Planifier un examen
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 pr-4">Examen</th>
                            <th class="py-2 pr-4">Cours</th>
                            <th class="py-2 pr-4">Classe</th>
                            <th class="py-2 pr-4">Trimestre</th>
                            <th class="py-2 pr-4">Date</th>
                            <th class="py-2 pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($exams as $exam)
                            <tr>
                                <td class="py-2 pr-4">{{ $exam->title }}</td>
                                <td class="py-2 pr-4">{{ $exam->course->subject }}</td>
                                <td class="py-2 pr-4">{{ $exam->course->class_name }}</td>
                                <td class="py-2 pr-4">{{ $exam->term }}</td>
                                <td class="py-2 pr-4">{{ $exam->exam_date->format('d/m/Y') }}</td>
                                <td class="py-2 pr-4 flex gap-3">
                                    <a href="{{ route('grades.edit', $exam) }}" class="text-green-700">Saisir les notes</a>
                                    <a href="{{ route('exams.edit', $exam) }}" class="text-primary-700">Modifier</a>
                                    <form method="POST" action="{{ route('exams.destroy', $exam) }}"
                                          onsubmit="return confirm('Supprimer cet examen ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-gray-500">Aucun examen planifié.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $exams->links() }}
                </div>

            </div>
        </div>
    </div>
</x-sidebar-layout>
