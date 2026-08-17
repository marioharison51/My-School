@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-medium text-gray-700">Nom du cours</label>
        <input type="text" name="title" value="{{ old('title', $course->title) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Matière</label>
        <input type="text" name="subject" value="{{ old('subject', $course->subject) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('subject') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Classe attribuée</label>
        <input type="text" name="class_name" value="{{ old('class_name', $course->class_name) }}"
               placeholder="ex: 6e A"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('class_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Description (facultatif)</label>
        <textarea name="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $course->description) }}</textarea>
        @error('description') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
        Enregistrer
    </button>
    <a href="{{ route('courses.index') }}" class="text-gray-600">Annuler</a>
</div>
