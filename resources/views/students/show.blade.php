<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fiche de {{ $student->first_name }} {{ $student->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-2 text-sm">
                <p><strong>Nom :</strong> {{ $student->last_name }}</p>
                <p><strong>Prénom :</strong> {{ $student->first_name }}</p>
                <p><strong>Date de naissance :</strong> {{ $student->birth_date->format('d/m/Y') }}</p>
                <p><strong>Lieu de naissance :</strong> {{ $student->birth_place }}</p>
                <p><strong>Père :</strong> {{ $student->father_name }} ({{ $student->father_job }})</p>
                <p><strong>Mère :</strong> {{ $student->mother_name }} ({{ $student->mother_job }})</p>
                <p><strong>Téléphone parent :</strong> {{ $student->parent_phone }}</p>
                <p><strong>Email parent :</strong> {{ $student->parent_email ?? '—' }}</p>
                <p><strong>Adresse :</strong> {{ $student->address }}</p>
                <p><strong>École antérieure :</strong> {{ $student->previous_school ?? '—' }}</p>
                <p><strong>Classe antérieure :</strong> {{ $student->previous_class ?? '—' }}</p>
                <p><strong>Classe actuelle :</strong> {{ $student->current_class }}</p>
                <p><strong>Carrière envisagée :</strong> {{ $student->desired_career ?? '—' }}</p>

                <div class="pt-4">
                    <a href="{{ route('students.edit', $student) }}" class="text-indigo-600">Modifier</a>
                    · <a href="{{ route('students.index') }}" class="text-gray-600">Retour à la liste</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-3 text-sm">
                <h3 class="font-semibold text-base">Écolage</h3>
                <p>
                    <strong>Montant mensuel :</strong>
                    {{ $student->fee ? number_format($student->fee->monthly_amount, 0, ',', ' ') . ' Ar' : 'Non défini' }}
                </p>
                <p>
                    <strong>Impayés consécutifs :</strong>
                    {{ $student->consecutive_missed_payments }}
                </p>
                <a href="{{ route('student-fees.edit', $student) }}" class="text-indigo-600">
                    Définir / modifier le montant d'écolage
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-3 text-sm">
                <h3 class="font-semibold text-base">Factures récentes</h3>
                @forelse ($recentInvoices as $invoice)
                    <div class="flex justify-between border-b py-2">
                        <span>{{ $invoice->period_month->format('m/Y') }} — échéance {{ $invoice->due_date->format('d/m/Y') }}</span>
                        <span>{{ number_format($invoice->amount, 0, ',', ' ') }} Ar — {{ $invoice->status }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">Aucune facture pour l'instant.</p>
                @endforelse
                <a href="{{ route('invoices.student', $student) }}" class="text-indigo-600">
                    Voir toutes les factures
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-3 text-sm">
                <h3 class="font-semibold text-base">Paiements récents</h3>
                @forelse ($recentPayments as $payment)
                    <div class="flex justify-between border-b py-2">
                        <span>{{ $payment->paid_at->format('d/m/Y') }} — {{ $payment->method }}</span>
                        <span>{{ number_format($payment->amount, 0, ',', ' ') }} Ar</span>
                    </div>
                @empty
                    <p class="text-gray-500">Aucun paiement enregistré.</p>
                @endforelse
                <a href="{{ route('payments.index', $student) }}" class="text-indigo-600">
                    Voir tous les paiements
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
