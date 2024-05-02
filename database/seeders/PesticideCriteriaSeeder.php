<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesticideCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['pesticide_id' => 1, 'criteria_id' => 1, 'description' => 'Harga pestisida A dalam Rupiah'],
            ['pesticide_id' => 1, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida A'],
            ['pesticide_id' => 1, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida A'],
            ['pesticide_id' => 1, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida A'],
            ['pesticide_id' => 1, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida A sebelum kehilangan efektivitas'],
            ['pesticide_id' => 1, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida A'],

            ['pesticide_id' => 2, 'criteria_id' => 1, 'description' => 'Harga pestisida B dalam Rupiah'],
            ['pesticide_id' => 2, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida B'],
            ['pesticide_id' => 2, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida B'],
            ['pesticide_id' => 2, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida B'],
            ['pesticide_id' => 2, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida B sebelum kehilangan efektivitas'],
            ['pesticide_id' => 2, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida B'],

            ['pesticide_id' => 3, 'criteria_id' => 1, 'description' => 'Harga pestisida C dalam Rupiah'],
            ['pesticide_id' => 3, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida C'],
            ['pesticide_id' => 3, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida C'],
            ['pesticide_id' => 3, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida C'],
            ['pesticide_id' => 3, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida C sebelum kehilangan efektivitas'],
            ['pesticide_id' => 3, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida C'],

            ['pesticide_id' => 4, 'criteria_id' => 1, 'description' => 'Harga pestisida D dalam Rupiah'],
            ['pesticide_id' => 4, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida D'],
            ['pesticide_id' => 4, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida D'],
            ['pesticide_id' => 4, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida D'],
            ['pesticide_id' => 4, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida D sebelum kehilangan efektivitas'],
            ['pesticide_id' => 4, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida D'],

            ['pesticide_id' => 5, 'criteria_id' => 1, 'description' => 'Harga pestisida E dalam Rupiah'],
            ['pesticide_id' => 5, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida E'],
            ['pesticide_id' => 5, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida E'],
            ['pesticide_id' => 5, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida E'],
            ['pesticide_id' => 5, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida E sebelum kehilangan efektivitas'],
            ['pesticide_id' => 5, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida E'],

            ['pesticide_id' => 6, 'criteria_id' => 1, 'description' => 'Harga pestisida F dalam Rupiah'],
            ['pesticide_id' => 6, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida F'],
            ['pesticide_id' => 6, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida F'],
            ['pesticide_id' => 6, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida F'],
            ['pesticide_id' => 6, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida F sebelum kehilangan efektivitas'],
            ['pesticide_id' => 6, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida F'],

            ['pesticide_id' => 7, 'criteria_id' => 1, 'description' => 'Harga pestisida G dalam Rupiah'],
            ['pesticide_id' => 7, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida G'],
            ['pesticide_id' => 7, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida G'],
            ['pesticide_id' => 7, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida G'],
            ['pesticide_id' => 7, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida G sebelum kehilangan efektivitas'],
            ['pesticide_id' => 7, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida G'],

            ['pesticide_id' => 8, 'criteria_id' => 1, 'description' => 'Harga pestisida H dalam Rupiah'],
            ['pesticide_id' => 8, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida H'],
            ['pesticide_id' => 8, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida H'],
            ['pesticide_id' => 8, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida H'],
            ['pesticide_id' => 8, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida H sebelum kehilangan efektivitas'],
            ['pesticide_id' => 8, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida H'],

            ['pesticide_id' => 9, 'criteria_id' => 1, 'description' => 'Harga pestisida I dalam Rupiah'],
            ['pesticide_id' => 9, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida I'],
            ['pesticide_id' => 9, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida I'],
            ['pesticide_id' => 9, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida I'],
            ['pesticide_id' => 9, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida I sebelum kehilangan efektivitas'],
            ['pesticide_id' => 9, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida I'],

            ['pesticide_id' => 10, 'criteria_id' => 1, 'description' => 'Harga pestisida J dalam Rupiah'],
            ['pesticide_id' => 10, 'criteria_id' => 2, 'description' => 'Dosis yang direkomendasikan untuk pestisida J'],
            ['pesticide_id' => 10, 'criteria_id' => 3, 'description' => 'Luas area yang dapat dicakup oleh pestisida J'],
            ['pesticide_id' => 10, 'criteria_id' => 4, 'description' => 'Jumlah penyakit yang dapat diatasi oleh pestisida J'],
            ['pesticide_id' => 10, 'criteria_id' => 5, 'description' => 'Periode waktu penyimpanan pestisida J sebelum kehilangan efektivitas'],
            ['pesticide_id' => 10, 'criteria_id' => 6, 'description' => 'Ukuran kemasan atau kuantitas pestisida J'],
        ];

        foreach ($data as $item) {
            \App\Models\PesticideCriteria::create($item);
        }
    }
}
