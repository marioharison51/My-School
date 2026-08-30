@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <x-input-label for="title" value="Nom du cours" />
        <x-text-input id="title" type="text" name="title" class="mt-1 block w-full"
               :value="old('title', $course->title)" required />
        <x-input-error :messages="$errors->get('title')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="subject" value="Matière" />
        <x-text-input id="subject" type="text" name="subject" class="mt-1 block w-full"
               :value="old('subject', $course->subject)" required />
        <x-input-error :messages="$errors->get('subject')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="class_name" value="Classe attribuée" />
        <x-text-input id="class_name" type="text" name="class_name" class="mt-1 block w-full"
               placeholder="ex: 6e A"
               :value="old('class_name', $course->class_name)" required />
        <x-input-error :messages="$errors->get('class_name')" class="mt-1" />
    </div>

    @if (auth()->user()->role === 'administrateur')
        <div>
            <x-input-label for="teacher_id" value="Enseignant assigné" />
            <select id="teacher_id" name="teacher_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                <option value="">-- Non assigné --</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(old('teacher_id', $course->teacher_id) == $teacher->id)>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('teacher_id')" class="mt-1" />
        </div>
    @endif

    <div class="md:col-span-2">
        <x-input-label for="description" value="Description (facultatif)" />
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('description', $course->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-1" />
    </div>

</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Enregistrer</x-primary-button>
    <a href="{{ route('courses.index') }}" class="text-gray-600">Annuler</a>
</div>
