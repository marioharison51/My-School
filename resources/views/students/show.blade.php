<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fiche de {{ $student->first_name }} {{ $student->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
        </div>
    </div>
</x-app-layout>
