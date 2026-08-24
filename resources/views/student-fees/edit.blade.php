<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Écolage — {{ $student->first_name }} {{ $student->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4 text-sm">

                <p>
                    <strong>Montant actuel :</strong>
                    {{ $fee ? number_format($fee->monthly_amount, 0, ',', ' ') . ' Ar / mois' : 'Non défini' }}
                </p>

                <form method="POST" action="{{ route('student-fees.update', $student) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="monthly_amount" class="block font-medium text-gray-700">
                            Nouveau montant mensuel (Ar)
                        </label>
                        <input type="number" step="0.01" min="0" name="monthly_amount" id="monthly_amount"
                               value="{{ old('monthly_amount', $fee?->monthly_amount) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('monthly_amount')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                            Enregistrer
                        </button>
                        <a href="{{ route('students.show', $student) }}" class="text-gray-600">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
