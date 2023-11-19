<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function index()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Lessons/Index', [
            'lessons' => Lesson::orderBy('chapter')->with(['subject', 'grade'])->get()
        ]);
    }

    public function show(Lesson $lesson)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Lessons/Show', [
            'lesson' => Lesson::with(['subject', 'grade', 'questions'])->find($lesson->id),
            'questionTypes' => QuestionType::all()
        ]);
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $lessonData = $request->validate([
            'code' => ['required', 'numeric', 'min:1', 'max:50'],
            'title' => ['required', 'string', 'max:255'],
            'chapter' => ['required', 'numeric'],
            'term' => ['required', 'string'],
            'grade_id' => ['required', 'numeric'],
            'subject_id' => ['required', 'numeric']
        ]);
        Lesson::create($lessonData);
        return to_route('grades.subject', ['grade' => $request->grade_id, 'subject' => $request->subject_id]);
    }

    public function edit(Lesson $lesson)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Lessons/Edit', [
            'lesson' => Lesson::with(['subject', 'grade'])->find($lesson->id),
            'subjects' => Subject::get(['title']),
            'grades' => Grade::get(['title'])
        ]);
    }

    public function update(Lesson $lesson, Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $updatedLesson = $request->validate([
            'code' => ['required', 'numeric', 'min:1', 'max:50'],
            'title' => ['required', 'string', 'max:255'],
            'chapter' => ['required', 'numeric'],
            'term' => ['required', 'string'],
            'grade' => ['required', 'string'],
            'subject' => ['required', 'string']
        ]);

        $lesson->update([
            'code' => $updatedLesson['code'],
            'title' => $updatedLesson['title'],
            'chapter' => $updatedLesson['chapter'],
            'term' => $updatedLesson['term'],
            'grade_id' => Grade::where('title', '=', $updatedLesson['grade'])->first()->id,
            'subject_id' => Subject::where('title', '=', $updatedLesson['subject'])->first()->id,
        ]);

        return to_route('lessons.show', ['lesson' => $lesson])->with('message', 'updated successfully');

    }

    public function destroy(Lesson $lesson)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $lesson->delete();
        return redirect()->route('lessons.index')->with('message', 'Deleted successfully');
    }
}
