<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouveau paiement — {{ $student->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('payments.store', $student) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Montant (Ar)</label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('amount') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Payé par</label>
                        <select name="payer_role" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Choisir --</option>
                            <option value="eleve" {{ old('payer_role') == 'eleve' ? 'selected' : '' }}>Élève</option>
                            <option value="parent" {{ old('payer_role') == 'parent' ? 'selected' : '' }}>Parent</option>
                        </select>
                        @error('payer_role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Méthode</label>
                        <select name="method" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Choisir --</option>
                            <option value="mvola" {{ old('method') == 'mvola' ? 'selected' : '' }}>Mvola</option>
                            <option value="orange_money" {{ old('method') == 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                            <option value="airtel_money" {{ old('method') == 'airtel_money' ? 'selected' : '' }}>Airtel Money</option>
                            <option value="virement" {{ old('method') == 'virement' ? 'selected' : '' }}>Virement bancaire</option>
                            <option value="especes" {{ old('method') == 'especes' ? 'selected' : '' }}>Espèces</option>
                        </select>
                        @error('method') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Référence (optionnel)</label>
                        <input type="text" name="reference" value="{{ old('reference') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Date du paiement</label>
                        <input type="date" name="paid_at" value="{{ old('paid_at', date('Y-m-d')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('paid_at') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Notes (optionnel)</label>
                        <textarea name="notes" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded">
                            Enregistrer le paiement
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
