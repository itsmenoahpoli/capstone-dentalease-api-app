<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Services\Users\{UserSessionsService, UserOtpsService};

class AuthService
{
    public function __construct(
        public UserSessionsService $userSessionsService,
        public UserOtpsService $userOtpsService
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

    public function request_otp($data)
    {
        $otp = $this->userOtpsService->create_otp($data['email'], $data['type']);

        return $otp;
    }

    public function verify_otp($data)
    {
        $this->userOtpsService->verify_otp($data['email'], $data['otp']);

        return true;
    }
}
