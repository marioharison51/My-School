<x-sidebar-layout title="Factures / échéances">

    <div class="space-y-4">

        <form method="GET" class="flex items-center gap-2 text-sm">
            <label for="status">Statut :</label>
            <select name="status" id="status" onchange="this.form.submit()" class="border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="pending" @selected(request('status') === 'pending')>En attente</option>
                <option value="paid" @selected(request('status') === 'paid')>Payée</option>
                <option value="late" @selected(request('status') === 'late')>En retard</option>
            </select>
        </form>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-2">Élève</th>
                        <th class="px-4 py-2">Classe</th>
                        <th class="px-4 py-2">Période</th>
                        <th class="px-4 py-2">Échéance</th>
                        <th class="px-4 py-2">Montant</th>
                        <th class="px-4 py-2">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                <a href="{{ route('invoices.student', $invoice->student) }}" class="text-primary-700">
                                    {{ $invoice->student->first_name }} {{ $invoice->student->last_name }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $invoice->student->current_class }}</td>
                            <td class="px-4 py-2">{{ $invoice->period_month->format('m/Y') }}</td>
                            <td class="px-4 py-2">{{ $invoice->due_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ number_format($invoice->amount, 0, ',', ' ') }} Ar</td>
                            <td class="px-4 py-2">
                                <x-status-badge :color="$invoice->statusColor()">{{ $invoice->statusLabel() }}</x-status-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center">
                                <div class="w-10 h-10 rounded-full bg-gray-100 mx-auto mb-2"></div>
                                <p class="text-gray-500 text-sm">
                                    @if (request('status'))
                                        Aucune facture avec ce statut.
                                    @else
                                        Aucune facture générée pour l'instant.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $invoices->links() }}
        </div>

    </div>

</x-sidebar-layout>
