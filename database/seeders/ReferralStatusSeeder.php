<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ReferralStatus;

class ReferralStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReferralStatus::factory()
            ->name('Pending')
            ->created_at(now())
            ->updated_at(now())
            ->create();
            
        ReferralStatus::factory()
            ->name('Reviewed/Viewed')
            ->created_at(now())
            ->updated_at(now())
            ->create();
            
        ReferralStatus::factory()
            ->name('Accepted')
            ->created_at(now())
            ->updated_at(now())
            ->create();
            
        ReferralStatus::factory()
            ->name('Arrived')
            ->created_at(now())
            ->updated_at(now())
            ->create();
            
        ReferralStatus::factory()
            ->name('Admitted')
            ->created_at(now())
            ->updated_at(now())
            ->create();
            
        ReferralStatus::factory()
            ->name('Discharged')
            ->created_at(now())
            ->updated_at(now())
            ->create();
            
        ReferralStatus::factory()
            ->name('Transferred')
            ->created_at(now())
            ->updated_at(now())
            ->create();
            
        ReferralStatus::factory()
            ->name('Cancel')
            ->created_at(now())
            ->updated_at(now())
            ->create();
    }
}
