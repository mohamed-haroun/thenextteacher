<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->numberBetween(1,4),
            'title' => fake()->sentence,
            'chapter' => fake()->numberBetween(1, 5),
            'term' => 'first',
            'subject_id' => '2',
            'grade_id' => '4'
        ];
    }
}
