<x-sidebar-layout title="Modifier l'examen — {{ $exam->title }}">
<div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('exams.update', $exam) }}">
                    @method('PUT')
                    @include('exams._form')
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
