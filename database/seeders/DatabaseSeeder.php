<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'demo',
            'email' => 'demo@demo.com',
            'password' => Hash::make('demo'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);


    }
}
