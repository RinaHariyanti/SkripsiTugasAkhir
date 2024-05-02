<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Harga', 'kind' => 'cost'],
            ['name' => 'Dosis', 'kind' => 'cost'],
            ['name' => 'Luas Cakupan', 'kind' => 'benefit'],
            ['name' => 'Banyak Penyakit', 'kind' => 'benefit'],
            ['name' => 'Daya Tahan Simpan', 'kind' => 'benefit'],
            ['name' => 'Ukuran', 'kind' => 'cost'],
        ];

        foreach ($data as $item) {
            \App\Models\Criteria::create($item);
        }
    }
}
