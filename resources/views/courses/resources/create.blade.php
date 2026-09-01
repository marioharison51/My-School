<x-sidebar-layout title="Nouvelle ressource — {{ $course->title }}">
<div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('courses.resources.store', $course) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Titre</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Type</label>
                        <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md" required
                                onchange="document.getElementById('file-field').style.display = this.value === 'pdf' ? 'block' : 'none';
                                          document.getElementById('url-field').style.display = this.value !== 'pdf' ? 'block' : 'none';">
                            <option value="">-- Choisir --</option>
                            <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Vidéo (lien)</option>
                            <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Quiz (lien)</option>
                        </select>
                        @error('type') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div id="file-field" style="display: none;">
                        <label class="block font-medium text-sm text-gray-700">Fichier PDF</label>
                        <input type="file" name="file" accept="application/pdf"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('file') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div id="url-field" style="display: none;">
                        <label class="block font-medium text-sm text-gray-700">Lien (URL)</label>
                        <input type="url" name="url" value="{{ old('url') }}" placeholder="https://..."
                               class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('url') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('courses.resources.index', $course) }}" class="px-4 py-2 text-gray-600">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded">
                            Ajouter
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-sidebar-layout>
