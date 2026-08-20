<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord — Administration
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <div class="text-sm text-gray-500">Élèves inscrits</div>
                    <div class="text-3xl font-bold text-primary-700">{{ $totalStudents }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <div class="text-sm text-gray-500">Enseignants</div>
                    <div class="text-3xl font-bold text-primary-700">{{ $totalTeachers }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <div class="text-sm text-gray-500">Total encaissé</div>
                    <div class="text-3xl font-bold text-primary-700">{{ number_format($totalPayments, 2) }} Ar</div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-primary-800">Bloc Paiement — Derniers paiements</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Élève</th>
                            <th class="py-2">Montant</th>
                            <th class="py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentPayments as $payment)
                            <tr class="border-b">
                                <td class="py-2">{{ $payment->student->full_name }}</td>
                                <td class="py-2">{{ number_format($payment->amount, 2) }} Ar</td>
                                <td class="py-2">{{ $payment->paid_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-4 text-gray-500">Aucun paiement récent.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2 text-primary-800">Bloc Communication</h3>
                <p class="text-gray-500">Planification des événements et annonces — à venir.</p>
            </div>

        </div>
    </div>
</x-app-layout>
