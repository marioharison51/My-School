@php $s = $student ?? null; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $s->nom ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    @error('nom') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Prénom</label>
    <input type="text" name="prenom" value="{{ old('prenom', $s->prenom ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    @error('prenom') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" name="email" value="{{ old('email', $s->email ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Classe</label>
    <input type="text" name="classe" value="{{ old('classe', $s->classe ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    @error('classe') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
    <input type="date" name="date_naissance" value="{{ old('date_naissance', $s->date_naissance?->format('Y-m-d') ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
    @error('date_naissance') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Nom du tuteur</label>
    <input type="text" name="tuteur_nom" value="{{ old('tuteur_nom', $s->tuteur_nom ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Contact du tuteur</label>
    <input type="text" name="tuteur_contact" value="{{ old('tuteur_contact', $s->tuteur_contact ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
</div>