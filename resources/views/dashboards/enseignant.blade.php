<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord — Enseignant
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <div class="text-sm text-gray-500">Cours</div>
                    <div class="text-3xl font-bold text-primary-700">{{ $myCourses }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 border-t-4 border-primary-600">
                    <div class="text-sm text-gray-500">Élèves suivis</div>
                    <div class="text-3xl font-bold text-primary-700">{{ $totalStudents }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-primary-800">Bloc Résultats — Examens à venir</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Titre</th>
                            <th class="py-2">Trimestre</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Note max</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($upcomingExams as $exam)
                            <tr class="border-b">
                                <td class="py-2">{{ $exam->title }}</td>
                                <td class="py-2">{{ $exam->term }}</td>
                                <td class="py-2">{{ $exam->exam_date->format('d/m/Y') }}</td>
                                <td class="py-2">{{ $exam->max_score }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 text-gray-500">Aucun examen planifié.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2 text-primary-800">Bloc Paiement</h3>
                <p class="text-gray-500">Notification des frais à charge et du salaire — à venir.</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2 text-primary-800">Bloc Communication</h3>
                <p class="text-gray-500">Messagerie interne — à venir.</p>
            </div>

        </div>
    </div>
</x-app-layout>
