@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2">
        <h3 class="font-semibold text-gray-700 mb-2">Identité de l'élève</h3>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Nom</label>
        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('last_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Prénom</label>
        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('first_name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
        <input type="date" name="birth_date"
               value="{{ old('birth_date', optional($student->birth_date)->format('Y-m-d')) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('birth_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
        <input type="text" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('birth_place') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <h3 class="font-semibold text-gray-700 mb-2 mt-4">Parents / tuteurs</h3>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Nom du père</label>
        <input type="text" name="father_name" value="{{ old('father_name', $student->father_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Profession du père</label>
        <input type="text" name="father_job" value="{{ old('father_job', $student->father_job) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Nom de la mère</label>
        <input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Profession de la mère</label>
        <input type="text" name="mother_job" value="{{ old('mother_job', $student->mother_job) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Téléphone parent <span class="text-red-600">*</span></label>
        <input type="text" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('parent_phone') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email parent (facultatif)</label>
        <input type="email" name="parent_email" value="{{ old('parent_email', $student->parent_email) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        @error('parent_email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Adresse exacte</label>
        <input type="text" name="address" value="{{ old('address', $student->address) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('address') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <h3 class="font-semibold text-gray-700 mb-2 mt-4">Scolarité</h3>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">École antérieure</label>
        <input type="text" name="previous_school" value="{{ old('previous_school', $student->previous_school) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Classe antérieure</label>
        <input type="text" name="previous_class" value="{{ old('previous_class', $student->previous_class) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Classe actuelle <span class="text-red-600">*</span></label>
        <input type="text" name="current_class" value="{{ old('current_class', $student->current_class) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        @error('current_class') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Carrière envisagée</label>
        <input type="text" name="desired_career" value="{{ old('desired_career', $student->desired_career) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    </div>

</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
        Enregistrer
    </button>
    <a href="{{ route('students.index') }}" class="text-gray-600">Annuler</a>
</div>
