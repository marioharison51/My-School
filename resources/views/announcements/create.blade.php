<x-sidebar-layout title="Nouvelle annonce">
<div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('announcements.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Titre</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Contenu</label>
                        <textarea name="body" rows="6" class="mt-1 block w-full border-gray-300 rounded-md" required>{{ old('body') }}</textarea>
                        @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Date de l'événement (optionnel)</label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                        <p class="text-xs text-gray-500 mt-1">Laisse vide pour une simple annonce sans date précise.</p>
                        @error('event_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('announcements.index') }}" class="px-4 py-2 text-gray-600">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded">
                            Publier
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-sidebar-layout>
