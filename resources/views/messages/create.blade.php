<x-sidebar-layout title="Nouveau message">
<div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('messages.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Destinataire</label>
                        <select name="recipient_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Choisir --</option>
                            @foreach ($recipients as $recipient)
                                <option value="{{ $recipient->id }}" {{ old('recipient_id') == $recipient->id ? 'selected' : '' }}>
                                    {{ $recipient->name }} ({{ $recipient->role }})
                                </option>
                            @endforeach
                        </select>
                        @error('recipient_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Sujet</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('subject') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Message</label>
                        <textarea name="body" rows="6" class="mt-1 block w-full border-gray-300 rounded-md" required>{{ old('body') }}</textarea>
                        @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('messages.index') }}" class="px-4 py-2 text-gray-600">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded">
                            Envoyer
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-sidebar-layout>
