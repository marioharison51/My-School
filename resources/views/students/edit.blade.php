<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier un élève
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    @include('students._form')

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>