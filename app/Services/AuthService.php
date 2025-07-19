<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Services\Users\UserSessionsService;

class AuthService
{
    public function __construct(
        private UserSessionsService $userSessionsService
    ) {}

    public function sign_in($credentials, $request_data)
    {
        if (!Auth::attempt($credentials))
        {
            throw new UnauthorizedHttpException('Bearer', 'INVALID_CREDENTIALS');
        }

        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->load('user_role');
        $token = $user->createToken($user->email.$user->id)->plainTextToken;
        $session = $this->userSessionsService->start_session($user->id, $request_data);

        return [
            'user'      => [
                'email'     => $user->email,
                'name'      => $user->name,
                'role'      => $user->user_role->name,
            ],
            'session'   => $session->session_no,
            'token'     => $token,
        ];
    }

    public function sign_out($user, $session_id)
    {
        $this->userSessionsService->end_session($session_id);
        $user->currentAccessToken()->delete();

        return true;
    }
}
