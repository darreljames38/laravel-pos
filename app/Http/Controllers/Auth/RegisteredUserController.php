<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration page.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Normalize the email before validating and saving it.
        $request->merge([
            'email' => strtolower(
                trim((string) $request->input('email'))
            ),
        ]);

        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
                'ends_with:@gmail.com',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $user = User::create([
            'full_name' => trim($validated['full_name']),
            'username' => trim($validated['username']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}