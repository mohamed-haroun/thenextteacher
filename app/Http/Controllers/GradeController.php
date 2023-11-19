<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class GradeController extends Controller
{
    public function index()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Grades/Index', [
            'grades' => Grade::with('subjects')->get()
        ]);
    }

    public function show(Grade $grade)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Grades/Show', [
            'grade' => Grade::with(['students', 'subjects', 'tests'])->find($grade->id)
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
        $grade_data = $request->validate([
            'title' => ['required','string','max:255', Rule::unique('grades', 'title')],
            'school' => 'required|string'
        ]);

        Grade::create($grade_data);

        return redirect()->route('grades.index');
    }

    public function edit(Grade $grade)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Grades/Edit', [
            'grade' => Grade::find($grade->id)
        ]);
    }

    public function update(Grade $grade, Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $request->validate([
            'title' => ['required','string','max:255'],
            'school' => 'required|String',
        ]);

        $grade->update([
            'title' => $request->title,
            'school' => $request->school
        ]);

        return redirect()->route('grades.show', ['grade' => $grade->id]);

    }

    public function destroy(Grade $grade)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $grade->delete();

        return redirect()->route('grades.index');

    }

    public function subject(Grade $grade, Subject $subject)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Grades/Subject', [
            'grade' => $grade,
            'subject' => $subject,
            'lessons' => Lesson::where('subject_id', $subject->id)->where('grade_id', $grade->id)->get()
        ]);
    }
}
