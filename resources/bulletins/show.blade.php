<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bulletin — {{ $student->first_name }} {{ $student->last_name }}
            @if ($term) ({{ $term }}) @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p class="text-sm text-gray-500 mb-4">Classe : {{ $student->current_class }}</p>

                @if ($bySubject->isEmpty())
                    <p class="text-gray-500">Aucune note enregistrée pour cette période.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="py-2 pr-4">Matière</th>
                                <th class="py-2 pr-4">Notes</th>
                                <th class="py-2 pr-4">Moyenne / 20</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($bySubject as $subject => $data)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">{{ $subject }}</td>
                                    <td class="py-2 pr-4">
                                        @foreach ($data['grades'] as $grade)
                                            {{ $grade->score }}/{{ $grade->exam->max_score }}
                                            ({{ $grade->exam->title }})@if (!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td class="py-2 pr-4">{{ $data['average'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 text-lg font-semibold">
                        Moyenne générale : {{ $generalAverage }} / 20
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('bulletins.select') }}" class="text-gray-600">← Nouveau bulletin</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
