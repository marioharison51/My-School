<x-sidebar-layout title="Mes enfants">

    <div class="space-y-6">

        @forelse ($children as $child)
            <div class="bg-white shadow-sm rounded-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $child->full_name }}</h3>
                        <x-status-badge color="primary">{{ $child->current_class }}</x-status-badge>
                    </div>
                    <a href="{{ route('invoices.student', $child) }}" class="text-sm text-primary-700 font-medium">
                        Voir les factures
                    </a>
                </div>

                <h4 class="text-sm font-medium text-gray-700 mb-2">Derniers paiements</h4>
                <table class="w-full text-left text-sm">
                    <tbody>
                        @forelse ($child->payments as $payment)
                            <tr class="border-t border-gray-50">
                                <td class="py-2 text-gray-700">{{ $payment->paid_at->format('d/m/Y') }}</td>
                                <td class="py-2 text-gray-900 font-medium text-right">{{ number_format($payment->amount, 0, ',', ' ') }} Ar</td>
                            </tr>
                        @empty
                            <tr><td class="py-2 text-gray-500">Aucun paiement enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @empty
            <div class="bg-white shadow-sm rounded-lg border border-gray-100 p-6 text-gray-500">
                Aucun enfant lié à votre compte pour l'instant.
            </div>
        @endforelse

    </div>

</x-sidebar-layout>
