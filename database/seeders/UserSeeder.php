<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Test User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
            ]
        ];

        foreach ($data as $item) {
            \App\Models\User::create($item);
        }
    }
}
