<x-sidebar-layout title="Tableau de bord">

    <div class="space-y-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">Élèves inscrits</div>
                    <x-status-badge color="primary">Actifs</x-status-badge>
                </div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStudents }}</div>
            </div>
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">Enseignants</div>
                    <x-status-badge color="primary">Équipe</x-status-badge>
                </div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTeachers }}</div>
            </div>
            <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">Total encaissé</div>
                    <x-status-badge color="green">Finances</x-status-badge>
                </div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalPayments, 2) }} Ar</div>
            </div>
            <a href="{{ route('invoices.index', ['status' => 'late']) }}"
               class="bg-white shadow-sm rounded-lg p-5 border border-gray-100 hover:border-red-200 transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">Élèves en retard</div>
                    <x-status-badge color="red">Alerte</x-status-badge>
                </div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ $studentsLate }}</div>
            </a>
            <a href="{{ route('invoices.index', ['status' => 'pending']) }}"
               class="bg-white shadow-sm rounded-lg p-5 border border-gray-100 hover:border-amber-200 transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">Factures en attente</div>
                    <x-status-badge color="amber">À suivre</x-status-badge>
                </div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ $invoicesPending }}</div>
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Derniers paiements</h3>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-gray-400 uppercase">
                        <th class="py-2 px-5">Élève</th>
                        <th class="py-2 px-5">Montant</th>
                        <th class="py-2 px-5">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPayments as $payment)
                        <tr class="border-t border-gray-50">
                            <td class="py-3 px-5">{{ $payment->student->full_name }}</td>
                            <td class="py-3 px-5">{{ number_format($payment->amount, 2) }} Ar</td>
                            <td class="py-3 px-5 text-gray-500">{{ $payment->paid_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-4 px-5 text-gray-500">Aucun paiement récent.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-5 border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-1">Communication</h3>
            <p class="text-gray-500 text-sm">Planification des événements et annonces — à venir.</p>
        </div>

    </div>

</x-sidebar-layout>
