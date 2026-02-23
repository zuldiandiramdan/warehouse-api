<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class ApiAuthController extends Controller
{
    #[OA\Post(
        path: '/api/register',
        tags: ['Auth'],
        summary: 'Register a new user',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'secret123'),
                ],
                required: ['name', 'email', 'password', 'password_confirmation']
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'User successfully registered',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'user',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                                new OA\Property(property: 'email', type: 'string', example: 'john@example.com'),
                            ]
                        ),
                        new OA\Property(property: 'token', type: 'string', example: '1|abc123xyz'),
                        new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'errors',
                            type: 'object',
                            example: [
                                'email' => ['The email has already been taken.'],
                                'password' => ['The password must be at least 6 characters.'],
                            ]
                        )
                    ]
                )
            )
        ]
    )]
    public function register(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => Hash::make($attrs['password']),
        ]);

        return response()->json($user, 201);
    }

    #[OA\Post(
        path: '/api/login',
        tags: ['Auth'],
        summary: 'Login user and generate API token',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123'),
                ],
                required: ['email', 'password']
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful login with token',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string', example: '1|abc123xyz'),
                        new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Invalid credentials',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Invalid credentials'),
                    ]
                )
            )
        ]
    )]
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Invalid credentials']]);
        }

        $user->tokens()
            ->where('expires_at', '<', now())
            ->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    #[OA\Post(
        path: '/api/logout',
        tags: ['Auth'],
        summary: 'Logout user and revoke API token',
        security: [['sanctum' => []]], // token auth
        responses: [
            new OA\Response(
                response: 200,
                description: 'Token revoked successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Token revoked'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated'),
                    ]
                )
            )
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Token revoked']);
    }
}
