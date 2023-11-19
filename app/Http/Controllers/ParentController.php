<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParentController extends Controller
{
    public function index()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Users/Parents/Index', [
            'parents' => User::where('type', '=', 'parent')->get()
        ]);
    }

    public function show(string $user_id)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return Inertia::render('Users/Parents/Show', [
            'parent' => User::with(['children'])->find($user_id)
        ]);

    }
}
