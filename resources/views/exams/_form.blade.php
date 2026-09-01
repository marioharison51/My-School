@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Cours concerné</label>
        <select name="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            <option value="">-- Choisir un cours --</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" @selected(old('course_id', $exam->course_id) == $course->id)>
                    {{ $course->title }} — {{ $course->subject }} ({{ $course->class_name }})
                </option>
            @endforeach
        </select>
        @error('course_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Nom de l'examen</label>
        <input type="text" name="title" value="{{ old('title', $exam->title) }}"
               placeholder="ex: Devoir 1, Examen trimestriel"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Trimestre / période</label>
        <input type="text" name="term" value="{{ old('term', $exam->term) }}"
               placeholder="ex: Trimestre 1"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('term') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Date de l'examen</label>
        <input type="date" name="exam_date"
               value="{{ old('exam_date', optional($exam->exam_date)->format('Y-m-d')) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('exam_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Note maximale</label>
        <input type="number" name="max_score" value="{{ old('max_score', $exam->max_score ?? 20) }}"
               min="1" max="100"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('max_score') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded-md">
        Enregistrer
    </button>
    <a href="{{ route('exams.index') }}" class="text-gray-600">Annuler</a>
</div>
