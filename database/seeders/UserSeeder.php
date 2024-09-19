<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::create([
            'id' => '9c34b75a-54b6-4299-8bdb-f37cd04ce247',
            'name' => 'Ping',
            'email' => 'ping@ping.com',
            'password' => Hash::make('123456'),
            'is_admin' => true,
            'team_id' => Str::uuid(),
        ]);
    }
}
