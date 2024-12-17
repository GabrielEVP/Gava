<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

/**
 * Class AuthController
 *
 * Controller for handling authentication-related actions.
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
        $user = User::create($request->all());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Log in a user and return an authentication token.
     *
     * @param AuthRequest $request The request containing login credentials.
     * @return JsonResponse The response containing the authentication token.
     */

    public function login(AuthRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Generar token de acceso
            $token = $user->createToken('Access_Token')->accessToken;

            return response()->json(['access_token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
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
            abort(404, 'La contraseña actual no es correcta.');
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
        ]);
    }
}
