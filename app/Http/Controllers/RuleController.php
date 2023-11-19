<?php

namespace App\Http\Controllers;

use App\Models\QuestionType;
use App\Models\Rule;
use App\Models\TestType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RuleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'count' => ['required', 'numeric'],
            'test_type' => ['required']
        ]);

        Rule::create([
            'question_type_id' => QuestionType::where('title', '=', $request->question)->first()->id,
            'count' => $request->count,
            'test_type_id' => $request->test_type
        ]);

        return to_route('testTypes.show', ['testType' => $request->test_type])
            ->with('message', 'Rule added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rule $rule)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $rule->delete();
        return back()->with('message', 'Rule is deleted successfully');
    }
}
