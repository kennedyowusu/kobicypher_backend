<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
            'category_id' => $this->faker->numberBetween(1, 5),
            'author' => $this->faker->name(),
            'isFeatured' => $this->faker->boolean(),
        ];
    }
}
