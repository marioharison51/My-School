<x-sidebar-layout title="Factures — {{ $student->first_name }} {{ $student->last_name }}">

    <div class="max-w-3xl space-y-4">

        <div class="flex items-center gap-4 text-sm">
            @if (in_array(auth()->user()->role, ['administrateur', 'enseignant']))
                <a href="{{ route('students.show', $student) }}" class="text-gray-600">
                    &larr; Retour à la fiche élève
                </a>
            @else
                <a href="{{ route('invoices.index') }}" class="text-gray-600">
                    &larr; Retour aux factures
                </a>
            @endif
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-2">Période</th>
                        <th class="px-4 py-2">Échéance</th>
                        <th class="px-4 py-2">Montant</th>
                        <th class="px-4 py-2">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $invoice->period_month->format('m/Y') }}</td>
                            <td class="px-4 py-2">{{ $invoice->due_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ number_format($invoice->amount, 0, ',', ' ') }} Ar</td>
                            <td class="px-4 py-2">
                                <x-status-badge :color="$invoice->statusColor()">{{ $invoice->statusLabel() }}</x-status-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center">
                                <div class="w-10 h-10 rounded-full bg-gray-100 mx-auto mb-2"></div>
                                <p class="text-gray-500 text-sm">Aucune facture pour cet élève.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-sidebar-layout>
