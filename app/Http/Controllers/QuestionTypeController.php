<?php

namespace App\Http\Controllers;

use App\Models\QuestionType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Nette\Utils\Type;

class QuestionTypeController extends Controller
{

    public function index()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Questions/Types/Index', [
            'types' => QuestionType::all()
        ]);
    }

    public function show(QuestionType $type)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Questions/Types/Show',[
            'type' => $type
        ]);
    }

    public function store(Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $type_data = $request->validate([
            'title' => 'required|string|max:255',
            'header' => 'nullable|string|max:255'
        ]);

        QuestionType::create($type_data);
        return to_route('types.index')->with('message', 'created Successfully!!');
    }

    public function edit(QuestionType $type)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Questions/Types/Edit',[
            'type' => $type
        ]);
    }

    public function update(QuestionType $type ,Request $request)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $type_data = $request->validate([
            'title' => 'required|string|max:255',
            'header' => 'nullable|string|max:255'
        ]);

        $type->updateOrFail($type_data);
        return to_route('types.show', ['type'=>$type])->with('message', 'Updated Successfully!!');
    }

    public function destroy(QuestionType $type)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $type->delete();

        return to_route('types.index')->with('message', 'Deleted successfully');
    }

}
