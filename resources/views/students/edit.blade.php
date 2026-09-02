<x-sidebar-layout title="Modifier la fiche de {{ $student->first_name }} {{ $student->last_name }}">
<div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('students.update', $student) }}">
                    @method('PUT')
                    @include('students._form')
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
