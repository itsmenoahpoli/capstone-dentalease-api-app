<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Users\UserRole;
use App\Models\User;

class UsersSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = UserRole::query()->get();

        foreach ($roles as $role)
        {
            $role_name = strtolower($role->name);

            User::query()->create([
                'name'          => $role_name,
                'email'         => $role_name.'@dentalease.com',
                'password'      => Hash::make('password'),
                'user_role_id'  => $role->id,
            ]);
        }
    }
}
