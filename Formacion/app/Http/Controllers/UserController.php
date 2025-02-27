<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function api_register(Request $request)
    {
        // Si el usuario ya existe, devolver un error
        if (User::where('email', $request->email)->first()) {
            return response()->json(['message' => 'User already exists'], 409);
        }

        $request->validate([
            'dni' => 'required|string|unique:users,dni',
            'name' => 'required|string',
            'surnames' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'role' => 'required|in:student,teacher,admin',
        ]);

        $user = User::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'surnames' => $request->surnames,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'role' => $request->role,
        ]);

        // Generar un token al registrarse
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function api_login(Request $request)
    {
        // SI el usuario no existe, devolver un error
        if (!User::where('email', $request->email)->first()) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verifica si el usuario existe
        $user = User::where('email', $request->email)->first();
        if (!$user || !Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Generar un nuevo token
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }


    public function api_show_registrations($dni)
    {
        $user = User::where('dni', $dni)->firstOrFail();
        $registrations = $user->registrations;
        return RegistrationResource::collection($registrations);
    }

    public function api_delete_registration($dni, $course_id)
    {
        $registration = Registration::where('user_id', $dni)
            ->where('course_id', $course_id)
            ->firstOrFail();

        $this->authorize('delete', $registration);

        $registration->delete();
        return response()->json(null, 204);
    }

}
