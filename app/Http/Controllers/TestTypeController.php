<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\QuestionType;
use App\Models\Subject;
use App\Models\TestType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Tests/Types/Index', [
            'types' => TestType::with(['grade', 'subject'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Tests/Types/Create', [
            'grades' => Grade::all(),
            'types' => [
                ['title' => 'exam'],
                ['title' => 'quiz'],
                ['title' => 'revision'],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $request->validate([
            'grade' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $testType = TestType::create([
            'title' => $request->type,
            'subject_id' => Subject::where('title', '=', $request->subject)->first()->id,
            'grade_id' => Grade::where('title', '=', $request->grade)->first()->id,
        ]);

        return to_route('testTypes.show', ['testType' => $testType])->with('message', 'Created Successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TestType $testType)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Tests/Types/Show', [
            'testType' => TestType::with(['grade', 'subject', 'rules.question_type'])->find($testType->id),
            'question_types' => QuestionType::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestType $testType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestType $testType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestType $testType)
    {
        //
    }
}
