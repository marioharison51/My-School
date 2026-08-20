<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Paiements — {{ $student->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="text-lg font-semibold">
                        Total payé : {{ number_format($total, 2) }} Ar
                    </div>
                    <a href="{{ route('payments.create', $student) }}"
                       class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded">
                        + Nouveau paiement
                    </a>
                </div>

                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Date</th>
                            <th class="py-2">Montant</th>
                            <th class="py-2">Méthode</th>
                            <th class="py-2">Référence</th>
                            <th class="py-2">Enregistré par</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr class="border-b">
                                <td class="py-2">{{ $payment->paid_at->format('d/m/Y') }}</td>
                                <td class="py-2">{{ number_format($payment->amount, 2) }} Ar</td>
                                <td class="py-2">{{ $payment->method }}</td>
                                <td class="py-2">{{ $payment->reference ?? '—' }}</td>
                                <td class="py-2">{{ $payment->recordedBy->name }}</td>
                                <td class="py-2">
                                    <a href="{{ route('payments.receipt', [$student, $payment]) }}" target="_blank" class="text-primary-700">
                                        Reçu PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-gray-500">Aucun paiement enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
