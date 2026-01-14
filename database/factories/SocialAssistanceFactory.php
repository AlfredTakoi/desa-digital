<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistance>
 */
class SocialAssistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'thumbnail' => $this->faker->imageUrl(),
            'name' => $this->faker->randomElement([
                'Bantuan Pangan Non Tunai',
                'Bantuan Sosial Tunai',
                'Bantuan Subsidi Listrik',
                'Bantuan Iuran BPJS Kesehatan',
                'Bantuan Pendidikan',
            ]) . ' ' . $this->faker->company(),
            'category' => $this->faker->randomElement(['staple','cash','subsidized fuel','health']),
            'amount' => $this->faker->randomFloat(2, 10000, 100000),
            'provider' => $this->faker->company,
            'description' => $this->faker->paragraph(),
            'is_available' => $this->faker->boolean(80), 
        ];
    }
}
