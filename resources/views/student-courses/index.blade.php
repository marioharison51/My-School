<x-sidebar-layout title="Mes cours">

    <div class="space-y-4">

        <div class="text-sm text-gray-500">
            Classe : <span class="font-medium text-gray-900">{{ $student->current_class }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($courses as $course)
                <a href="{{ route('student.courses.show', $course) }}"
                   class="bg-white shadow-sm rounded-lg p-5 border border-gray-100 hover:border-primary-300 transition">
                    <h3 class="font-semibold text-gray-900">{{ $course->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $course->subject }}</p>
                    <p class="text-xs text-gray-400 mt-3">
                        {{ $course->teacher->name ?? 'Enseignant non assigné' }}
                    </p>
                </a>
            @empty
                <div class="col-span-full bg-white shadow-sm rounded-lg p-6 border border-gray-100 text-gray-500 text-sm">
                    Aucun cours disponible pour votre classe pour l'instant.
                </div>
            @endforelse
        </div>

    </div>

</x-sidebar-layout>
