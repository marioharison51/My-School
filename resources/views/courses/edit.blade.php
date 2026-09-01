<x-sidebar-layout title="Modifier le cours — {{ $course->title }}">
<div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('courses.update', $course) }}">
                    @method('PUT')
                    @include('courses._form')
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
