<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users\UserRole;

class UserRolesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['administrator', 'staff', 'patient'];

        foreach ($roles as $role)
        {
            UserRole::query()->create([
                'name' => $role,
            ]);
        }
    }
}
