<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\EventModel;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventModel::factory()
            ->name('referralEvent')
            ->hash(Hash::make('referralEvent'))
            ->create();
        
        EventModel::factory()
            ->name('admissionEvent')
            ->hash(Hash::make('admissionEvent'))
            ->create();
        
        EventModel::factory()
            ->name('userEvent')
            ->hash(Hash::make('userEvent'))
            ->create();
    }
}
