<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bulletin — {{ $student->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Élève</div>
                        <div class="font-medium">{{ $student->full_name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Classe</div>
                        <div class="font-medium">{{ $student->current_class }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Trimestre</div>
                        <div class="font-medium">{{ $term ?? 'Tous trimestres confondus' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Rang</div>
                        <div class="font-medium">
                            @if ($rank)
                                {{ $rank }} / {{ $totalRanked }}
                            @else
                                Non classé (aucune note)
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Notes par matière</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Matière</th>
                            <th class="py-2">Moyenne / 20</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bySubject as $subject => $data)
                            <tr class="border-b">
                                <td class="py-2">{{ $subject }}</td>
                                <td class="py-2">{{ $data['average'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-4 text-gray-500">Aucune note pour ce trimestre.</td></tr>
                        @endforelse
                    </tbody>
                    @if ($generalAverage !== null)
                        <tfoot>
                            <tr class="border-t-2 font-semibold">
                                <td class="py-2">Moyenne générale</td>
                                <td class="py-2">{{ $generalAverage }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <div>
                <a href="{{ route('bulletins.select') }}" class="text-gray-600">← Retour à la sélection</a>
            </div>

        </div>
    </div>
</x-app-layout>
