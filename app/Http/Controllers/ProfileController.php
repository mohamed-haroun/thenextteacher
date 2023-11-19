<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    public function profile() {
        if (auth()->user()->type === 'student') {
            $student = Student::with(['user.tests.test_type', 'user.tests.studentAnswers', 'user.tests.questions', 'grade.subjects'])->where('user_id', '=', auth()->user()->id)->first();
            if ($student) {
                return Inertia::render('Users/Students/Show', [
                    'student' => $student,
                    'grades' => Grade::all()
                ]);
            } else {
                return Inertia::render('Users/Show', [
                    'user' => auth()->user(),
                    'grades' => Grade::all()
                ]);
            }

        } elseif(auth()->user()->type === 'teacher') {

            $teacher = Teacher::with(['user.tests.test_type', 'subject.grades', 'user.tests.questions', 'subject.grades'])->where('user_id', '=', auth()->user()->id)->first();

            if ($teacher) {
                return Inertia::render('Users/Teachers/Show', [
                    'teacher' => $teacher,
                    'subjects' => Subject::all()
                ]);
            } else {
                return Inertia::render('Users/Show', [
                    'user' => auth()->user(),
                    'subjects' => Subject::all()
                ]);
            }

        } else {
            return Inertia::render('Users/Parents/Show', [
                'parent' => User::with(['children'])->find(auth()->user()->id)
            ]);
        }
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
