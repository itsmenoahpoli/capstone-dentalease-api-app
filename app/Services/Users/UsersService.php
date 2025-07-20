<?php

namespace App\Services\Users;

use App\Models\User;

class UsersService
{
    public function __construct(
        public User $user
    ) {}

    public function find_by_email($email)
    {
        $user = $this->user->query()->where('email', $email)->first();

        return $user;
    }
}
