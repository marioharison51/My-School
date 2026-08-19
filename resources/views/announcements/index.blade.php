<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Annonces & Événements
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (auth()->user()->role === 'administrateur')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('announcements.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded">
                        + Nouvelle annonce
                    </a>
                </div>
            @endif

            <div class="space-y-4">
                @forelse ($announcements as $announcement)
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $announcement->title }}</h3>
                                @if ($announcement->event_date)
                                    <p class="text-sm text-gray-500">Événement le {{ $announcement->event_date->format('d/m/Y') }}</p>
                                @endif
                            </div>
                            @if (auth()->user()->role === 'administrateur')
                                <form method="POST" action="{{ route('announcements.destroy', $announcement) }}"
                                      onsubmit="return confirm('Supprimer cette annonce ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm">Supprimer</button>
                                </form>
                            @endif
                        </div>
                        <p class="mt-2 text-gray-700">{{ $announcement->body }}</p>
                        <p class="mt-2 text-xs text-gray-400">
                            Publié par {{ $announcement->creator->name }} le {{ $announcement->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                @empty
                    <div class="bg-white shadow-sm rounded-lg p-6 text-gray-500">
                        Aucune annonce pour le moment.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
