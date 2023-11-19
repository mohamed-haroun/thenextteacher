<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

//        dd($request->all());

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'gender' => 'required|string',
            'birth_date' => 'required|date',
            'governorate' => 'required',
            'city' => 'required',
            'type' => 'required|string',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $governorate = $request->governorate['governorate_name_en'];
        $city = $request->city['city_name_en'];

//        dd($governorate);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'governorate' => $governorate,
            'gender' => $request->gender,
            'city' => $city,
            'phone_number' => $request->phone_number,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        Auth::login($user);

        if ($user->email === 'mohamedharoun230@gmail.com') {
            $user->assignRole('admin');
            $user->assignRole('teacher');
        } else {
            $user->assignRole('user');
            if ($user->type === 'teacher') {
                $user->assignRole('teacher');
            } elseif ($user->type === 'student') {
                $user->assignRole('student');
            } else {
                $user->assignRole('parent');
            }
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
