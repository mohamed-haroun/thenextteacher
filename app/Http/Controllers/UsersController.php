<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }


        return Inertia::render('Users/Index', [
            'users' => User::all(),
            'teachers' => Teacher::get()->count(),
            'students' => Student::get()->count(),
            'parents' => User::where('type', '=', 'parent')->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->type === 'teacher') {
           $user = User::with(['teacher.subject'])->find($user->id);
        } else {
            $user = User::with(['student.grade'])->find($user->id);
        }

        return Inertia::render('Users/Show', [
            'user' => $user,
            'subjects' => Subject::all(),
            'grades' => Grade::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addSubject(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255'
        ]);

        $subject = Subject::where('title', $request->subject)->first();

        Teacher::create(['user_id' => $request->user['id'], 'subject_id' => $subject->id]);

        return to_route('profile', ['user' => $request->user['id']]);

    }

    public function addGrade(Request $request)
    {
        $request->validate([
            'grade' => 'required|string|max:255'
        ]);

        $grade = Grade::where('title', $request->grade)->first();

        Student::create(['user_id' => $request->user['id'], 'grade_id' => $grade->id]);

        return to_route('profile', ['user' => $request->user['id']]);
    }

}
