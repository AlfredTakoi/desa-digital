<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyMember>
 */
class FamilyMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            "head_of_family_id" => \App\Models\HeadOfFamily::factory(),
            'profile_picture' => $this->faker->imageUrl(640, 480, 'people'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', 'now'),
            'identity_number' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'occupation' => $this->faker->jobTitle(),
            'relation' => $this->faker->randomElement(['wife', 'child','husband']),
        ];
    }
}
