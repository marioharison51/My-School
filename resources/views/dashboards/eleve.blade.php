<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord — Élève
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (! $student)
                <div class="bg-yellow-100 text-yellow-800 rounded-lg p-6">
                    Ton compte n'est pas encore lié à une fiche élève. Contacte l'administration.
                </div>
            @else
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg mb-2 text-primary-800">Mes informations</h3>
                    <p><span class="text-gray-500">Nom :</span> {{ $student->full_name }}</p>
                    <p><span class="text-gray-500">Classe :</span> {{ $student->current_class }}</p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2 text-primary-800">Bloc Résultats</h3>
                    <p class="text-gray-500">Notes, moyenne et rang — à venir.</p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4 text-primary-800">Derniers paiements</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Date</th>
                                <th class="py-2">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr class="border-b">
                                    <td class="py-2">{{ $payment->paid_at->format('d/m/Y') }}</td>
                                    <td class="py-2">{{ number_format($payment->amount, 2) }} Ar</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="py-4 text-gray-500">Aucun paiement enregistré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
