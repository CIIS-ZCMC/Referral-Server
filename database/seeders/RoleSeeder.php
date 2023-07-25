<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()
            ->name('Admin')
            ->create();

        Role::factory()
            ->name('Opcen')
            ->create();
            
        Role::factory()
            ->name('referringFacilities')
            ->create();
            
        Role::factory()
            ->name('Nurse')
            ->create();
            
        Role::factory()
            ->name('Pretriage')
            ->create();
            
        Role::factory()
            ->name('ipcc')
            ->create();
            
        Role::factory()
            ->name('admission')
            ->create();
    }
}
