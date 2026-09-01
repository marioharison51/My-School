<x-sidebar-layout title="Ressources — {{ $course->title }}">
<div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <a href="{{ route('courses.resources.create', $course) }}" class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded">
                    + Ajouter une ressource
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 px-4">Titre</th>
                            <th class="py-2 px-4">Type</th>
                            <th class="py-2 px-4">Lien</th>
                            <th class="py-2 px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($resources as $resource)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $resource->title }}</td>
                                <td class="py-2 px-4">{{ ucfirst($resource->type) }}</td>
                                <td class="py-2 px-4">
                                    @if ($resource->file_path)
                                        <a href="{{ Storage::url($resource->file_path) }}" target="_blank" class="text-primary-700">Ouvrir le PDF</a>
                                    @elseif ($resource->url)
                                        <a href="{{ $resource->url }}" target="_blank" class="text-primary-700">Ouvrir le lien</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="py-2 px-4">
                                    <form method="POST" action="{{ route('courses.resources.destroy', [$course, $resource]) }}"
                                          onsubmit="return confirm('Supprimer cette ressource ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 text-sm">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 px-4 text-gray-500">Aucune ressource pour ce cours.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-sidebar-layout>
