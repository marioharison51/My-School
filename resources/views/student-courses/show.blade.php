<x-sidebar-layout title="{{ $course->title }}">

    <div class="max-w-3xl space-y-6">

        <a href="{{ route('student.courses.index') }}" class="text-sm text-gray-500">← Retour à mes cours</a>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900">{{ $course->title }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $course->subject }} — {{ $course->teacher->name ?? 'Enseignant non assigné' }}</p>
            @if ($course->description)
                <p class="text-gray-700 text-sm mt-4">{{ $course->description }}</p>
            @endif
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Ressources</h3>
            </div>
            @forelse ($course->resources as $resource)
                <div class="flex items-center justify-between px-6 py-3 border-t border-gray-50 text-sm">
                    <div>
                        <span class="font-medium text-gray-900">{{ $resource->title }}</span>
                        <x-status-badge color="primary">{{ ucfirst($resource->type) }}</x-status-badge>
                    </div>
                    @if ($resource->file_path)
                        <a href="{{ Storage::url($resource->file_path) }}" target="_blank" class="text-primary-700">Ouvrir</a>
                    @elseif ($resource->url)
                        <a href="{{ $resource->url }}" target="_blank" class="text-primary-700">Ouvrir</a>
                    @endif
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500 text-sm">
                    Aucune ressource disponible pour ce cours pour l'instant.
                </div>
            @endforelse
        </div>

    </div>

</x-sidebar-layout>
