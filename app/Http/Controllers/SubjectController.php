<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\SubjectGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index()
    {

        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Subjects/Index', [
            'subjects' => Subject::with('grades')->get(),
            'grades' => Grade::all()
        ]);
    }

    public function show(Subject $subject)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Subjects/Show', [
            'subject' => Subject::with(['lessons', 'grades', 'teachers'])->find($subject->id),
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
        $request->validate([
            'title' => 'required|string',
            'grades' => 'required',
            'lang' => 'required'
        ]);

        $subject = Subject::create([
            'title' => $request->title,
            'school_lang' => strtolower($request->lang)
        ]);

        $grades = $request->grades;

        foreach($grades as $grade) {
            SubjectGrade::create([
                'subject_id' => $subject->id,
                'grade_id' => Grade::where('title', '=', $grade)->first()->id,
            ]);
        }

        return Redirect::route('subjects.index');
    }


    public function edit(Subject $subject)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Subjects/Edit', [
            'subject' => Subject::with('grades')->where('id', $subject->id)->first(),
            'grades' => Grade::all()
        ]);
    }

    public function update(Subject $subject, Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string',
            'lang' => 'required'
        ]);

        $subject->update([
            'title' => $request->title,
            'school_lang' => strtolower($request->lang)
        ]);

        SubjectGrade::where('subject_id', '=' ,$subject->id)->delete();

        $grades = $request->grades;

        foreach($grades as $grade) {
            if (is_array($grade)) {
                $grade = $grade['title'];
            }

            SubjectGrade::create([
                'subject_id' => $subject->id,
                'grade_id' => Grade::where('title', '=', $grade)->first()->id,
            ]);
        }

        return redirect()->route('subjects.show', ['subject' => $subject]);

    }

    public function destroy(Subject $subject)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $subject->delete();

        return redirect()->route('subjects.index');

    }
}
