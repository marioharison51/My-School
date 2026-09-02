<x-sidebar-layout title="Retards d'assiduité">

    <div class="space-y-6">

        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Enregistrer un retard</h3>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('tardiness.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf

                <div class="md:col-span-2">
                    <x-input-label for="student_id" value="Élève" />
                    <select id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                        <option value="">-- Choisir un élève --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->last_name }} {{ $student->first_name }} ({{ $student->current_class }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="occurred_at" value="Date" />
                    <x-text-input id="occurred_at" name="occurred_at" type="date" class="mt-1 block w-full"
                           :value="old('occurred_at', now()->format('Y-m-d'))" required />
                </div>

                <div>
                    <x-primary-button class="w-full justify-center">Enregistrer</x-primary-button>
                </div>

                <div class="md:col-span-4">
                    <x-input-label for="note" value="Note (facultatif)" />
                    <x-text-input id="note" name="note" type="text" class="mt-1 block w-full" placeholder="ex: 20 min de retard" />
                </div>
            </form>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Historique des retards</h3>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-gray-400 uppercase">
                        <th class="py-2 px-5">Élève</th>
                        <th class="py-2 px-5">Date</th>
                        <th class="py-2 px-5">Note</th>
                        <th class="py-2 px-5">Enregistré par</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr class="border-t border-gray-50">
                            <td class="py-3 px-5">{{ $record->student->full_name ?? '—' }}</td>
                            <td class="py-3 px-5">{{ $record->occurred_at->format('d/m/Y') }}</td>
                            <td class="py-3 px-5 text-gray-500">{{ $record->note ?? '—' }}</td>
                            <td class="py-3 px-5 text-gray-500">{{ $record->recordedBy->name ?? 'Compte supprimé' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-4 px-5 text-gray-500">Aucun retard enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $records->links() }}
            </div>
        </div>

    </div>

</x-sidebar-layout>
