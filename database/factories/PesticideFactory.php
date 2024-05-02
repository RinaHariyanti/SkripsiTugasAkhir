<?php

namespace Database\Factories;

use App\Models\Pesticide;
use App\Models\Criteria;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesticideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pesticide::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Buat terlebih dahulu entitas Criteria baru
        $criteria = Criteria::factory()->create();

        return [
            'name' => $this->faker->name,
        ];
    }
}
