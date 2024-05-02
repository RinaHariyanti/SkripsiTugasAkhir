<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesticideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Antracol 70WP'],
            ['name' => 'Bion M 1/70WP'],
            ['name' => 'Score 250 EC'],
            ['name' => 'Pegasus 5000 SC'],
            ['name' => 'Curacron 500 EC'],
            ['name' => 'Furadan 3G'],
            ['name' => 'Regent 50 SC'],
            ['name' => 'Karate 5 EC'],
            ['name' => 'Decis 2.5 EC'],
            ['name' => 'Confidor 200 SL'],
        ];

        foreach ($data as $item) {
            \App\Models\Pesticide::create($item);
        }
    }
}
