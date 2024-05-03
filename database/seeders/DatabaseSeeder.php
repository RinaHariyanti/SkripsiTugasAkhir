<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Criteria::factory(10)->create();
        // \App\Models\Pesticide::factory(10)->create();
        // \App\Models\PesticideCriteria::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CriteriaSeeder::class,
            PesticideSeeder::class,
            PesticideCriteriaSeeder::class,
            UserSeeder::class,
        ]);
    }
}
