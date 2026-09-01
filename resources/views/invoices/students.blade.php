<x-sidebar-layout title="Élèves — statut de paiement">

    <div class="space-y-4">

        <form method="GET" class="flex items-center gap-2 text-sm">
            <label for="status">Statut :</label>
            <select name="status" id="status" onchange="this.form.submit()" class="border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="late" @selected(request('status') === 'late')>En retard</option>
                <option value="pending" @selected(request('status') === 'pending')>Échéance en attente</option>
            </select>
        </form>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-2">Élève</th>
                        <th class="px-4 py-2">Classe</th>
                        <th class="px-4 py-2">Impayés consécutifs</th>
                        <th class="px-4 py-2">Factures en retard</th>
                        <th class="px-4 py-2">Factures en attente</th>
                        <th class="px-4 py-2">Statut</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="px-4 py-2">{{ $student->current_class }}</td>
                            <td class="px-4 py-2">{{ $student->consecutive_missed_payments }}</td>
                            <td class="px-4 py-2">{{ $student->late_invoices_count }}</td>
                            <td class="px-4 py-2">{{ $student->pending_invoices_count }}</td>
                            <td class="px-4 py-2">
                                @if ($student->late_invoices_count > 0 || $student->consecutive_missed_payments > 0)
                                    <x-status-badge color="red">En retard</x-status-badge>
                                @elseif ($student->pending_invoices_count > 0)
                                    <x-status-badge color="amber">En attente</x-status-badge>
                                @else
                                    <x-status-badge color="green">À jour</x-status-badge>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('invoices.student', $student) }}" class="text-primary-700">Factures</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center">
                                <div class="w-10 h-10 rounded-full bg-gray-100 mx-auto mb-2"></div>
                                <p class="text-gray-500 text-sm">
                                    @if (request('status'))
                                        Aucun élève dans cette situation — tout est en ordre de ce côté.
                                    @else
                                        Aucun élève trouvé.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $students->links() }}
        </div>

    </div>

</x-sidebar-layout>
