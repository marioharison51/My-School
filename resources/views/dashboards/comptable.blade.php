<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord — Comptable
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <div class="text-sm text-gray-500">Total encaissé</div>
                    <div class="text-3xl font-bold text-primary-700">{{ number_format($totalPayments, 2) }} Ar</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <div class="text-sm text-gray-500">Nombre de transactions</div>
                    <div class="text-3xl font-bold text-primary-700">{{ $paymentsCount }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-primary-800">Bloc Paiement — Répartition par méthode</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Méthode</th>
                            <th class="py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($byMethod as $row)
                            <tr class="border-b">
                                <td class="py-2">{{ $row->method }}</td>
                                <td class="py-2">{{ number_format($row->total, 2) }} Ar</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-4 text-gray-500">Aucune transaction.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-primary-800">Transactions récentes</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Élève</th>
                            <th class="py-2">Montant</th>
                            <th class="py-2">Méthode</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Enregistré par</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentPayments as $payment)
                            <tr class="border-b">
                                <td class="py-2">{{ $payment->student->full_name }}</td>
                                <td class="py-2">{{ number_format($payment->amount, 2) }} Ar</td>
                                <td class="py-2">{{ $payment->method }}</td>
                                <td class="py-2">{{ $payment->paid_at->format('d/m/Y') }}</td>
                                <td class="py-2">{{ $payment->recordedBy->name ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-gray-500">Aucune transaction récente.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
