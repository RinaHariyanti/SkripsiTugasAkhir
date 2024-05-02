<?php

namespace Database\Factories;

use App\Models\Pesticide;
use App\Models\Criteria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PesticideCriteria>
 */
class PesticideCriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pesticide_id' => Pesticide::factory()->create()->id,
            'criteria_id' => Criteria::factory()->create()->id,
            'description' => $this->faker->sentence,
        ];
    }
}
