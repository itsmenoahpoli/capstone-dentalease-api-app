<?php

namespace App\Services\Users;

use Illuminate\Support\Str;
use App\Models\Users\UserSession;

class UserSessionsService
{
    public function start_session($user_id, $request_data)
    {
        $session_no = Str::random(10);
        $ip_address = $request_data->ip();
        $device = $request_data->userAgent();
        $signin_at = now();

        $session = UserSession::query()->create([
            'session_no'  => $session_no,
            'ip_address'  => $ip_address,
            'device'      => $device,
            'signin_at'   => $signin_at,
            'user_id'     => $user_id,
        ]);

        return $session;
    }

    public function end_session($session_id)
    {
        $session = UserSession::query()->findOrFail($session_id);
        $session->update([
            'signout_at' => now(),
        ]);

        return $session->fresh();
    }
}
