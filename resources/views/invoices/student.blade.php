<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Factures — {{ $student->first_name }} {{ $student->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <a href="{{ route('students.show', $student) }}" class="text-gray-600 text-sm">
                &larr; Retour à la fiche élève
            </a>

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
                                <td class="px-4 py-2">{{ $invoice->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    Aucune facture pour cet élève.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
