<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseResource;
use Illuminate\Http\Request;

class CourseResourceController extends Controller
{
    public function index(Course $course)
    {
        $resources = $course->resources()->latest()->get();

        return view('courses.resources.index', compact('course', 'resources'));
    }

    public function create(Course $course)
    {
        return view('courses.resources.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:pdf,video,quiz'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'url' => ['nullable', 'url'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('course-resources', 'public');
        }

        $course->resources()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'file_path' => $filePath,
            'url' => $validated['url'] ?? null,
        ]);

        return redirect()
            ->route('courses.resources.index', $course)
            ->with('success', 'Ressource ajoutée.');
    }

    public function destroy(Course $course, CourseResource $resource)
    {
        if ($resource->file_path) {
            \Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return redirect()
            ->route('courses.resources.index', $course)
            ->with('success', 'Ressource supprimée.');
    }
}
