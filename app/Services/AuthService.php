<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    public function signin($credentials)
    {
        if (!Auth::attempt($credentials))
        {
            throw new UnauthorizedHttpException('Bearer', 'INVALID_CREDENTIALS');
        }

        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $token = $user->createToken($user->email.$user->id)->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
