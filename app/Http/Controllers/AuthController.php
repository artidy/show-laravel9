<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param UserRequest $request
     * @return JsonResponse|Responsable
     */
    public function register(UserRequest $request): Responsable|JsonResponse
    {
        $params = $request->safe()->except('file');
        $user = User::create($params);
        $token = $user->createToken('auth-token');

        return new AuthResource([
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse|Responsable
     */
    public function login(LoginRequest $request): Responsable|JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            abort(401, trans('auth.failed'));
        }

        $token = Auth::user()->createToken('auth-token');

        return new AuthResource(['token' => $token->plainTextToken]);
    }

    /**
     * @return JsonResponse|Responsable
     */
    public function logout(): Responsable|JsonResponse
    {
        Auth::user()->tokens()->delete();

        return new AuthResource(null);
    }
}
