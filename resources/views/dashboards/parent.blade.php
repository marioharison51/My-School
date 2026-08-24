<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord — Parent
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @forelse ($children as $child)
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <h3 class="font-semibold text-lg mb-2 text-primary-800">{{ $child->full_name }} — {{ $child->current_class }}</h3>

                    <div class="mt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Bloc Résultats</h4>
                        <p class="text-gray-500">Notes et progression — à venir.</p>
                    </div>

                    <div class="mt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Bloc Paiement — Derniers paiements</h4>
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Date</th>
                                    <th class="py-2">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($child->payments as $payment)
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

                    <div class="mt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Bloc Communication</h4>
                        <p class="text-gray-500">Messages de la direction/enseignants — à venir.</p>
                    </div>
                </div>
            @empty
                <div class="bg-yellow-100 text-yellow-800 rounded-lg p-6">
                    Aucun enfant n'est encore lié à ton compte. Contacte l'administration.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
