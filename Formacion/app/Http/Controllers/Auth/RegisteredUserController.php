<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'dni' => 'required|string|unique:users,dni',
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'phone_number' => 'required|integer|min:9|max:9',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'role' => 'required|in:student', // Solo permite 'student' como rol
        ]);

        //Creación del usuario
        $user = User::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'surnames' => $request->surnames,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar la contraseña
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'role' => 'student', // Asegurar que siempre sea 'student'
        ]);


        event(new Registered($user));

        Auth::login($user);

        // Redirigir según el rol del usuario
        return redirect()->intended(route('index', absolute: false));

    }
}
