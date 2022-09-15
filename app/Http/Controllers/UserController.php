<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function update(UserRequest $request, User $user): UserResource
    {
        $user->update($request->validated());

        return new UserResource($user->fresh());
    }
}
