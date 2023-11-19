<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Users/Teachers/Index', [
            'teachers' => Teacher::with('user', 'subject')->get()
        ]);
    }

    public function show(Teacher $teacher)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Users/Teachers/Show', [
            'teacher' => $teacher->with(['user', 'subject'])->find($teacher->id),
            'subjects' => Subject::all()
        ]);
    }

    public function exam()
    {
        if (! auth()->user()->hasRole('admin') || !auth()->user()->hasRole('teacher')) {
            abort(403);
        }
        return Inertia::render('Users/Teachers/Exam', [
            'grades' => Grade::all()
        ]);
    }
}
