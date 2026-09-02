<x-sidebar-layout title="Périodes d'examens">

    <div class="space-y-6">

        @if (session('status'))
            <div class="p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Nouvelle période d'examens</h3>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('exam-periods.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf

                <div class="md:col-span-2">
                    <x-input-label for="label" value="Libellé (facultatif)" />
                    <x-text-input id="label" name="label" type="text" class="mt-1 block w-full"
                           placeholder="ex: Examens du 1er trimestre" :value="old('label')" />
                </div>

                <div>
                    <x-input-label for="start_date" value="Date de début" />
                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                           :value="old('start_date')" required />
                </div>

                <div>
                    <x-input-label for="end_date" value="Date de fin" />
                    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                           :value="old('end_date')" required />
                </div>

                <div class="md:col-span-4">
                    <x-primary-button>Créer la période</x-primary-button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Périodes existantes</h3>
                <p class="text-xs text-gray-500 mt-1">Une seule période active à la fois — l'activer masque temporairement les cours pour les élèves et parents.</p>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-gray-400 uppercase">
                        <th class="py-2 px-5">Libellé</th>
                        <th class="py-2 px-5">Début</th>
                        <th class="py-2 px-5">Fin</th>
                        <th class="py-2 px-5">Statut</th>
                        <th class="py-2 px-5">Activée par</th>
                        <th class="py-2 px-5"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($examPeriods as $period)
                        <tr class="border-t border-gray-50">
                            <td class="py-3 px-5">{{ $period->label ?? '—' }}</td>
                            <td class="py-3 px-5">{{ $period->start_date->format('d/m/Y') }}</td>
                            <td class="py-3 px-5">{{ $period->end_date->format('d/m/Y') }}</td>
                            <td class="py-3 px-5">
                                @if ($period->is_active)
                                    <x-status-badge color="green">Active</x-status-badge>
                                @else
                                    <x-status-badge color="gray">Inactive</x-status-badge>
                                @endif
                            </td>
                            <td class="py-3 px-5 text-gray-500">{{ $period->activatedBy->name ?? '—' }}</td>
                            <td class="py-3 px-5">
                                <form method="POST" action="{{ route('exam-periods.toggle', $period) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-primary-700 text-sm font-medium">
                                        {{ $period->is_active ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-4 px-5 text-gray-500">Aucune période d'examens créée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-sidebar-layout>
