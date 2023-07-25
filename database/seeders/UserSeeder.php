<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->email('admin@gmail.com')
            ->password(Hash::make('referral123'.env('SALT_VALUE')))
            ->role(1)
            ->create();
    }
}
