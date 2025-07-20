<?php

namespace App\Services\Users;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Services\Users\UsersService;
use App\Models\Users\UserOtp;

class UserOtpsService
{
    public function __construct(
        public UserOtp $userOtp,
        public UsersService $usersService
    ) {}

    public function create_otp($email, $type)
    {
        $user = $this->usersService->find_by_email($email);

        if (!$user)
        {
            throw new UnauthorizedHttpException('Bearer', 'INVALID_EMAIL');
        }

        $otp = $this->userOtp->query()->create([
            'user_id' => $user->id,
            'email'   => $email,
            'otp'     => random_int(100000, 999999),
            'type'    => $type,
        ]);

        return $otp;
    }

    public function verify_otp($email, $otp)
    {
        $otp = $this->userOtp->query()
            ->where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp)
        {
            throw new UnauthorizedHttpException('Bearer', 'INVALID_OTP');
        }

        return true;
    }
}
