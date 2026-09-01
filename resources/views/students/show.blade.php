<x-sidebar-layout title="Fiche élève">

    <div class="max-w-4xl space-y-6">

        @if (session('status'))
            <div class="p-3 bg-green-50 text-green-800 rounded-md text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg border border-gray-100 p-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-primary-600 text-white flex items-center justify-center text-xl font-semibold shrink-0">
                        {{ strtoupper(mb_substr($student->first_name, 0, 1) . mb_substr($student->last_name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $student->full_name }}</h2>
                        <div class="flex flex-wrap gap-2 mt-1.5">
                            <x-status-badge color="primary">{{ $student->current_class }}</x-status-badge>

                            @if ($student->hasGraduated())
                                <x-status-badge color="green">Diplômé</x-status-badge>
                            @elseif ($student->consecutive_missed_payments > 0)
                                <x-status-badge color="red">{{ $student->consecutive_missed_payments }} impayé(s)</x-status-badge>
                            @else
                                <x-status-badge color="green">Écolage à jour</x-status-badge>
                            @endif

                            @if ($student->user)
                                @if ($student->user->account_status === 'blocked')
                                    <x-status-badge color="red">Compte bloqué</x-status-badge>
                                @elseif ($student->user->account_status === 'suspended')
                                    <x-status-badge color="amber">Compte suspendu</x-status-badge>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('students.index') }}" class="text-sm text-gray-500 shrink-0">← Retour à la liste</a>
            </div>

            <div class="flex flex-wrap gap-2 mt-5 pt-5 border-t border-gray-100">
                <a href="{{ route('payments.create', $student) }}"
                   class="px-3 py-1.5 bg-primary-700 hover:bg-primary-600 text-white rounded-md text-xs font-medium">
                    + Ajouter un paiement
                </a>
                <a href="{{ route('students.edit', $student) }}"
                   class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs font-medium">
                    Modifier les infos
                </a>
                <a href="{{ route('student-fees.edit', $student) }}"
                   class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs font-medium">
                    Écolage
                </a>
                <a href="{{ route('bulletins.show', $student) }}"
                   class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs font-medium">
                    Bulletin
                </a>

                @if (! $student->hasGraduated())
                    <form method="POST" action="{{ route('students.markGraduated', $student) }}"
                          onsubmit="return confirm('Marquer {{ $student->full_name }} comme diplômé(e) ?');">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs font-medium">
                            Marquer diplômé
                        </button>
                    </form>
                @endif

                @if ($student->user && $student->user->account_status === 'blocked')
                    <form method="POST" action="{{ route('accounts.unblock', $student->user) }}"
                          onsubmit="return confirm('Débloquer ce compte ? Le mot de passe sera réinitialisé.');">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-white border border-green-300 hover:bg-green-50 text-green-700 rounded-md text-xs font-medium">
                            Débloquer le compte
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('students.expel', $student) }}"
                      onsubmit="return confirm('Renvoyer {{ $student->full_name }} ? Les comptes élève et parent seront désactivés (conservés en historique).');"
                      class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 bg-white border border-red-300 hover:bg-red-50 text-red-700 rounded-md text-xs font-medium">
                        Renvoyer
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Identité</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Date de naissance</dt>
                    <dd class="text-gray-900">{{ $student->birth_date->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Lieu de naissance</dt>
                    <dd class="text-gray-900">{{ $student->birth_place ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Père</dt>
                    <dd class="text-gray-900">{{ $student->father_name ?? '—' }} @if($student->father_job) ({{ $student->father_job }}) @endif</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Mère</dt>
                    <dd class="text-gray-900">{{ $student->mother_name ?? '—' }} @if($student->mother_job) ({{ $student->mother_job }}) @endif</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Téléphone parent</dt>
                    <dd class="text-gray-900">{{ $student->parent_phone }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Email parent</dt>
                    <dd class="text-gray-900">{{ $student->parent_email ?? '—' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-gray-500">Adresse</dt>
                    <dd class="text-gray-900">{{ $student->address ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">École antérieure</dt>
                    <dd class="text-gray-900">{{ $student->previous_school ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Carrière envisagée</dt>
                    <dd class="text-gray-900">{{ $student->desired_career ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-gray-900">Écolage</h3>
                <a href="{{ route('student-fees.edit', $student) }}" class="text-xs text-primary-700 font-medium">
                    Modifier le montant
                </a>
            </div>
            <div class="text-2xl font-bold text-gray-900">
                {{ $student->fee ? number_format($student->fee->monthly_amount, 0, ',', ' ') . ' Ar' : '—' }}
                <span class="text-sm font-normal text-gray-500">/ mois</span>
            </div>
            @unless ($student->fee)
                <p class="text-sm text-amber-700 mt-2">
                    Aucun montant d'écolage défini pour cet élève — les factures ne pourront pas être générées.
                </p>
            @endunless
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Factures récentes</h3>
                <a href="{{ route('invoices.student', $student) }}" class="text-xs text-primary-700 font-medium">
                    Voir toutes les factures
                </a>
            </div>
            @forelse ($recentInvoices as $invoice)
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-50 text-sm">
                    <span class="text-gray-700">{{ $invoice->period_month->format('m/Y') }} — échéance {{ $invoice->due_date->format('d/m/Y') }}</span>
                    <div class="flex items-center gap-3">
                        <span class="text-gray-900 font-medium">{{ number_format($invoice->amount, 0, ',', ' ') }} Ar</span>
                        <x-status-badge :color="$invoice->statusColor()">{{ $invoice->statusLabel() }}</x-status-badge>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-500 text-sm">Aucune facture générée pour l'instant.</p>
                </div>
            @endforelse
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Paiements récents</h3>
                <a href="{{ route('payments.index', $student) }}" class="text-xs text-primary-700 font-medium">
                    Voir tous les paiements
                </a>
            </div>
            @forelse ($recentPayments as $payment)
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-50 text-sm">
                    <span class="text-gray-700">{{ $payment->paid_at->format('d/m/Y') }} — {{ $payment->method }}</span>
                    <span class="text-gray-900 font-medium">{{ number_format($payment->amount, 0, ',', ' ') }} Ar</span>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-500 text-sm">Aucun paiement enregistré pour l'instant.</p>
                    <a href="{{ route('payments.create', $student) }}" class="text-primary-700 text-sm font-medium mt-1 inline-block">
                        Enregistrer le premier paiement
                    </a>
                </div>
            @endforelse
        </div>

    </div>

</x-sidebar-layout>
