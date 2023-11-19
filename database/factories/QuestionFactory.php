<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'answer' => fake()->sentence,
            'rating' => fake()->numberBetween(1, 5),
            'question_type_id' => fake()->numberBetween(1, 8),
            'lesson_id' => fake()->numberBetween(1, 4),
            'user_id' => fake()->numerify("1")
        ];
    }
}
