<?php

namespace Database\Factories;

use App\Models\Lot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotFactory extends Factory
{
    protected $model = Lot::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'start_price' => $this->faker->randomFloat(2,1, 100),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
