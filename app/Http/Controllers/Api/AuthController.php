<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthController
 *
 * Controller for handling authentication-related actions using Laravel Sanctum.
 */
class AuthController extends Controller
{
    /**
     * Register a new user and return an authentication token.
     *
     * @param AuthRequest $request The request containing user registration data.
     * @return JsonResponse The response containing the authentication token.
     */
    public function register(AuthRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * Log in a user and return an authentication token.
     *
     * @param AuthRequest $request The request containing login credentials.
     * @return JsonResponse The response containing the authentication token.
     */
    public function login(AuthRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Change the authenticated user's password.
     *
     * @param AuthRequest $request The request containing the current and new passwords.
     * @return JsonResponse The response indicating the success of the password change.
     * @throws ValidationException If the current password is incorrect.
     */
    public function changePassword(AuthRequest $request): JsonResponse
    {
        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'La contraseña actual no es correcta.',
            ], 404);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada exitosamente.'], 200);
    }

    /**
     * Log out the authenticated user by deleting their tokens.
     *
     * @return JsonResponse The response indicating the success of the logout.
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ], 200);
    }
}
